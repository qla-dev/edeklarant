<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Invoice;use Illuminate\Support\Facades\Log;

// A.K.A. dobavljac
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'owner',
        'address', 
        'avatar',
        'tax_id',
        'contact_email', 
        'contact_phone',
        'synonyms'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'synonyms' => 'array'
    ];
    

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAnnualProfitAvg()
{
    $now = Carbon::now();
    $created = Carbon::parse($this->created_at);

    $yearsActive = max($created->diffInYears($now), 1);

    $totalProfit = Invoice::where('supplier_id', $this->id)
                        ->sum('total_price');

    return round($totalProfit / $yearsActive, 2);
}

public function getLastYearProfit()
{
    $start = Carbon::now()->subYear()->startOfYear();
    $end = Carbon::now()->subYear()->endOfYear();

    return $this->invoices()
                ->whereBetween('date_of_issue', [$start, $end])
                ->sum('total_price');
}

public function getCurrentYearProfit()
{
    $start = Carbon::now()->startOfYear();   // January 1st this year
    $end = Carbon::now();                    // Today

    return $this->invoices()
                ->whereBetween('date_of_issue', [$start, $end])
                ->sum('total_price');
}

public function getProfitPercentageChange()
{
    $lastYear = $this->getLastYearProfit();
    $thisYear = $this->getCurrentYearProfit();

    // Avoid division by zero
    if ($lastYear == 0) {
        return $thisYear > 0 ? 100 : 0;
    }

    return (($thisYear - $lastYear) / $lastYear) * 100;
}

public static function findBySynonym(string $value): ?self
{
    return self::query()
        ->where('name', $value)
        ->orWhereJsonContains('synonyms', $value)
        ->first();
}



}

