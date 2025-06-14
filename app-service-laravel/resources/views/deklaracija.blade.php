@extends('layouts.master')
@section('title')
@lang('translation.create-invoice')
@endsection
@section('css')
<!-- <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">-->
<!-- Sweet Alert css-->
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    
    /* Ensures the selected text is truncated with ellipsis and tooltip works */
    .select2-container--default .select2-results__options {
        max-width: none !important;

        /* or use 100% if you want it full-width */
        white-space: normal;

        /* allow wrapping of long lines */
    }

    .form-check-input:checked {
        background-color: #299dcb !important;
        border-color: #299dcb !important;
    }



    /* Optional: make the search input area full width too */
    .select2-container--default .select2-search--dropdown .select2-search__field {
        width: 100% !important;


    }

  

    .select2-container--default .select2-results>.select2-results__options {

        opacity: 1 !important;
        backdrop-filter: blur(4px);
        /* Optional: add blur for better visibility */
        border: 1px solid #ccc;
        /* Optional: for contrast if needed */
    }

    /* Hovered item (highlighted in dropdown with keyboard or mouse) */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #299cdb !important;
        /* or use your specific info color */
        color: white !important;
        /* text color to maintain contrast */
    }


    .detached-fixed-buttons {

        position: fixed !important;
        top: calc(70.8px + 40.5px);
        /* 110.91px total offset */
        margin-top: 6px;
        width: 13.19vw;

        z-index: 1050;
    }

    .custom-select-icon {
        /* Remove default arrow in some browsers */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;

        /* Add padding on right for the icon */
        padding-right: 2rem;

        /* Position relative to allow background positioning */
        position: relative;
        background-image: url('data:image/svg+xml;utf8,<svg fill="gray" height="16" viewBox="0 0 24 24" width="16" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        background-color: #f4f4fc;
        /* keep your bg */
    }



    .custom-swal-popup {
        padding-top: 1.5rem;
        padding-bottom: 1.5rem;
    }

    .custom-swal-spinner {
        margin: 0 auto;
        width: 32px;
        height: 32px;
        border: 3px solid #0dcaf0;
        /* Bootstrap info color */
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    .custom-select-icon:focus {
        box-shadow: none !important;
        /* Remove Bootstrap purple shadow */
        outline: none !important;
        /* Remove default outline */
        border-color: #299dcb;
        /* Optional: set border color to info blue */
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .table> :not(caption)>*>* {
        color: inherit !important;

        padding: .30rem .2rem !important;
    }

    table.table {

        visibility: visible !important;


    }

    thead th {
        background: #f1f1f1;


    }

    tbody td,
    tbody th {

        color: #333;


    }
</style>


@endsection
@section('content')

<div class="row justify-content-center mt-0 mb-3  content-desktop">
    <div class="col card paper-layout">
        <div id="invoice-form">
            <div class="card-header border-0 p-4 pb-0">
                <img src="{{ URL::asset('build/images/logo-light-ai.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="34">
                            <img src="{{ URL::asset('build/images/logo-dark-ai.png') }}" class="card-logo card-logo-light" alt="logo light" height="17">
                <div class="row g-4 justify-content-between py-4">
       <div class="col-6 col-md-3 col-mob">
        <div class="mt-4">
            <h6 class="text-muted text-uppercase fw-semibold">Moji podaci</h6>
            <input type="text" class="form-control mb-2" id="company-address" name="name" placeholder="Ime kompanije" disabled value="{{ Auth::user()->company['name'] ?? '' }}">
            <input type="text" class="form-control mb-2" id="company-id" name="zip" placeholder="ID kompanije" disabled value="{{ Auth::user()->company['id'] ?? '' }}">
            <input type="email" class="form-control mb-2" id="company-tel" name="tel" placeholder="Adresa" disabled value="{{ Auth::user()->company['address'] ?? '' }}">
            <p class="fs-12 text-muted m-0">
                Ovo su informacije o tvojoj kompaniji. Možete ih uvijek prilagoditi na 
                <a href="/profil" class="text-info">pregledu svog profila.</a>
            </p>
        </div>
    </div>

    <!-- Indentation Column -->
    <div class="d-none d-md-block col-md-6 mobile-landscape-hide"></div>

    <!-- Right Column: Invoice Info -->
    <div class="col-6 col-md-3 col-mob">
        <div class="mt-4">
            <h6 class="text-muted text-uppercase fw-semibold mt-1">Broj fakture</h6>
            <input type="text" class="form-control" id="invoice-no" name="invoice_no" placeholder="Unesite broj fakture">
        </div>

        <div style="margin-top: 1.85rem;">
            <h6 class="text-muted text-uppercase fw-semibold mt-1">Incoterm</h6>
            <select class="form-select mb-2 custom-select-icon incoterm2" name="incoterm" id="incoterm">
                <option value="" selected disabled>Izaberite</option>
                <option value="EXW">EXW</option>
                <option value="FCA">FCA</option>
                <option value="CPT">CPT</option>
                <option value="CIP">CIP</option>
                <option value="DAP">DAP</option>
                <option value="DPU">DPU</option>
                <option value="DDP">DDP</option>
                <option value="FAS">FAS</option>
                <option value="FOB">FOB</option>
                <option value="CFR">CFR</option>
                <option value="CIF">CIF</option>
            </select>
        </div>
    </div>
                </div>

              

            </div>
            <div class="card-body p-4 border-top border-top-dashed">
                <div class="row g-4">
                    <div class="col-6 text-start">

                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Klijent</h6>

                        <div class="mb-2">
                            <div style="display: flex;">
                                <button type="button" class="btn btn-sm btn-info mb-2 me-2 deklaracija-action-buttons" id="add-new-supplier"><i class="fas fa-wand-magic-sparkles fs-6 me-0 me-md-1"></i><span class="mobile-landscape-hide">Detektovani klijent iz baze</span></button>
                                <button type="button" class="btn btn-sm btn-soft-info mb-2 deklaracija-action-buttons" id="refill-supplier-ai"><i class="fa-regular fa-hand align-top me-0 me-md-1 korpica"></i><span class="mobile-landscape-hide">Ručni unos klijenta</span></button>
                            </div>
                            <select id="supplier-select2" class="form-select"></select>
                        </div>
                        <input type="text" class="form-control mb-2" id="billing-name" name="supplier_name" placeholder="Naziv klijenta">

                        <input type="text" class="form-control mb-2" id="billing-address-line-1" name="supplier_address" placeholder="Adresa klijenta">
                        <input type="text" class="form-control mb-2" id="billing-phone-no" name="supplier_phone" placeholder="Telefon klijenta">
                        <input type="text" class="form-control mb-2" id="billing-tax-no" name="supplier_tax" placeholder="VAT klijenta">
                        <input type="email" class="form-control mb-2" id="email" name="email" placeholder="Email klijenta">
                        <input type="email" class="form-control" id="supplier-owner" name="supplierOwner" placeholder="Vlasnik kompanije">
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="text-muted text-uppercase fw-semibold mb-3 text-end">Dobavljač</h6>

                        <div class="mb-2">
                            <div style="justify-content: end; display: flex;">
                                <button type="button" class="btn btn-sm btn-soft-info mb-2  me-2  deklaracija-action-buttons" id="refill-importer-ai"><i class="fa-regular fa-hand align-top me-0 me-md-1 korpica"></i><span class="mobile-landscape-hide">Detektovani dobavljač iz baze</span></button>
                                <button type="button" class="btn btn-sm btn-info mb-2 deklaracija-action-buttons" id="add-new-importer"><i class="fas fa-wand-magic-sparkles fs-6 me-0 me-md-1"></i><span class="mobile-landscape-hide">Ručni unos dobavljača</span></button>

                            </div>

                            <select id="importer-select2" class="form-select"></select>
                        </div>

                        <input type="text" class="form-control mb-2 text-end" id="carrier-name" name="dobavljačime" placeholder="Naziv dobavljača">

                        <input type="text" class="form-control mb-2 text-end" id="carrier-address" name="dobavljačadresa" placeholder="Adresa dobavljača">
                        <input type="text" class="form-control mb-2 text-end" id="carrier-tel" name="dobavljačtel" placeholder="Telefon dobavljača">
                        <input type="text" class="form-control mb-2 text-end" id="carrier-tax" name="dobavljačtel" placeholder="JIB dobavljača">
                        <input type="text" class="form-control mb-2 text-end" id="carrier-email" name="dobavljačtel" placeholder="Email dobavljača">
                        <input type="text" class="form-control mb-2 text-end" id="carrier-owner" name="carrierOwner" placeholder="Vlasnik kompanije">

                    </div>
                </div>
            </div>

            <div class="card-body p-4 border-top border-top-dashed">
                <div class="row g-4 mb-3">
                    <div class="col-4 text-start">
                        <label class="text-muted text-uppercase fw-semibold mb-1"># Deklaracije</label>
                        <input type="text" class="form-control" id="invoice-no1" name="invoice_no1" placeholder="Broj fakture" disabled>
                    </div>
                    <div class="col-4 text-center">
                        <label class="d-flex justify-content-center text-muted text-uppercase fw-semibold mb-1">Datum</label>
                        <input type="date" class="form-control" id="invoice-date" name="invoice_date">
                    </div>
                    <div class="col-4 text-end">
                        <label class="text-muted text-uppercase fw-semibold mb-1">Ukupan iznos</label>
                        <input type="text" class="form-control text-end" id="total-amount" name="total_amount" placeholder="0.00 KM" disabled>
                    </div>
                </div>
            </div>



            <div class="card-body p-4 border-top border-top-dashed">
                <div class="table-responsive">
                    <table class="table table-borderless text-center table-nowrap align-middle mb-0" id="products-table">
                        <thead class="table-active">
                            <tr>
                                <th style="width: 50px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">#</th>
                                <th style="width: 200px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Proizvodi </th>
                                <th style="width: 140px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Opis </th>
                                <th style="width: 140px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Tarifna oznaka</th>
                                <th style="width: 60px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Tip kvantiteta</th>
                                <th style="width:70px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Zemlja porijekla</th>
                                <th style="width:60px; text-align: center;vertical-align: middle; text-align: left; padding-bottom: 1rem;">Cijena</th>
                                <th style="width: 60px; text-align: center;vertical-align: middle;">
                                    Količina<br>
                                    <small style="font-weight: normal; font-size: 0.75rem; color: #666;">
                                        Broj paketa
                                    </small>
                                </th>

                                <th style="width:70px;vertical-align: middle; text-align: middle; padding-bottom: 1rem;">Ukupno</th>
                                <th style="width:20px;vertical-align: middle; text-align: end;">Ukloni <br>
                                    <small style="font-weight: normal; font-size: 0.75rem; color: #666;">
                                        Povlastica
                                    </small>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="newlink">

                        </tbody>
                        <tbody>
                            <tr class="text-end mt-3">
                                <td colspan="10" class="text-end mt-3">
                                    <button id="add-item" class="btn btn-info fw-medium mt-2">
                                        <i class="ri-add-fill me-1 align-bottom"></i> Dodaj proizvod
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="border-top border-top-dashed mt-2">
                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                        <tbody class="border-bottom-dashed">
                            <tr class="border-top border-top-dashed fs-15">
                                <th>Ukupan iznos</th>
                                <th class="text-end" id="modal-total-amount"> </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
    @include('components.fixed-sidebar')
</div>


 
<!-- Centered fullscreen warning message for mobile -->
<div class="content-mobile-warning d-none d-flex flex-column align-items-center justify-content-center text-center" style="height: 70vh;">
    <!-- Light theme icon -->
    <lord-icon
        id="rotate-icon-light"
        src="/build/images/rotate-phone.json"
        trigger="loop"
        colors="secondary:#299cdb"
        style="width:80px;height:80px;margin-bottom: 1rem;">
    </lord-icon>

    <!-- Dark theme icon -->
    <lord-icon
        id="rotate-icon-dark"
        src="/build/images/rotate-phone-dark.json"
        trigger="loop"
        colors="secondary:#299cdb"
        style="width:80px;height:80px;margin-bottom: 1rem; display: none;">
    </lord-icon>

    <div>
        <strong class="d-block mb-1">Molimo okreni uređaj horizontalno</strong>
        <span class="text-muted">da bi pristupio prikazu deklaracije</span>
    </div>
</div>

<div class="modal fade" id="aiSuggestionModal" tabindex="-1" aria-labelledby="aiSuggestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title d-flex align-items-center gap-2 text-white" id="aiSuggestionModalLabel">
                    <i class="fas fa-wand-magic-sparkles text-white"></i> Najbolji AI Prijedlozi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
            </div>
            <div class="modal-body" id="aiSuggestionsBody" style="padding: 1.5rem;">
                <div class="text-muted">Učitavanje prijedloga...</div>
                <!-- Prijedlozi će biti umetnuti ovdje putem JavaScript-a -->
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                    Zatvori
                </button>
            </div>
        </div>
    </div>
</div>






<!--end row-->
@endsection
@section('script')



<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>-->
<script src="{{ URL::asset('build/libs/cleave.js/cleave.min.js') }}"></script>
<!-- <script src="{{ URL::asset('build/js/pages/invoicecreate.init.js') }}"></script> -->
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{ URL::asset('build/js/declaration/fix-sidebar.js') }}"></script>
<script src="{{ URL::asset('build/js/declaration/action-buttons.js') }}"></script>
<script src="{{ URL::asset('build/js/declaration/swal-declaration-load.js') }}"></script>
<script src="{{ URL::asset('build/js/countries.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/bs.js"></script>

<script>
 

    let EditingMode = {{ isset($id) ? 'true' : 'false' }};

// Define and expose global_invoice_id globally
if (typeof window !== "undefined") {
  if (!EditingMode) {
    window.global_invoice_id = localStorage.getItem("scan_invoice_id");
    window.remainingScans = {!! json_encode(Auth::user()->getRemainingScans()) !!};
  } else {
    window.global_invoice_id = {!! isset($id) ? json_encode($id) : 0 !!};
  }
  
}

 
</script>




<!-- Scan and other logic script -->
<script>
    const isEditMode = false;


    if (isEditMode) {

        console.warn(" Edit mode detected – skipping scan/autofill script.");
        // Exit the script entirely
        // Note: Wrap the entire content below inside an IIFE or block
        // Or better – put all scan logic inside a condition
    } else {
        console.log(' Custom invoice JS loaded');

        function showRetryError(title, message) {
    Swal.fire({
        title: title,
        html: `<div class="text-danger">${message}</div>`,
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Pokušaj ponovo",
        cancelButtonText: "Odustani",
        reverseButtons: true, // ⬅️ Flip button positions
        customClass: {
            confirmButton: "btn btn-info",
            cancelButton: "btn btn-soft-info me-2"
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload(); // Reload page on "Pokušaj ponovo"
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            location.href = "/"; // Redirect ONLY if user clicked "Odustani"
        }
    });
}



        let _invoice_data = null;
        let processedTariffData = [];
        let globalAISuggestions = [];
        const remaining_scans = @json(Auth::user() -> getRemainingScans());





        // Add global flags
        window.forceNewSupplier = false;
        window.forceNewImporter = false;
        window.skipPrefillParties = false; // NEW: skip prefill after manual clear

        function getInvoiceId() {
            const id = window.global_invoice_id;
            console.log(" Invoice ID:", id);
            return id;
        }
        async function updateRemainingScans() {
            console.log(" updateRemainingScans() called ");

            if (!user?.id || !token) {
                console.warn("Missing user or token in updateRemainingScans");
                return;
            }

            // Use global value and decrease it
            const newRemaining = Math.max(0, remaining_scans - 1); // safe fallback to 0

            try {
                const response = await fetch(`/api/user-packages/users/${user.id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: `Bearer ${token}`,
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        remaining_scans: newRemaining
                    })
                });

                if (!response.ok) {
                    throw new Error(`PUT failed with status ${response.status}`);
                }

                const data = await response.json();
                console.log(" Scan count updated in backend:", data);

            } catch (err) {
                console.error(" Failed to update scan count:", err);
            }
        }




        function updateTotalAmount() {
            let total = 0;

            // Loop through all invoice rows
            document.querySelectorAll("#newlink tr.product").forEach(function(row) {
                const price = parseFloat(row.querySelector('input[name="price[]"]')?.value || 0);
                const quantity = parseFloat(row.querySelector('input[name="quantity[]"]')?.value || 0);
                total += price * quantity;
            });

            // Format as currency
            const formatted = `${total.toFixed(2)} KM`;

            // Set values in both places
            document.getElementById("total-amount").value = formatted;
            document.getElementById("modal-total-amount").textContent = formatted;
            document.getElementById("total-edit").textContent = formatted;

        }


        async function getInvoice() {
            if (!_invoice_data) {
                console.log(" Fetching invoice...");
                const res = await fetch(`/api/invoices/${getInvoiceId()}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    }
                });
                _invoice_data = await res.json();
                console.log(" Invoice data fetched:", _invoice_data);
            } else {
                console.log(" Using cached invoice data:", _invoice_data);
            }
            return _invoice_data;
        }



        async function startAiScan() {
            const taskId = getInvoiceId();

            if (!taskId) {
                console.warn("No task ID found in localStorage.");
                return false;
            }

            console.log("Starting AI scan for task ID:", taskId);

            //  Show loader inside scan function
          

            try {
                const response = await fetch(`/api/invoices/${taskId}/scan`, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    let errorText = "Nepoznata greška";
                    try {
                        const err = await response.json();
                        errorText = err?.error || errorText;
                    } catch (jsonErr) {
                        console.warn("Response nije u JSON formatu", jsonErr);
                    }

                    console.error("AI scan response greška:", errorText);
                    Swal.close();

                    showRetryError(
                        "Greška pri pokretanju skeniranja",
                        errorText,
                        () => startAiScan()
                    );

                    return false;
                }

                console.log("AI scan started successfully");
                return true;

            } catch (error) {
                console.error("AI scan fetch failed:", error);
                Swal.close();

                showRetryError(
                    "Greška pri komunikaciji",
                    error.message || "Nepoznata greška",
                    () => startAiScan()
                );

                return false;
            }
        }



        async function waitForAIResult(showLoader = true) {
            window.AI_SCAN_STARTED = true;
    const invoice_id = getInvoiceId();
    if (!invoice_id) return;

    let progress = 0; // Start at 0%
    let countdown = 50;
    let progressBar = null;
    let timerText = null;
    let fakeInterval = null;
    let countdownInterval = null;
    let lastStep = null;
    let stuckTimer = 0;

    const stepTextMap = {
        null: "Pokretanje AI tehnologije u pozadini",
        conversion: "Konvertovanje dokumenta u potreban format",
        extraction: "Obrada deklaracije pomoću AI tehnologije",
        enrichment: "Obogaćivanje podataka i generisanje deklaracije"
    };

    // Show loader Swal immediately
    if (showLoader) {
        document.getElementById('pre-ai-overlay')?.classList.add('d-none');

        Swal.fire({
            title: "Skeniranje",
            html: `
                <div class="custom-swal-spinner mb-3"></div>
                <div id="swal-status-message">Čeka na obradu</div>
                <div class="mt-3 w-100">
                    <div class="progress" style="height: 16px;">
                        <div id="scan-progress-bar"
                             class="progress-bar progress-bar-striped progress-bar-animated bg-info fw-bold text-white"
                             role="progressbar"
                             style="width: 0%; font-size: 0.85rem; line-height: 16px; transition: width 0.6s ease;"
                             aria-valuemin="0" aria-valuemax="100">0%
                        </div>
                    </div>
                    <div class="text-muted mt-1" style="font-size: 0.85rem;">
                        Preostalo vrijeme: <span id="scan-timer">50s</span>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false
        });

        await new Promise(r => setTimeout(r, 0));
        progressBar = document.getElementById("scan-progress-bar");
        timerText = document.getElementById("scan-timer");

        // Start continuous progress movement
        fakeInterval = setInterval(() => {
            if (progress < 95) { // Don't go above 95% until complete
                progress = Math.min(95, progress + 0.5);
                updateProgressBar(progress);
            }
        }, 1000);

        // Start countdown timer
        countdownInterval = setInterval(() => {
            countdown--;
            if (timerText) {
                timerText.textContent = `${countdown}s`;
            }
            // Reset countdown when it hits 5 seconds
            if (countdown <= 5) {
                countdown = 15;
                timerText.textContent = `${countdown}s`;
            }
        }, 1000);
        setTimeout(() => {
    const container = timerText?.parentElement;
    if (container) {
        const notice = document.createElement("div");
        notice.className = "text-muted mt-2";
        notice.style.fontSize = "0.82rem";
        notice.innerHTML = `Ovaj proces može završiti u pozadini. Prati progres kroz pregled <a href="/moje-deklaracije" class="text-info">mojih deklaracija.</a> Kada se završi skeniranje, status će preći u draft, te ćeš moći revizirati podatke i dalje manipulisati sa istim.`;
        container.appendChild(notice);
    }
}, 7000);
    }

    function updateProgressBar(value) {
        if (!progressBar) return;
        const clamped = Math.min(95, Math.max(0, value)); // Allow starting from 0%
        progressBar.style.width = `${clamped}%`;
        progressBar.innerHTML = `${Math.floor(clamped)}%`;
    }

    while (true) {
        let status, step, errorMsg;

        try {
            const res = await fetch(`/api/invoices/${invoice_id}/scan`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    Authorization: `Bearer ${token}`
                }
            });

            if (!res.ok) throw new Error(`Greška kod API poziva: ${res.status} ${res.statusText}`);
            const json = await res.json();

            status = json?.status?.status;
            step = json?.status?.processing_step;
            errorMsg = json?.status?.error_message;

            // Step progress logic
            const stepProgress = {
                conversion: 30,
                extraction: 50,
                enrichment: 80
            };
            const targetProgress = stepProgress[step] || 10;

            if (step !== lastStep) {
                stuckTimer = 0;
                progress = Math.max(progress, targetProgress);
                updateProgressBar(progress);
                lastStep = step;
            } else {
                stuckTimer++;
                if (stuckTimer >= 3) {
                    progress = Math.max(0, progress - 3); // bounce back but never below 0%
                    updateProgressBar(progress);
                    await new Promise(r => setTimeout(r, 500));
                    progress = Math.max(progress, targetProgress);
                    updateProgressBar(progress);
                    stuckTimer = 0;
                }
            }

        } catch (err) {
            console.error("Greška u waitForAIResult:", err);
            clearInterval(fakeInterval);
            clearInterval(countdownInterval);
            Swal.close();
            showRetryError(
                "Greška pri skeniranju",
                err.message || "Nepoznata greška",
                () => waitForAIResult()
            );
            break;
        }

        // Update status text
        const el = document.getElementById("swal-status-message");
        if (el) {
            if (status === "failed" || status === "error") {
                el.innerHTML = `<span class='text-danger'>Greška: ${errorMsg || 'Nepoznata greška'}</span><br><span class='text-muted'>Korak: ${stepTextMap[step] || step || ''}</span>`;
            } else {
                el.textContent = stepTextMap[step] || "Obrađujemo podatke...";
            }
        }

        // SUCCESS
        if (status === "completed") {
            clearInterval(fakeInterval);
            clearInterval(countdownInterval);
            updateProgressBar(100); // Show 100% on completion

            Swal.close();

            setTimeout(() => {
                Swal.fire({
                    icon: "success",
                    title: "Završeno",
                    text: "Deklaracija je uspješno spremljena u draft",
                    showConfirmButton: false,
                    timer: 3000,
                    allowOutsideClick: false,
                    position: "center"
                });
            }, 300);

            _invoice_data = null;
            break;
        }

        // FAILURE
        if (status === "failed" || status === "error") {
            clearInterval(fakeInterval);
            clearInterval(countdownInterval);
            Swal.close();
            showRetryError(
                "Greška pri skeniranju",
                `${errorMsg || "Nepoznata greška"}<br><span class="text-muted">${stepTextMap[step] || step || ""}</span>`,
                () => waitForAIResult()
            );
            break;
        }

        await new Promise(r => setTimeout(r, 2000));
    }
}

function initializeTariffSelects() {
            $('.select2-tariff').each(function() {
                const select = $(this);
                const prefillValue = select.data("prefill");

                select.select2({
                    placeholder: "Pretraži tarifne stavke...",
                    width: '100%',
                    minimumInputLength: 1,
                    minimumInputLength: 1,
    language: {
        inputTooShort: function(args) {
            return "Pretraži tarifne oznake...";
        }
    },
                    ajax: {
                        transport: function(params, success, failure) {
                            const term = params.data.q?.toLowerCase() || "";
                            const filtered = processedTariffData.filter(item => item.search.includes(term));
                            success({
                                results: filtered
                            });
                        },
                        delay: 200
                    },
                    templateResult: function(item) {
                        if (!item.id && !item.text) return null;
                        const icon = item.isLeaf ? "•" : "▶";
                        return $(`<div style="padding-left:${item.depth * 20}px;" title="${item.display}">${icon} ${item.display}</div>`);
                    },
                    templateSelection: function(item) {
                        return item.id || "";
                    }
                });

                // Programmatically set prefill value, only with Tarifna oznaka
                if (prefillValue) {
                    const matched = processedTariffData.find(item => item.id === prefillValue);
                    if (matched) {
                        const option = new Option(matched.id, matched.id, true, true);
                        select.append(option).trigger('change');
                    }
                }
            });
        }



        function addRowToInvoice(item = {}, suggestions = []) {
            const tbody = document.getElementById("newlink");
            const index = tbody.children.length;

            globalAISuggestions.push(suggestions);
            const itemId = item.id || "";
            const name = item.name || item.item_description_original || "";
            const tariff = item.item_code || item.tariff_code || "";
            const price = item.base_price || 0;
            const quantity = item.quantity || 0;
            const origin = item.country_of_origin || "DE";
            const total = (price * quantity).toFixed(2);
            const desc = item.item_description;
            const translate = item.translate || item.item_description_translated || "";
            const package_num = item.num_packages || 0;
            const tariff_privilege = item.tariff_privilege || 0;
            const qtype = item.quantity_type || "";
            const best_customs_code_matches = item.best_customs_code_matches || [];

            console.log(` Adding row ${index + 1}:`, item, suggestions);

            const row = document.createElement("tr");
            row.classList.add("product");




            function generateCountryOptions(selectedCode = "") {
    return window.countries.map(({ code, name }) => {
        const flagUrl = `https://flagcdn.com/w40/${code}.png`;
        const isSelected = selectedCode?.toLowerCase() === code ? "selected" : "";
        return `<option value="${code.toUpperCase()}" ${isSelected} data-flag="${flagUrl}">${code.toUpperCase()}</option>`;
    }).join("");
}
row.innerHTML = `
          <td style="width: 50px;">${index + 1}</td>
     
          <td colspan="2" style="width: 340px;">
            <div class="input-group" style="display: flex; gap: 0.25rem;">
              <input type="text" class="form-control item-name" name="item_name[]" placeholder="Naziv proizvoda" value="${name}" style="flex:1;">
              <button class="btn btn-outline-info rounded" onmouseover="updateTooltip(this)" type="button" onclick="searchFromInputs(this)" data-bs-toggle="tooltip" data-bs-placement="top"   title="">
                 <i class="fa-brands fa-google"></i>
            </button>
              <input type="text" class="form-control item-desc" name="item_desc[]" placeholder="Opisa proizvoda" value="${desc}" style="flex:1;">
            </div>
            <input 
              type="text" 
              class="form-control form-control-sm mt-1" 
              style="font-size: 0.65rem; padding-left:14.4px; height:37.1px;" 
              name="item_prev[]" 
              placeholder="Prevod"
              value="${translate}"
            >
          </td>
           <input type="hidden" name="item_id[]" value="${itemId || ''}">
         <input 
  type="hidden" 
  name="best_customs_code_matches[]" 
  value='${JSON.stringify(best_customs_code_matches || [])}'>


          <td class="text-start" style="width: 150px;">
            <div style="position: relative; width: 100%;">
              <select
                class="form-control select2-tariff "
                style="width: 100%; padding-right: 45px;"
                name="item_code[]"
                data-prefill="${tariff}"
                data-suggestions='${JSON.stringify(suggestions)
                .replace(/&/g, '&amp;')
                .replace(/'/g, '&#39;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')}'>
              </select>

              <button
                type="button"
                class="btn btn-outline-info btn-sm show-ai-btn"

                style="
                  position: absolute;
                  top: 50%;
                  right: 5px;
                  transform: translateY(-50%);
                  height: 30px;
                  width: 30px;
                  padding: 0;
                  border-radius: 3px;
                "
                
                title="Prikaži AI prijedloge"
              >
                <i class="fas fa-wand-magic-sparkles" style="font-size: 16px;"></i>
              </button>
            </div>
          </td>

          <td style="width: 60px;">
            <input 
              type="text" 
              class="form-control" 
              name="quantity_type[]" 
              placeholder="AD, AE.." 
              value="${qtype}"
              
            >
          </td>

          <td style="width: 70px;">
            <select class="form-select" name="origin[]" style="width: 100%;">
              ${generateCountryOptions(origin)}
            </select>
          </td>

          <td style="width: 60px;">
            <input 
              type="number" 
              class="form-control text-start-truncate" 
              name="price[]" 
              value="${price}" 
              style="width: 100%;"
              
            >
          </td>

          <td style="width: 80px;">
            <div style="display: flex; flex-direction: column; gap: 2px; width: 100%;">
              <div class="input-group input-group-sm" style="width: 100%;">
                <button 
                  class="btn btn-outline-info btn-sm decrement-qty" 
                  style="width: 20px; padding: 0;" 
                  type="button"
                >−</button>
                <input 
                  type="number" 
                  class="form-control text-center" 
                  name="quantity[]" 
                  value="${quantity}" 
                  step="1" 
                  min="0"
                  style="padding: 0 5px; height: 30px;"
                >
                <button 
                  class="btn btn-outline-info btn-sm increment-qty" 
                  style=" width: 20px; padding: 0;" 
                  type="button"
                >+</button>
              </div>
              
             <div class="input-group input-group-sm" style="height: 30px;">
                <button 
                class="btn btn-outline-info btn-sm decrement-kolata"
                  style="padding: 0; width: 20px;"
                >−</button>

                <input
                  type="number"
                  class="form-control text-center"
                  name="kolata[]"
                  placeholder="Broj paketa"
                  min="0"
                  step="1"
                  style="height: 30px; padding: 0 5px; font-size: 10px;"
                  value="${package_num}"
                >

                <button 
                  class="btn btn-outline-info btn-sm increment-kolata" 
                  type="button" 
                  style="padding: 0; width: 20px;"
                >+</button>
                </div>
            </div>
          </td>

          <td style="width: 70px;">
            <input 
              type="text" 
              class="form-control text-start" 
              name="total[]" 
              value="${total}"
              style="width: 100%;"
            >
          </td>

          <td style="width: 20px; text-align: center;">
              <div style="display: flex; flex-direction: column; align-items: end; gap: 2px;">
                <button type="button" class="btn btn-danger btn-sm remove-row text-center "   style="width: 30px;" title="Ukloni red"  >
                  <i class="fas fa-times"></i>
                </button>
                
                <input type="checkbox" class="form-check-input"
       name="tariff_privilege[]"
       ${tariff_privilege ? 'checked' : ''}
       data-bs-toggle="tooltip" title="Povlastica DA/NE"
       style="width: 30px; height: 26.66px; cursor: pointer;" />

              </div>
            </td>

        `;


            $(row).find('select[name="origin[]"]').select2({
                templateResult: formatFlag,
                templateSelection: formatFlag,
                placeholder: "Select a country",
                width: 'style',
                language: {
                    noResults: function() {
                        return "Nisu pronađeni rezultati";
                    },
                    searching: function() {
                        return "Pretraga…";
                    },
                    inputTooShort: function() {
                        return "Unesite još znakova…";
                    }
                }
            });

            function formatFlag(state) {
                if (!state.id) return state.text;
                const flagUrl = $(state.element).data('flag');
                return $(`<span class="flag-option"><img src="${flagUrl}" width="20" style="margin-right: 10px;" /> ${state.text}</span>`);
            }

            tbody.appendChild(row);
            initializeTariffSelects();

            updateTotalAmount();
        }
        $(document).on('click', '.increment-qty', function() {
            const input = $(this).siblings('input[name="quantity[]"]');
            input.val(parseInt(input.val() || 0) + 1).trigger('input');
            updateTotalAmount();
        });

        $(document).on('click', '.decrement-qty', function() {
            const input = $(this).siblings('input[name="quantity[]"]');
            const current = parseInt(input.val() || 0);
            if (current > 0) {
                input.val(current - 1).trigger('input');
                updateTotalAmount();
            }
        });
        $(document).on('input', 'input[name="price[]"], input[name="quantity[]"]', function() {
            const row = $(this).closest('tr');
            const price = parseFloat(row.find('input[name="price[]"]').val()) || 0;
            const quantity = parseInt(row.find('input[name="quantity[]"]').val()) || 0;
            const total = (price * quantity).toFixed(2);
            row.find('input[name="total[]"]').val(total);

            // Optional: update global total as well
            updateTotalAmount();
        });



        document.addEventListener('click', (event) => {
            // Handle decrement button click
            if (event.target.closest('.decrement-kolata')) {
                const container = event.target.closest('div'); // or closest input group wrapper
                const input = container.querySelector('input[name="kolata[]"]');
                if (input) {
                    let currentValue = parseInt(input.value) || 0;
                    if (currentValue > 0) {
                        input.value = currentValue - 1;
                        input.dispatchEvent(new Event('change')); // if you listen for changes
                    }
                }
            }

            // Handle increment button click
            if (event.target.closest('.increment-kolata')) {
                const container = event.target.closest('div'); // or closest input group wrapper
                const input = container.querySelector('input[name="kolata[]"]');
                if (input) {
                    let currentValue = parseInt(input.value) || 0;
                    input.value = currentValue + 1;
                    input.dispatchEvent(new Event('change'));
                }
            }

            // Initialize all tooltips once
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                if (!bootstrap.Tooltip.getInstance(tooltipTriggerEl)) { // avoid re-init
                    new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover',
                        delay: {
                            show: 100,
                            hide: 100
                        }
                    });
                }
            });

            // Add a single click listener outside to hide tooltips on outside click
            document.addEventListener('click', function(e) {
                tooltipTriggerList.forEach(function(el) {
                    var tooltip = bootstrap.Tooltip.getInstance(el);
                    if (tooltip && e.target !== el && !el.contains(e.target)) {
                        tooltip.hide();
                    }
                });
            });



        });


        async function fillInvoiceData() {
            const invoice = await getInvoice();
            waitForEl("#invoice-id1", el => el.textContent = invoice.id || "—");
            waitForEl("#invoice-date-text", el => el.textContent = invoice.date_of_issue || "—");
            waitForEl("#pregled", el => {
                el.addEventListener("click", () => {
                    window.location.href = `/detalji-deklaracije/${invoice.id}`;
                });
            });




            const items = invoice.items || [];
            console.log(" Invoice items:", items);

            items.forEach((item, index) => {
                const matches = item.best_customs_code_matches || [];

                const bestMatch = matches.reduce((best, current) => {
                    return !best || current.closeness < best.closeness ? current : best;
                }, null);

                const bestTariffCode = bestMatch?.entry?.["Tarifna oznaka"] || "";

                const suggestions = matches.map(code => ({
                    entry: {
                        "Tarifna oznaka": code.entry?.["Tarifna oznaka"],
                        "Naziv": code.entry?.["Naziv"]
                    },
                    closeness: code.closeness
                }));

                addRowToInvoice({
                    ...item,
                    tariff_code: bestTariffCode
                }, suggestions);
            });
            if (invoice.incoterm) {
                // Extract only the code (first word) for the select
                const incotermCode = invoice.incoterm.split(' ')[0];
                document.getElementById("incoterm").value = incotermCode;
            }
            if (invoice.invoice_number) {
                const cleaned = invoice.invoice_number.replaceAll("/", "");
                document.getElementById("invoice-no").value = cleaned;
            }

            await updateRemainingScans();




        }


        async function fetchAndPrefillParties() {
            const taskId = window.global_invoice_id;
            if (!taskId || !token) return;

            try {
                const res = await fetch(`/api/invoices/${taskId}/scan/parties`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (!res.ok) throw new Error("Greška u AI response");

                const {
                    supplier,
                    importer,
                    supplier_id,
                    importer_id
                } = data;
                // Get invoice data for IDs
                const invoice = await getInvoice();

                // --- SUPPLIER LOGIC ---
                let supplierId = invoice.supplier_id || supplier_id;
                if (window.forceNewSupplier) {
                    // Always remove any previous 'Novi klijent' option
                    $("#supplier-select2 option[value='new']").remove();
                    // Add and select 'Novi klijent'
                    const newOption = new Option('Novi klijent', 'new', true, true);
                    $("#supplier-select2").append(newOption).trigger('change');
                    if (supplier) {
                        $("#billing-name").val(supplier.name || "").prop('readonly', false);
                        $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                        $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                        $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                        $("#email").val(supplier.email || "").prop('readonly', false);
                        $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                    } else {
                        $("#billing-name, #billing-address-line-1, #billing-phone-no, #billing-tax-no, #email, #supplier-owner").val("").prop('readonly', false);
                    }
                    const label = document.getElementById("billing-name-ai-label");
                    if (label) label.classList.remove("d-none");
                    window.forceNewSupplier = false;
                } else if (supplierId) {
                    // Ensure the option exists before setting value
                    if ($(`#supplier-select2 option[value='${supplierId}']`).length === 0) {
                        const text = supplier?.name ? `${supplier.name} – ${supplier.address || ''}` : supplierId;
                        const newOption = new Option(text, supplierId, true, true);
                        $("#supplier-select2").append(newOption);
                    }
                    console.log("[SUPPLIER] Prefilling from ID:", supplierId, invoice.supplier_id ? 'invoice.supplier_id' : 'parties.supplier_id');
                    $("#supplier-select2").val(supplierId).trigger("change");
                    $.ajax({
                        url: `/api/suppliers/${supplierId}`,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: `Bearer ${token}`
                        },
                        success: function(dbSupplier) {
                            console.log("[SUPPLIER] Prefilling textboxes from DB for ID:", supplierId, dbSupplier);
                            $("#billing-name").val(dbSupplier.name || "").prop('readonly', true);
                            $("#billing-address-line-1").val(dbSupplier.address || "").prop('readonly', true);
                            $("#billing-phone-no").val(dbSupplier.contact_phone || "").prop('readonly', true);
                            $("#billing-tax-no").val(dbSupplier.tax_id || "").prop('readonly', true);
                            $("#email").val(dbSupplier.contact_email || "").prop('readonly', true);
                            $("#supplier-owner").val(dbSupplier.owner || "").prop('readonly', true);
                            const label = document.getElementById("billing-name-ai-label");
                            if (label) label.classList.add("d-none");
                        },
                        error: function() {
                            if (supplier) {
                                // Not found in DB, add 'Novi klijent' to select2
                                const newOption = new Option('Novi klijent', 'new', true, true);
                                $("#supplier-select2").append(newOption).trigger('change');
                                $("#billing-name").val(supplier.name || "").prop('readonly', false);
                                $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                                $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                                $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                                $("#email").val(supplier.email || "").prop('readonly', false);
                                $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                                const label = document.getElementById("billing-name-ai-label");
                                if (label) label.classList.remove("d-none");
                            }
                        }
                    });
                } else if (supplier) {
                    // Not found in DB, add 'Novi klijent' to select2
                    const newOption = new Option('Novi klijent', 'new', true, true);
                    $("#supplier-select2").append(newOption).trigger('change');
                    $("#billing-name").val(supplier.name || "").prop('readonly', false);
                    $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                    $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                    $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                    $("#email").val(supplier.email || "").prop('readonly', false);
                    $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                    const label = document.getElementById("billing-name-ai-label");
                    if (label) label.classList.remove("d-none");
                }

                // --- IMPORTER LOGIC ---
                let importerId = invoice.importer_id || importer_id;
                if (window.forceNewImporter) {
                    $("#importer-select2 option[value='new']").remove();
                    const newOption = new Option('Novi dobavljač', 'new', true, true);
                    $("#importer-select2").append(newOption).trigger('change');
                    if (importer) {
                        $("#carrier-name").val(importer.name || "").prop('readonly', false);
                        $("#carrier-address").val(importer.address || "").prop('readonly', false);
                        $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                        $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                        $("#carrier-email").val(importer.email || "").prop('readonly', false);
                        $("#carrier-owner").val(importer.owner || "").prop('readonly', false);
                    } else {
                        $("#carrier-name, #carrier-address, #carrier-tel, #carrier-tax, #carrier-email, #carrier-owner").val("").prop('readonly', false);
                    }
                    const label = document.getElementById("carrier-name-ai-label");
                    if (label) label.classList.remove("d-none");
                    window.forceNewImporter = false;
                } else if (importerId) {
                    // Ensure the option exists before setting value
                    if ($(`#importer-select2 option[value='${importerId}']`).length === 0) {
                        const text = importer?.name ? `${importer.name} – ${importer.address || ''}` : importerId;
                        const newOption = new Option(text, importerId, true, true);
                        $("#importer-select2").append(newOption);
                    }
                    console.log("[IMPORTER] Prefilling from ID:", importerId, invoice.importer_id ? 'invoice.importer_id' : 'parties.importer_id');
                    $("#importer-select2").val(importerId).trigger("change");
                    $.ajax({
                        url: `/api/importers/${importerId}`,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: `Bearer ${token}`
                        },
                        success: function(dbImporter) {
                            console.log("[IMPORTER] Prefilling textboxes from DB for ID:", importerId, dbImporter);
                            $("#carrier-name").val(dbImporter.name || "").prop('readonly', true);
                            $("#carrier-address").val(dbImporter.address || "").prop('readonly', true);
                            $("#carrier-tel").val(dbImporter.contact_phone || "").prop('readonly', true);
                            $("#carrier-tax").val(dbImporter.tax_id || "").prop('readonly', true);
                            $("#carrier-email").val(dbImporter.contact_email || "").prop('readonly', true);
                            $("#carrier-owner").val(dbImporter.owner || "").prop('readonly', true);
                            const label = document.getElementById("carrier-name-ai-label");
                            if (label) label.classList.add("d-none");
                        },
                        error: function() {
                            if (importer) {
                                // Not found in DB, add 'Novi dobavljač' to select2
                                const newOption = new Option('Novi dobavljač', 'new', true, true);
                                $("#importer-select2").append(newOption).trigger('change');
                                $("#carrier-name").val(importer.name || "").prop('readonly', false);
                                $("#carrier-address").val(importer.address || "").prop('readonly', false);
                                $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                                $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                                $("#carrier-email").val(importer.email || "").prop('readonly', false);
                                $("#carrier-owner").val(importer.owner || "").prop('readonly', false);
                                const label = document.getElementById("carrier-name-ai-label");
                                if (label) label.classList.remove("d-none");
                            }
                        }
                    });
                } else if (importer) {
                    // Always remove any previous 'Novi dobavljač' option
                    $("#importer-select2 option[value='new']").remove();
                    // Add and select 'Novi dobavljač'
                    const newOption = new Option('Novi dobavljač', 'new', true, true);
                    $("#importer-select2").append(newOption).trigger('change');
                    $("#carrier-name").val(importer.name || "").prop('readonly', false);
                    $("#carrier-address").val(importer.address || "").prop('readonly', false);
                    $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                    $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                    $("#carrier-email").val(importer.email || "").prop('readonly', false);
                    $("#carrier-owner").val(importer.owner || "").prop('readonly', false);
                    const label = document.getElementById("carrier-name-ai-label");
                    if (label) label.classList.remove("d-none");
                }

            } catch (err) {
                console.error("Greška u fetchAndPrefillParties:", err);
                showRetryError(
                    "Kredit za skeniranje nije iskorišten",
                    err.message || "Neuspješno dohvaćanje podataka",
                    () => fetchAndPrefillParties()
                );


            }
            


        }

        async function fetchAndPrefillSupplierOnly() {
            const taskId = window.global_invoice_id;
            if (!taskId || !token) return;

            try {
                const res = await fetch(`/api/invoices/${taskId}/scan/parties`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    }
                });

                const data = await res.json();
                if (!res.ok) throw new Error("Greška u AI response");

                const {
                    supplier,
                    supplier_id
                } = data;
                const invoice = await getInvoice();

                let supplierId = invoice.supplier_id || supplier_id;
                if (window.forceNewSupplier) {
                    $("#supplier-select2 option[value='new']").remove();
                    const newOption = new Option('Novi klijent', 'new', true, true);
                    $("#supplier-select2").append(newOption).trigger('change');
                    if (supplier) {
                        $("#billing-name").val(supplier.name || "").prop('readonly', false);
                        $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                        $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                        $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                        $("#email").val(supplier.email || "").prop('readonly', false);
                        $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                    } else {
                        $("#billing-name, #billing-address-line-1, #billing-phone-no, #billing-tax-no, #email, #supplier-owner").val("").prop('readonly', false);
                    }
                    const label = document.getElementById("billing-name-ai-label");
                    if (label) label.classList.remove("d-none");
                    window.forceNewSupplier = false;

                } else if (supplierId) {
                    if ($(`#supplier-select2 option[value='${supplierId}']`).length === 0) {
                        const text = supplier?.name ? `${supplier.name} – ${supplier.address || ''}` : supplierId;
                        const newOption = new Option(text, supplierId, true, true);
                        $("#supplier-select2").append(newOption);
                    }
                    console.log("[SUPPLIER] Prefilling from ID:", supplierId);
                    $("#supplier-select2").val(supplierId).trigger("change");

                    $.ajax({
                        url: `/api/suppliers/${supplierId}`,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: `Bearer ${token}`
                        },
                        success: function(dbSupplier) {
                            console.log("[SUPPLIER] Prefilling from DB:", dbSupplier);
                            $("#billing-name").val(dbSupplier.name || "").prop('readonly', true);
                            $("#billing-address-line-1").val(dbSupplier.address || "").prop('readonly', true);
                            $("#billing-phone-no").val(dbSupplier.contact_phone || "").prop('readonly', true);
                            $("#billing-tax-no").val(dbSupplier.tax_id || "").prop('readonly', true);
                            $("#email").val(dbSupplier.contact_email || "").prop('readonly', true);
                            $("#supplier-owner").val(dbSupplier.owner || "").prop('readonly', true);
                            const label = document.getElementById("billing-name-ai-label");
                            if (label) label.classList.add("d-none");
                        },
                        error: function(xhr) {
                            console.warn("Supplier not found in DB. Status:", xhr.status);

                            Swal.fire({
                                title: "Klijent nije pronađen",
                                text: "Podaci za klijenta nisu pronađeni u bazi. Unos će biti omogućen ručno.",
                                icon: "info",
                                confirmButtonText: "U redu",
                                confirmButtonColor: "#299dcb"
                            });

                            if (supplier) {
                                const newOption = new Option('Novi klijent', 'new', true, true);
                                $("#supplier-select2").append(newOption).trigger('change');
                                $("#billing-name").val(supplier.name || "").prop('readonly', false);
                                $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                                $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                                $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                                $("#email").val(supplier.email || "").prop('readonly', false);
                                $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                                const label = document.getElementById("billing-name-ai-label");
                                if (label) label.classList.remove("d-none");
                            }
                        }

                    });

                } else if (supplier) {
                    const newOption = new Option('Novi klijent', 'new', true, true);
                    $("#supplier-select2").append(newOption).trigger('change');
                    $("#billing-name").val(supplier.name || "").prop('readonly', false);
                    $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                    $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                    $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                    $("#email").val(supplier.email || "").prop('readonly', false);
                    $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                    const label = document.getElementById("billing-name-ai-label");
                    if (label) label.classList.remove("d-none");
                }

            } catch (err) {
                console.error("Greška u fetchAndPrefillSupplierOnly:", err);
                showRetryError(
                    "Greška pri dohvaćanju dobavljača",
                    err.message || "Neuspješno dohvaćanje",
                    () => fetchAndPrefillSupplierOnly()
                );
            }
        }

        async function fetchAndPrefillImporterOnly() {
    const taskId = window.global_invoice_id;
    if (!taskId || !token) return;

    try {
        console.log("[IMPORTER] Starting fetchAndPrefillImporterOnly... Task ID:", taskId);

        const res = await fetch(`/api/invoices/${taskId}/scan/parties`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                Authorization: `Bearer ${token}`
            }
        });

        const data = await res.json();
        console.log("[IMPORTER] API response:", data);

        if (!res.ok) throw new Error("Greška u AI response");

        const { importer, importer_id } = data;
        const invoice = await getInvoice();
        console.log("[IMPORTER] Existing invoice data:", invoice);

        let importerId = invoice.importer_id || importer_id;
        console.log("[IMPORTER] Final importerId to use:", importerId);

        if (window.forceNewImporter) {
            console.log("[IMPORTER] Forcing new importer...");
            $("#importerr-select2 option[value='new']").remove();

            const labelText = importer?.name ? `${importer.name} – ${importer.address || ''}` : 'Novi dobavljač';
            const newOption = new Option(labelText, String(importerId), true, true);
            $("#importer-select2").append(newOption);
            $("#importer-select2").val(String(importerId)).trigger("change");

            console.log("[IMPORTER] Added 'new' option and triggered change");

            if (importer) {
                console.log("[IMPORTER] Prefilling fields with AI importer data");
                $("#carrier-name").val(importer.name || "").prop('readonly', false);
                $("#carrier-address").val(importer.address || "").prop('readonly', false);
                $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                $("#carrier-email").val(importer.email || "").prop('readonly', false);
                $("#carrier-owner").val(importer.owner || "").prop('readonly', false);
            } else {
                console.warn("[IMPORTER] No importer data provided, clearing fields");
                $("#carrier-name, #carrier-address, #carrier-tel, #carrier-tax, #carrier-email, #carrier-owner").val("").prop('readonly', false);
            }

            const label = document.getElementById("carrier-name-ai-label");
            if (label) label.classList.remove("d-none");

            window.forceNewImporter = false;

        } else if (importerId) {
            const stringId = String(importerId);
            console.log("[IMPORTER] importerId exists:", stringId);

            if ($(`#importer-select2 option[value='${stringId}']`).length === 0) {
                const text = importer?.name ? `${importer.name} – ${importer.address || ''}` : stringId;
                console.log("[IMPORTER] Option not found. Adding manually:", text);
                const newOption = new Option(text, stringId, true, true);
                $("#importer-select2").append(newOption);
            } else {
                console.log("[IMPORTER] Option already exists in select2:", stringId);
            }

            console.log("[IMPORTER] Setting carrier-select2 to:", stringId);
            $("#importer-select2").val(stringId).trigger("change");

            $.ajax({
                url: `/api/importers/${stringId}`,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    Authorization: `Bearer ${token}`
                },
                success: function (dbImporter) {
                    console.log("[IMPORTER] DB importer found:", dbImporter);

                    $("#carrier-name").val(dbImporter.name || "").prop('readonly', true);
                    $("#carrier-address").val(dbImporter.address || "").prop('readonly', true);
                    $("#carrier-tel").val(dbImporter.contact_phone || "").prop('readonly', true);
                    $("#carrier-tax").val(dbImporter.tax_id || "").prop('readonly', true);
                    $("#carrier-email").val(dbImporter.contact_email || "").prop('readonly', true);
                    $("#carrier-owner").val(dbImporter.owner || "").prop('readonly', true);

                    const label = document.getElementById("carrier-name-ai-label");
                    if (label) label.classList.add("d-none");
                },
                error: function (xhr) {
                    console.warn("Importer not found in DB. Status:", xhr.status);

                    Swal.fire({
                        title: "Uvoznik nije pronađen",
                        text: "Podaci za uvoznika nisu pronađeni u bazi. Unos će biti omogućen ručno.",
                        icon: "info",
                        confirmButtonText: "U redu",
                        confirmButtonColor: "#299dcb"
                    });

                    if (importer) {
                        console.log("[IMPORTER] Falling back to AI importer data");
                        const newOption = new Option('Novi dobavljač', 'new', true, true);
                        $("#importer-select2").append(newOption).trigger('change');

                        $("#carrier-name").val(importer.name || "").prop('readonly', false);
                        $("#carrier-address").val(importer.address || "").prop('readonly', false);
                        $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                        $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                        $("#carrier-email").val(importer.email || "").prop('readonly', false);
                        $("#carrier-owner").val(importer.owner || "").prop('readonly', false);

                        const label = document.getElementById("carrier-name-ai-label");
                        if (label) label.classList.remove("d-none");
                    }
                }
            });

        } else if (importer) {
            console.log("[IMPORTER] No ID but importer data available. Treating as new.");
            const newOption = new Option('Novi dobavljač', 'new', true, true);
            $("#importer-select2").append(newOption).trigger('change');

            $("#carrier-name").val(importer.name || "").prop('readonly', false);
            $("#carrier-address").val(importer.address || "").prop('readonly', false);
            $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
            $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
            $("#carrier-email").val(importer.email || "").prop('readonly', false);
            $("#carrier-owner").val(importer.owner || "").prop('readonly', false);

            const label = document.getElementById("carrier-name-ai-label");
            if (label) label.classList.remove("d-none");
        }

    } catch (err) {
        console.error("Greška u fetchAndPrefillImporterOnly:", err);
        showRetryError(
            "Greška pri dohvaćanju uvoznika",
            err.message || "Neuspješno dohvaćanje",
            () => fetchAndPrefillImporterOnly()
        );
    }
}




        document.addEventListener("DOMContentLoaded", async () => {

            window.skipPrefillParties = false; // Always allow prefill on page load/scan
            console.log(" Page loaded. Starting init process...");

            // Parallelize tariff and invoice fetch for faster load
            const [tariffRes, invoice] = await Promise.all([
                fetch("{{ URL::asset('build/json/tariff.json') }}"),
                getInvoice()
            ]);
            const tariffData = await tariffRes.json();
            console.log(" Tariff data loaded:", tariffData);

            processedTariffData = tariffData
                .filter(item => item["Tarifna oznaka"] && item["Naziv"] && item["Puni Naziv"])
                .map(item => ({
                    id: item["Tarifna oznaka"],
                    text: item["Puni Naziv"].split(">>>").pop().trim(),
                    display: `${item["Tarifna oznaka"]} – ${item["Naziv"]}`,
                    depth: item["Puni Naziv"].split(">>>").length - 1,
                    isLeaf: item["Tarifna oznaka"].replace(/\s/g, '').length === 10,
                    search: [item["Naziv"], item["Puni Naziv"], item["Tarifna oznaka"]].join(" ").toLowerCase()
                }));
            console.log(" Processed tariff data:", processedTariffData);

            // Only show loader and run scan if needed
            let scanNeeded = false;
            if (invoice.task_id == null) scanNeeded = true;
            else if (!invoice.items?.length) scanNeeded = true;

            if (scanNeeded) {
              

                let scanStarted = true;

                // Start scan only if task_id is null
                if (invoice.task_id == null) {
                    scanStarted = await startAiScan();
                }

                // Only continue if scan actually started or items are already being processed
                if (!scanStarted) {
                    // Stop further steps like waitForAIResult/fetchParties
                    return;
                }

                if (!invoice.items?.length) {
                    await waitForAIResult();
                }


                Swal.close();
            }


            _invoice_data = null;

            await fillInvoiceData();
            if (!window.skipPrefillParties) {
                await fetchAndPrefillParties();
            }
            window.skipPrefillParties = false; // reset after use
            $("#supplier-select2").select2({
                placeholder: "Pretraži klijenta",
                allowClear: true,
                ajax: {
                    url: "/api/suppliers",
                    dataType: "json",
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    },
                    data: params => ({
                        search: params.term
                    }),
                    processResults: data => ({
                        results: data.data.map(s => ({
                            id: s.id,
                            text: `${s.name} – ${s.address}`,
                            full: s
                        }))
                    }),
                    minimumInputLength: 1, // ⬅️ ovo SPRJEČAVA da išta bude prikazano dok ne krene search
tags: false,           // ⬅️ ovo SPRJEČAVA "ručni unos" koji ti ionako ne koristi
allowClear: true,      // ⬅️ po želji – omogućava 'x' za brisanje izbora
placeholder: "Pretraži...", // bolji UX
                    cache: true
                },
                tags: true,
                allowClear: false
            });

            $('#supplier-select2').on('select2:select', function(e) {
                const data = e.params.data.full;
                if (data) {
                    $('#billing-name').val(data.name || "");
                    $('#billing-address-line-1').val(data.address || "");
                    $('#billing-phone-no').val(data.contact_phone || "");
                    $('#billing-tax-no').val(data.tax_id || "");
                    $('#email').val(data.contact_email || "");
                    $('#supplier-owner').val(data.owner || ""); // Fill owner field
                }
            });

            $("#importer-select2").select2({
                placeholder: "Pretraži dobavljača",
                allowClear: true,
                ajax: {
                    url: "/api/importers",
                    dataType: "json",
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        Authorization: `Bearer ${token}`
                    },
                    data: params => ({
                        search: params.term
                    }),
                    processResults: data => ({
                        results: data.data.map(s => ({
                            id: s.id,
                            text: `${s.name} – ${s.address}`,
                            full: s
                        }))
                    }),
                    cache: true
                },
                tags: true,
                allowClear: false
            });

            $('#importer-select2').on('select2:select', function(e) {
                const data = e.params.data.full;
                if (data) {

                    $('#carrier-address').val(data.address || "");
                    $('#carrier-name').val(data.name || "");
                    $('#carrier-phone').val(data.contact_phone || "");
                    $('#carrier-tax').val(data.tax_id || "");
                    $('#carrier-email').val(data.contact_email || "");
                    $('#carrier-owner').val(data.owner || ""); // Fill owner field
                }
            });


            // await promptForSupplierAfterScan();
            $(document).on('click', '.show-ai-btn', function() {
                console.log(" AI button clicked");

                const select = $(this).closest('td').find('select.select2-tariff');
                console.log(" Found select element:", select);

                let rawSuggestions = select.data("suggestions");
                try {
                    if (typeof rawSuggestions === "string") {
                        rawSuggestions = JSON.parse(rawSuggestions);
                    }
                } catch (err) {
                    console.error(" Failed to parse suggestions JSON:", err);
                    return;
                }

                console.log(" Raw suggestions:", rawSuggestions);

                if (!rawSuggestions) {
                    console.warn(" No suggestions found on data attribute.");
                    return;
                }

                if (!Array.isArray(rawSuggestions)) {
                    console.warn(" Suggestions are not an array:", typeof rawSuggestions);
                    return;
                }

                const sorted = [...rawSuggestions].sort((a, b) => a.closeness - b.closeness).slice(0, 10);
                console.log(" Sorted suggestions:", sorted);

                const container = document.getElementById("aiSuggestionsBody");
                if (!container) {
                    console.error(" aiSuggestionsBody not found in DOM");
                    return;
                }

                if (!sorted.length) {
                    container.innerHTML = `<div class="text-muted">Nema prijedloga.</div>`;
                    console.log("ℹ No sorted suggestions to show.");
                } else {
                    container.innerHTML = sorted.map((s, i) => `
            <div class="mb-2">
                <div><strong>${i + 1}. Tarifna oznaka:</strong> ${s.entry["Tarifna oznaka"]}</div>
                <div><strong>Naziv:</strong> ${s.entry["Naziv"]}</div>
                <button class="btn btn-sm btn-info mt-1 use-tariff" data-value="${s.entry["Tarifna oznaka"]}">
                    Koristi ovu oznaku
                </button>
                <hr>
            </div>
        `).join("");
                    console.log(" Inserted suggestions into modal body.");
                }

                $('#aiSuggestionModal').data('target-select', select);
                console.log(" Set data-target-select on modal.");

                const modalEl = document.getElementById("aiSuggestionModal");
                if (!modalEl) {
                    console.error(" Modal element not found with ID aiSuggestionModal");
                    return;
                }

                let modal = bootstrap.Modal.getInstance(modalEl);
                console.log(" Existing modal instance:", modal);

                if (!modal) {
                    modal = new bootstrap.Modal(modalEl, {
                        backdrop: 'static',
                        keyboard: true
                    });
                    console.log(" Modal instance created.");
                }

                modal.show();
                console.log(" Bootstrap modal should be showing now.");
            });

            $(document).on('click', '.use-tariff', function() {
                const code = $(this).data('value');
                console.log(" User selected code:", code);

                const select = $('#aiSuggestionModal').data('target-select');
                console.log(" Target select:", select);

                if (select && code) {
                    const matched = processedTariffData.find(item => item.id === code);
                    console.log(" Matched tariff code:", matched);

                    if (matched) {
                        const option = new Option(matched.id, matched.id, true, true);
                        select.find('option').remove();
                        select.append(option).trigger('change');
                        console.log(" Code applied to select2 field.");
                    } else {
                        console.warn(" No match found in processedTariffData.");
                    }
                } else {
                    console.warn(" Select or code not defined properly.");
                }

                const modal = bootstrap.Modal.getInstance(document.getElementById("aiSuggestionModal"));
                if (modal) {
                    modal.hide();
                    console.log(" Modal closed.");
                } else {
                    console.warn(" No modal instance to close.");
                }
            });

            document.addEventListener("click", function(e) {
                if (e.target.closest(".remove-row")) {
                    const button = e.target.closest(".remove-row");
                    const row = button.closest("tr");

                    Swal.fire({
                        title: "Oprez!",
                        text: "Odabrani proizvod će biti trajno uklonjen sa popisa trenutne deklaracije. Nakon akcije, deklaraciju morate spasiti!",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Odustani",
                        confirmButtonText: "Da, ukloni",
                        customClass: {
                            confirmButton: "btn btn-soft-info me-2",
                            cancelButton: "btn btn-info"
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed && row) {
                            row.remove();
                            updateTotalAmount();
                        }
                    });
                }
            });


            function formatDateToDDMMYYYY(dateString) {
                if (!dateString) return '';
                if (typeof dateString === 'string') {
                    const [year, month, day] = dateString.split('-');
                    return `${day}.${month}.${year}`;
                } else if (dateString instanceof Date) {
                    const d = dateString;
                    const day = String(d.getDate()).padStart(2, '0');
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const year = d.getFullYear();
                    return `${day}.${month}.${year}`;
                }
                return '';
            }

            flatpickr("#invoice-date", {
                locale: "bs",
                dateFormat: "d.m.Y"
            });





            const invNo = getInvoiceId();
            if (invNo) document.getElementById("invoice-no1").value = invNo;

          const invoiceDateInput = document.getElementById("invoice-date");
if (invoiceDateInput) {
    invoiceDateInput.value = formatDateToDDMMYYYY(invoice.date_of_issue || new Date());
}


            console.log(" Invoice date and number set.");

            //document.getElementById("company-address").value = "Vilsonovo, 9, Sarajevo ";
            document.getElementById("company-zip").value = "71000";
            document.getElementById("company-email").value = "business@deklarant.ai";


            document.getElementById("billing-name")?.addEventListener("input", () => {
                const label = document.getElementById("billing-name-ai-label");
                if (label) label.classList.add("d-none");
            });

            // Hide AI label when user types in importer name
            document.getElementById("carrier-name")?.addEventListener("input", () => {
                const label = document.getElementById("carrier-name-ai-label");
                if (label) label.classList.add("d-none");
            });


        });


        // Add buttons above supplier and importer fields
        $(document).ready(function() {

            // Handler for new supplier
            $(document).on('click', '#add-new-supplier', function() {
                if (window.isResetConfirmed) return;

                Swal.fire({
                    title: 'Oprez!',
                    text: 'Ova radnja će izbrisati sve podatke za klijenta i omogućiti ponovno automatsko popunjavanje.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Da',
                    cancelButtonText: 'Ne',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        confirmButton: "btn btn-soft-info me-2",
                        cancelButton: "btn btn-info"
                    },

                    focusCancel: true,

                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set flag to trigger refetch
                        window.forceNewSupplier = false;
                        window.skipPrefillParties = false;

                        // Očistimo polja i učitamo ponovo iz baze
                        $("#billing-name, #billing-address-line-1, #billing-phone-no, #billing-tax-no, #email, #supplier-owner")
                            .val("")
                            .prop('readonly', true)
                            .removeClass("is-invalid");

                        $("#supplier-select2").empty();

                        // Pokrećemo ponovno popunjavanje samo za supplier
                        fetchAndPrefillSupplierOnly();
                    }
                });
            });





            // Handler for new importer
            $(document).on('click', '#add-new-importer', function() {
                if (window.isResetConfirmed) return;

                Swal.fire({
                    title: 'Oprez!',
                    text: 'Ova radnja će izbrisati sve podatke za dobavljača i omogućiti ponovno automatsko popunjavanje.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Da',
                    cancelButtonText: 'Ne',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        confirmButton: "btn btn-soft-info me-2",
                        cancelButton: "btn btn-info"
                    },

                }).then((result) => {
                    if (result.isConfirmed) {
                        window.forceNewImporter = false;
                        window.skipPrefillParties = false;

                        // Očisti inpute i pripremi Select2
                        $("#carrier-name, #carrier-address, #carrier-tel, #carrier-tax, #carrier-email, #carrier-owner")
                            .val("")
                            .prop('readonly', true)
                            .removeClass("is-invalid");

                        $("#importer-select2").empty();

                        // Ponovno preuzimanje samo importer podataka
                        fetchAndPrefillImporterOnly();
                    }
                });
            });
        });




        // Add SweetAlert confirmation for importer manual entry

        // 1. Add buttons in the DOM (jQuery, after DOMContentLoaded)
        $(document).ready(function() {
            // Add 'Popuni ponovo s AI' button next to 'Obriši' for supplier


            // Handler for supplier AI refill
            $(document).on('click', '#refill-supplier-ai', async function() {
                const taskId = window.global_invoice_id;
                if (!taskId || !window.token) return;
                try {
                    const res = await fetch(`/api/invoices/${taskId}/scan/parties`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: `Bearer ${token}`
                        }
                    });

                    const data = await res.json();
                    if (!res.ok) throw new Error("Greška u AI response");
                    const supplier = data.supplier;
                    if (supplier) {
                        // Set select2 to 'Novi klijent'
                        $("#supplier-select2 option[value='new']").remove();
                        var newOption = new Option('Novi klijent', 'new', true, true);
                        $("#supplier-select2").append(newOption).val('new').trigger('change');
                        // Fill fields
                        $("#billing-name").val(supplier.name || "").prop('readonly', false);
                        $("#billing-address-line-1").val(supplier.address || "").prop('readonly', false);
                        $("#billing-phone-no").val(supplier.phone_number || "").prop('readonly', false);
                        $("#billing-tax-no").val(supplier.vat_number || "").prop('readonly', false);
                        $("#email").val(supplier.email || "").prop('readonly', false);
                        $("#supplier-owner").val(supplier.owner || "").prop('readonly', false);
                        const label = document.getElementById("billing-name-ai-label");
                        if (label) label.classList.remove("d-none");
                    } else {
                        Swal.fire("Greška", "Nema AI podataka za klijenta", "error");
                    }
                } catch (err) {
                    Swal.fire("Greška", err.message || "Neuspješno dohvaćanje podataka", "error");
                }
            });

            // Handler for importer AI refill
            $(document).on('click', '#refill-importer-ai', async function() {
                const taskId = window.global_invoice_id;
                if (!taskId || !window.token) return;
                try {
                    const res = await fetch(`/api/invoices/${taskId}/scan/parties`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            Authorization: `Bearer ${token}`
                        }
                    });
                    const data = await res.json();
                    if (!res.ok) throw new Error("Greška u AI response");
                    const importer = data.importer;
                    if (importer) {
                        // Set select2 to 'Novi dobavljač'
                        $("#importer-select2 option[value='new']").remove();
                        var newOption = new Option('Novi dobavljač', 'new', true, true);
                        $("#importer-select2").append(newOption).val('new').trigger('change');
                        // Fill fields
                        $("#carrier-name").val(importer.name || "").prop('readonly', false);
                        $("#carrier-address").val(importer.address || "").prop('readonly', false);
                        $("#carrier-tel").val(importer.phone_number || "").prop('readonly', false);
                        $("#carrier-tax").val(importer.vat_number || "").prop('readonly', false);
                        $("#carrier-email").val(importer.email || "").prop('readonly', false);
                        $("#carrier-owner").val(importer.owner || "").prop('readonly', false);
                        const label = document.getElementById("carrier-name-ai-label");
                        if (label) label.classList.remove("d-none");
                    } else {
                        Swal.fire("Greška", "Nema AI podataka za dobavljača", "error");
                    }
                } catch (err) {
                    Swal.fire("Greška", err.message || "Neuspješno dohvaćanje podataka", "error");
                }
            });
        });




    }
</script>



<!-- edit fill -->

<script>
    $.fn.select2.defaults.set("language", {
  searching: function () {
    return "Pretraga...";
  },
  noResults: function () {
    return "Nema rezultata";
  },
  inputTooShort: function (args) {
    return `Unesite još ${args.minimum - args.input.length} znakova`;
  },
  loadingMore: function () {
    return "Učitavanje još rezultata...";
  },
});

    let processedTariffData = [];
    const tariffJsonPromise = fetch("{{ URL::asset('build/json/tariff.json') }}").then(res => res.json());

    function waitForEl(selector, callback) {
        const el = document.querySelector(selector);
        if (el) return callback(el);

        const observer = new MutationObserver(() => {
            const el = document.querySelector(selector);
            if (el) {
                observer.disconnect();
                callback(el);
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    function updateTotalAmount() {
        let total = 0;

        // Loop through all invoice rows
        document.querySelectorAll("#newlink tr.product").forEach(function(row) {
            const price = parseFloat(row.querySelector('input[name="price[]"]')?.value || 0);
            const quantity = parseFloat(row.querySelector('input[name="quantity[]"]')?.value || 0);
            total += price * quantity;
        });

        // Format as currency
        const formatted = `${total.toFixed(2)} KM`;

        // Set values in both places
        document.getElementById("total-amount").value = formatted;
        document.getElementById("modal-total-amount").textContent = formatted;
        document.getElementById("total-edit").textContent = formatted;

    }

    function initializeTariffSelects() {
        $('.select2-tariff').each(function() {
            const select = $(this);
            const prefillValue = select.data("prefill");

            select.select2({
                placeholder: "Pretraži tarifne stavke...",
                width: '100%',
                minimumInputLength: 1,
                ajax: {
                    transport: function(params, success, failure) {
                        const term = params.data.q?.toLowerCase() || "";
                        const filtered = processedTariffData.filter(item => item.search.includes(term));
                        success({
                            results: filtered
                        });
                    },
                    delay: 200
                },
                templateResult: function(item) {
                    if (!item.id && !item.text) return null;
                    const icon = item.isLeaf ? "•" : "▶";
                    return $(`<div style="padding-left:${item.depth * 20}px;" title="${item.display}">${icon} ${item.display}</div>`);
                },
                templateSelection: function(item) {
                    return item.id || "";
                }
            });

            // Optional: support prefill
            if (prefillValue) {
                const match = processedTariffData.find(item => item.id === prefillValue);
                if (match) {
                    const option = new Option(match.display, match.id, true, true);
                    select.append(option).trigger('change');
                }
            }
        });
    }


    document.addEventListener("click", function(e) {
        const btn = e.target.closest("button");
        if (!btn) return;

        const group = btn.closest(".input-group");
        const input = group?.querySelector("input");

        if (!input) return;

        const isMinus = btn.textContent.trim() === "−";
        const isPlus = btn.textContent.trim() === "+";

        if (isMinus || isPlus) {
            const val = parseInt(input.value) || 0;
            const min = parseInt(input.min) || 0;
            input.value = isMinus ? Math.max(min, val - 1) : val + 1;
            updateTotalAmount();
        }
    });


    document.addEventListener("click", function(e) {
        const button = e.target.closest(".remove-row");
        if (!button) return;

        const row = button.closest("tr");

        // Short delay to let the browser fully handle prior UI rendering
        setTimeout(() => {
            Swal.fire({
                title: "Oprez!",
                text: "Odabrani proizvod će biti trajno uklonjen sa popisa trenutne deklaracije. Nakon akcije, deklaraciju morate spasiti!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Odustani",
                confirmButtonText: "Da, ukloni",
                customClass: {
                    confirmButton: "btn btn-soft-info me-2",
                    cancelButton: "btn btn-info"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed && row) {
                    row.remove();
                    updateTotalAmount();
                }
            });
        }, 10);
    });




    document.addEventListener("DOMContentLoaded", async () => {

      if (!invoiceId) return console.log("No ID in URL — skipping load-invoice script.");
const scanId = window.global_invoice_id;
if (scanId && scanId !== invoiceId) {
    console.warn(`Clearing scan_invoice_id (${scanId}) because it does not match invoiceId (${invoiceId})`);
    localStorage.removeItem("scan_invoice_id");
}

Swal.fire({
    title: 'Učitavanje deklaracije...',
    icon: null,
    html: `
        <div class="custom-swal-spinner mb-3"></div>
        <div id="swal-status-message">Molimo sačekajte</div>
    `,
    showConfirmButton: false,
    allowOutsideClick: false,
    didOpen: () => {
        const spinner = document.querySelector(".custom-swal-spinner");
        const icon = Swal.getHtmlContainer()?.previousElementSibling;
        if (icon?.classList.contains('swal2-icon')) {
            icon.remove();
        }

        // ➕ Delay 3 seconds before continuing
        setTimeout(() => {
            // Place your next action here, e.g. fetch invoice or close Swal
            console.log("✅ Ready after 3 seconds");

            // Swal.close(); // or any follow-up logic
        }, 3000);
    }
});



        try {
            const [tariffJson, invoiceRes, suppliersRes, importersRes] = await Promise.all([
                tariffJsonPromise,
                fetch(`/api/invoices/${invoiceId}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }),
                fetch("/api/suppliers", {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }),
                fetch("/api/importers", {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
            ]);

            const invoice = await invoiceRes.json();
            waitForEl("#pregled", (el) => {
                el.addEventListener("click", () => {
                    window.location.href = `/detalji-deklaracije/${invoice.id}`;
                });
            });

            const suppliersJson = await suppliersRes.json();
            const importersJson = await importersRes.json();

            //  CORRECT – this updates the global variable
            processedTariffData = tariffJson
                .filter(item => item["Tarifna oznaka"])
                .map(item => ({
                    id: item["Tarifna oznaka"],
                    text: `${item["Tarifna oznaka"]} – "${item["Naziv"]}"`,
                    display: `${item["Tarifna oznaka"]} – "${item["Naziv"]}"`,
                    search: `${item["Tarifna oznaka"]} ${item["Naziv"]}`.toLowerCase(),
                    isLeaf: item["leaf"] ?? true,
                    depth: item["depth"] ?? 0
                }));


            const supplierOptions = suppliersJson.data.map(s => ({
                id: s.id,
                text: `${s.name} – ${s.address}`,
                full: s
            }));

            const importerOptions = importersJson.data.map(i => ({
                id: i.id,
                text: `${i.name} – ${i.address}`,
                full: i
            }));

            // --- Supplier Select2
            $('#supplier-select2').select2({
                placeholder: "Pretraži klijenta",
                width: '100%',
                data: supplierOptions
            });
            $('#supplier-select2').on('change', async function() {
                const supplierId = $(this).val();
                if (!supplierId) return;
                try {
                    const res = await fetch(`/api/suppliers/${supplierId}`, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    const s = await res.json();
                    setField("#billing-name", s.name);
                    setField("#billing-address-line-1", s.address);
                    setField("#billing-phone-no", s.contact_phone);
                    setField("#billing-tax-no", s.tax_id);
                    setField("#email", s.contact_email);
                    setField("#supplier-owner", s.owner);
                } catch (err) {
                    console.warn("Failed to load supplier:", err);
                }
            });


            // --- Importer Select2
            $('#importer-select2').select2({
                placeholder: "Pretraži dobavljača",
                width: '100%',
                data: importerOptions
            });
            $('#importer-select2').on('change', async function() {
                const importerId = $(this).val();
                if (!importerId) return;
                try {
                    const res = await fetch(`/api/importers/${importerId}`, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    const i = await res.json();
                    setField("#carrier-name", i.name);
                    setField("#carrier-address", i.address);
                    setField("#carrier-tel", i.contact_phone);
                    setField("#carrier-tax", i.tax_id);
                    setField("#carrier-email", i.contact_email);
                    setField("#carrier-owner", i.owner);
                } catch (err) {
                    console.warn("Failed to load importer:", err);
                }
            });

            function formatDateToDDMMYYYY(dateString) {
                if (!dateString) return '';
                if (typeof dateString === 'string') {
                    const [year, month, day] = dateString.split('-');
                    return `${day}.${month}.${year}`;
                } else if (dateString instanceof Date) {
                    const d = dateString;
                    const day = String(d.getDate()).padStart(2, '0');
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const year = d.getFullYear();
                    return `${day}.${month}.${year}`;
                }
                return '';
            }


            function calculateTotal(items) {
                return items.reduce((sum, item) => {
                    const price = parseFloat(item.base_price) || 0;
                    const quantity = parseFloat(item.quantity) || 0;
                    return sum + (price * quantity);
                }, 0).toFixed(2);
            }




            const calculatedTotal = calculateTotal(invoice.items);
            const currency = invoice.items?.[0]?.currency || "EUR";
            console.log("💰 Calculated Total:", calculateTotal(invoice.items));


            // --- Prefill invoice fields
            setField("#invoice_number", invoice.invoice_number);
            setField("#date", invoice.date_of_issue);

            setText("#invoice-id1", invoice.id);
            setText("#invoice-date-text", formatDateToDDMMYYYY(invoice.date_of_issue));

            setField("#invoice-no", invoice.invoice_number);
            setField("#invoice-no1", invoice.id);
            setField("#incoterm", (invoice.incoterm || "").split(" ")[0]);
            setField("#invoice-date", formatDateToDDMMYYYY(invoice.date_of_issue));

            // --- Prefill selected supplier/importer
            if (invoice.supplier_id) {
                const selected = supplierOptions.find(s => s.id === invoice.supplier_id);
                if (selected) {
                    $('#supplier-select2').append(new Option(selected.text, selected.id, true, true)).trigger('change');
                }
            }

            if (invoice.importer_id) {
                const selected = importerOptions.find(i => i.id === invoice.importer_id);
                if (selected) {
                    $('#importer-select2').append(new Option(selected.text, selected.id, true, true)).trigger('change');
                }
            }

            // --- Table rendering
            const tbody = document.querySelector("#newlink");
            tbody.innerHTML = "";

            // Clear previous rows
            tbody.innerHTML = "";

            // Use DocumentFragment for fast DOM appending
            const fragment = document.createDocumentFragment();

            // Append all rows in one operation
            tbody.appendChild(fragment);

            // Update totals only once
            updateTotalAmount();

            // Close loading UI ASAP to unblock interaction
            Swal.close();

            // Defer Select2 initialization to next event loop tick
            setTimeout(() => {
                $('.select2-country').select2({
                    templateResult: formatCountryWithFlag,
                    templateSelection: formatCountryWithFlag,
                    width: 'resolve',
                    minimumResultsForSearch: Infinity
                });

                $('.select2-tariff').select2({
                    data: processedTariffData,
                    width: 'resolve'
                });
            }, 0);

        } catch (e) {
            console.error("Error loading invoice:", e);
            Swal.fire("Greška", "Nije moguće učitati deklaraciju.", "error");
        }
    });

    function setField(selector, value) {
        const el = document.querySelector(selector);
        if (el) el.value = value || "";
    }

    function setText(selector, value) {
        const el = document.querySelector(selector);
        if (el) el.textContent = value || "";
    }

    function generateCountryOptions(selectedCode = "") {
        const countries = [
            "af", "al", "dz", "as", "ad", "ao", "ai", "aq", "ag", "ar", "am", "aw", "au", "at", "az",
            "bs", "bh", "bd", "bb", "by", "be", "bz", "bj", "bm", "bt", "bo", "ba", "bw", "bv", "br", "io", "bn", "bg", "bf", "bi",
            "kh", "cm", "ca", "cv", "ky", "cf", "td", "cl", "cn", "cx", "cc", "co", "km", "cg", "cd", "ck", "cr", "ci", "hr", "cu", "cy", "cz",
            "dk", "dj", "dm", "do", "ec", "eg", "sv", "gq", "er", "ee", "et",
            "fk", "fo", "fj", "fi", "fr", "gf", "pf", "tf", "ga", "gm", "ge", "de", "gh", "gi", "gr", "gl", "gd", "gp", "gu", "gt", "gg", "gn", "gw", "gy",
            "ht", "hm", "va", "hn", "hk", "hu",
            "is", "in", "id", "ir", "iq", "ie", "im", "il", "it",
            "jm", "jp", "je", "jo",
            "kz", "ke", "ki", "kp", "kr", "kw", "kg",
            "la", "lv", "lb", "ls", "lr", "ly", "li", "lt", "lu",
            "mo", "mk", "mg", "mw", "my", "mv", "ml", "mt", "mh", "mq", "mr", "mu", "yt", "mx", "fm", "md", "mc", "mn", "me", "ms", "ma", "mz", "mm",
            "na", "nr", "np", "nl", "nc", "nz", "ni", "ne", "ng", "nu", "nf", "mp", "no",
            "om", "pk", "pw", "ps", "pa", "pg", "py", "pe", "ph", "pn", "pl", "pt", "pr",
            "qa", "re", "ro", "ru", "rw", "bl", "sh", "kn", "lc", "mf", "pm", "vc", "ws", "sm", "st", "sa", "sn", "rs", "sc", "sl", "sg", "sx", "sk", "si", "sb", "so", "za", "gs", "ss", "es", "lk", "sd", "sr", "sj", "se", "ch", "sy",
            "tw", "tj", "tz", "th", "tl", "tg", "tk", "to", "tt", "tn", "tr", "tm", "tc", "tv",
            "ug", "ua", "ae", "gb", "us", "um", "uy", "uz",
            "vu", "ve", "vn", "vg", "vi",
            "wf", "eh",
            "ye",
            "zm", "zw"
        ];

        return countries.map(code => {
            const selected = selectedCode?.toLowerCase() === code ? "selected" : "";
            return `<option value="${code.toUpperCase()}" ${selected}>${code.toUpperCase()}</option>`;
        }).join("");
    }

    function formatCountryWithFlag(state) {
        if (!state.id) return state.text;
        const flagUrl = `https://flagcdn.com/w40/${state.id.toLowerCase()}.png`;
        return $(`<span><img src="${flagUrl}" class="me-2" width="20" /> ${state.text}</span>`);
    }

    function formatToDMY(isoDate) {
        if (!isoDate) return "";
        const [year, month, day] = isoDate.split("-");
        return `${day}-${month}-${year}`;
    }

    // Reformat existing value BEFORE flatpickr init
    const input1 = document.querySelector("#date");
    if (input1 && input1.value.includes("-") && input1.value.length === 10) {
        input1.value = formatToDMY(input1.value);
    }

    const input2 = document.querySelector("#invoice-date");
    if (input2 && input2.value.includes("-") && input2.value.length === 10) {
        input2.value = formatToDMY(input2.value);
    }

    // Now initialize Flatpickr
    flatpickr("#date", {
        locale: "bs",
        dateFormat: "d.m.Y"
    });

    flatpickr("#invoice-date", {
        locale: "bs",
        dateFormat: "d.m.Y"
    });

    function addRowToInvoice() {
        const tbody = document.querySelector("#newlink");
        if (!tbody) return;

        const rowCount = tbody.querySelectorAll("tr.product").length;
        const row = document.createElement("tr");
        row.classList.add("product");

        row.innerHTML = `
<td>${rowCount + 1}</td>
<td colspan="2">
    <div class="input-group" style="display: flex; gap: 0.25rem;">
        <input type="text" class="form-control item-name" name="item_name[]" placeholder="Naziv proizvoda" value="" style="flex:1;">
        <button class="btn btn-outline-info rounded" type="button" onclick="searchFromInputs(this)">
            <i class="fa-brands fa-google"></i>
        </button>
        <input type="text" class="form-control item-desc" name="item_desc[]" placeholder="Opis proizvoda" value="" style="flex:1;">
    </div>
    <input type="text" class="form-control form-control-sm mt-1" name="item_prev[]" style="padding-left:14.4px; height: 37.1px;" placeholder="Prevod" value="">
</td>
<td>
    <select class="form-control select2-tariff" name="item_code[]">
        <option value="" selected></option>
    </select>
</td>
<td><input type="text" class="form-control" name="quantity_type[]" value=""></td>
<td>
    <select class="form-select select2-country" name="origin[]">${generateCountryOptions()}</select>
</td>
<td><input type="number" class="form-control" name="price[]" value=""></td>
<td style="width: 60px;">
    <div class="input-group input-group-sm">
        <button class="btn btn-outline-info btn-sm" type="button" style="height:30px;padding:0 5px;font-size:10px;">−</button>
        <input type="number" class="form-control text-center" name="quantity[]" value="0" min="0" style="padding: 0 5px;">
        <button class="btn btn-outline-info btn-sm" type="button" style="height:30px;padding:0 5px;font-size:10px;">+</button>
    </div>
    <div class="input-group input-group-sm mt-1">
        <button class="btn btn-outline-info btn-sm" type="button" style="height:30px;padding:0 5px;font-size:10px;">−</button>
        <input type="number" class="form-control text-center" name="kolata[]" value="0" min="0">
        <button class="btn btn-outline-info btn-sm" type="button" style="height:30px;padding:0 5px;font-size:10px;">+</button>
    </div>
</td>
<td><input type="text" class="form-control" name="total[]" value="0.00"></td>
<td style="width: 20px; text-align: center;">
    <div style="display: flex; flex-direction: column; align-items: end; gap: 2px;">
        <button type="button" class="btn btn-danger btn-sm remove-row text-center" style="width: 30px;" title="Ukloni red">
            <i class="fas fa-times"></i>
        </button>
        <input type="checkbox" class="form-check-input" style="width: 30px; height: 26.66px;" title="Povlastica DA/NE" />
    </div>
</td>`;

        tbody.appendChild(row);

        // Reinitialize Select2 for newly added row
        $(row).find('.select2-country').select2({
            templateResult: formatCountryWithFlag,
            templateSelection: formatCountryWithFlag,
            width: 'resolve',
            minimumResultsForSearch: Infinity
        });


        updateTotalAmount();
    }

    document.getElementById("add-item")?.addEventListener("click", () => {
        console.log("Dodaj proizvod clicked");
        addRowToInvoice();
        initializeTariffSelects();
    });




    //Remove button logic 
</script>

<div id="pre-ai-overlay" class="{{ isset($id) ? 'd-none' : '' }}">
  <div class="bg-white rounded shadow p-4 text-center" style="width:420px;">
    <h5 class="mb-4" style="font-size: 20px">Pokretanje AI&nbsp;tehnologije</h5>

    <div class="custom-swal-spinner mb-3"></div>

    <div class="text-muted" style="font-size:.9rem;">
      Pripremamo okruženje
    </div>
  </div>
</div>

<script>
const overlay = document.getElementById('pre-ai-overlay');

/*  Pokreći logiku SAMO ako overlay postoji i NIJE već sakriven  */
if (overlay && !overlay.classList.contains('d-none')) {

    setTimeout(() => {
        if (!window.AI_SCAN_STARTED) {

            /*  Sakrij overlay  */
            overlay.classList.add('d-none');
            overlay.style.display = 'none';

            /*  1) Postoji global_invoice_id → prikaži “Uredu / Odustani”  */
            if (window.global_invoice_id) {
                Swal.fire({
                    icon: "error",
                    title: "<div class='text-danger'>Nema pokrenutih procesa za AI obradu</div>",
                    text: "Prikazuje se zadnja obrađena deklaracija",
                    showConfirmButton: true,
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: "Uredu",
                    cancelButtonText: "Odustani",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        confirmButton: "btn btn-info",
                        cancelButton: "btn btn-soft-info me-2"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isDismissed &&
                        result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = "/";
                    }
                });

            /*  2) Nema ni global_invoice_id → automatski redirect  */
            } else {
                Swal.fire({
                    icon: "error",
                    title: "<div class='text-danger'>Nema pokrenutih procesa za AI obradu niti spremih u lokalnom spremniku</div>",
                    text: "Automatsko prebacivanje na početnu stranicu",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => window.location.href = "/");
            }
        }
    }, 12000); // provjera nakon 12 s
}
</script>





<script src="{{ URL::asset('build/js/declaration/swal-declaration-load.js') }}"></script>
@endsection