<?php

namespace App\Jobs;

use App\Models\Task;
use App\Http\Clients\MockableHttpClient;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessUploadedFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?Client $client = null;

    public function __construct(public Task $task, Client $client = null)
    {
        if ($client !== null) {
            $this->client = $client;
        }
    }

    public function handle()
    {
        if ($this->client === null) {
            $this->client = new MockableHttpClient();
        }
        try {
            $this->task->markAsProcessing();

            // Step 1: Convert to markdown
            $this->task->update(['processing_step' => 'conversion']);
            $markdown = $this->convertToMarkdown();

            // Step 2: Extract data with LLM
            $this->task->update(['processing_step' => 'extraction']);
            $result = $this->extractWithLLM($markdown);

            // Step 3: Enrich with search API
            $this->task->update(['processing_step' => 'enrichment']);
            $enrichedItems = $this->enrichWithSearchAPI($result['items']);
            $result['items'] = $enrichedItems;

            $this->task->markAsCompleted($result);
        } catch (Exception $e) {
            $this->task->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    public function convertToMarkdown(): string
    {
        $markerUrl = getenv('MARKER_URL');

        if (empty($markerUrl)) {
            return $this->convertToMarkdownViaCli();
        }

        return $this->convertToMarkdownViaHttp();
    }

    protected function convertToMarkdownViaHttp(): string
    {
        $fileContent = Storage::get($this->task->file_path);

        $response = $this->client->post(getenv('MARKER_URL') . '/marker/upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $fileContent,
                    'filename' => $this->task->original_filename
                ],
                [
                    'name' => 'output_format',
                    'contents' => 'markdown'
                ],
                [
                    'name' => 'force_ocr',
                    'contents' => 'true'
                ],
                [
                    'name' => 'paginate_output',
                    'contents' => 'false'
                ]
            ]
        ]);

        $responseBody = $response->getBody()->getContents();
        $responseData = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);
        if (!isset($responseData['output'])) {
            throw new \RuntimeException('Invalid marker response format');
        }
        return $responseData['output'];
    }

    protected $processFactory;

    public function setProcessFactory(callable $factory): void
    {
        $this->processFactory = $factory;
    }

    protected function getProcessFactory(): callable
    {
        return $this->processFactory ?? function (array $command) {
            return new \Symfony\Component\Process\Process($command, timeout: null);
        };
    }

    protected function convertToMarkdownViaCli(): string
    {
        $filePath = Storage::path($this->task->file_path);
        $tempDir = sys_get_temp_dir();
        $command = [
            'marker_single',
            $filePath,
            '--output_format=markdown',
            '--output_dir=' . $tempDir,
            '--force_ocr'
        ];

        $process = ($this->getProcessFactory())($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Marker CLI failed: ' . $process->getErrorOutput());
        }

        // Get input filename without extension
        $inputFilename = pathinfo($filePath, PATHINFO_FILENAME);
        $outputDir = $tempDir . '/' . $inputFilename;
        $outputFile = $outputDir . '/' . $inputFilename . '.md';

        if (!file_exists($outputFile)) {
            throw new \RuntimeException('Marker output file not found: ' . $outputFile);
        }

        $output = file_get_contents($outputFile);

        // Clean up
        array_map('unlink', glob("$outputDir/*"));
        rmdir($outputDir);

        return $output;
    }

    private function extractWithLLM(string $markdown): array
    {
        $response = $this->client->post(getenv('OLLAMA_URL') . '/api/generate', [
            'json' => [
                'model' => getenv('OLLAMA_MODEL'),
                'prompt' => 
                    "Here's the markdown of invoice:\n\n```md\n$markdown\n```\n\n"
                    . file_get_contents(base_path("app/Jobs/prompt-markdown-to-json.txt")),
                'stream' => false,
                'options' => [
                    'temperature' => 0.1,
                    'num_predict' => 10000
                ]
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        // check if response data contains "error" key. If it does then raise exception with "message" key
        // if "message" key is unavailable then raise exception with generic message text
        if (isset($responseData['error'])) {
            throw new Exception($responseData['error']);
        }
        $ollamaResponse = $responseData['response'] ?? '';
        // Ensure ollamaResponse is a string between ```json and ```
        if (preg_match('/```json(.*?)```/s', $ollamaResponse, $matches)) {
            $ollamaResponse = trim($matches[1]);
        } elseif (preg_match('/```(.*?)```/s', $ollamaResponse, $matches)) {
            $ollamaResponse = trim($matches[1]);
        }

        $parsedResponse = json_decode($ollamaResponse, true);

        if ($parsedResponse === null) {
            throw new Exception('Unable to parse response. Full response: ' . $ollamaResponse);
        }

        // Process all string values in ['items'] and replace "\n" with "-"
        if (isset($parsedResponse['items']) && is_array($parsedResponse['items'])) {
            foreach ($parsedResponse['items'] as &$item) {
                if (is_array($item)) {
                    foreach ($item as $key => $value) {
                        if (is_string($value)) {
                            $item[$key] = str_replace("\n", " - ", $value);
                        }
                    }
                }
            }
        }

        return $parsedResponse;
    }

    private function enrichWithSearchAPI(array $items): array
    {
        $enriched = [];

        foreach ($items as $item) {
            if (!isset($item['item_name'])) {
                continue;
            }

            $response = $this->client->get(getenv('SEARCH_API_URL'), [
                'query' => ['query' => $item['item_name']]
            ]);

            $results = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            if (is_null($results))
                throw new Exception("unable to decode response from code search API");

            // Transform API response to expected format
            $item['detected_codes'] = $results;
            $enriched[] = $item;
        }

        return $enriched;
    }
}
