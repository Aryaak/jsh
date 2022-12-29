<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentRateController;
use App\Http\Controllers\BankRateController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InsuranceTypeController;
use App\Http\Controllers\InsuranceRateController;
use App\Http\Controllers\ObligeeController;
use App\Http\Controllers\PDFDownloadController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\Select2Controller;
use App\Http\Controllers\UploaderController;
use App\Http\Controllers\SuretyBondController;
use App\Http\Controllers\GuaranteeBankController;
use App\Http\Controllers\GuaranteeBankDraftController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SuretyBondReportController;
use App\Http\Controllers\GuaranteeBankReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstalmentController;
use App\Http\Controllers\SuretyBondDraftController;
use App\Models\GuaranteeBankDraft;
use App\Models\SuretyBondDraft;
use Illuminate\Support\Facades\Route;
use App\Helpers\Jamsyar;
use App\Http\Controllers\GuaranteeBankReportPrintController;
use App\Http\Controllers\OtherReportController;
use App\Http\Controllers\OtherReportPrintController;
use App\Http\Controllers\SuretyBondReportPrintController;
use Illuminate\Support\Facades\Request;

/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/pdf/{page}', [DesignController::class, 'pdf'])->name('design.pdf');
Route::get('/design/{page}', [DesignController::class, 'page'])->name('design.page');

Route::get('/test', function (Request $request) {
    // dd(Jamsyar::cities('jsh','Semangat1','sura'));
    // dd(\App\Models\Branch::find(1)->table()->get());
    // dd(\App\Models\GuaranteeBank::table('remain',[])->get());
    // dd(\App\Models\Obligee::find(1)->sync());
    // dd(\App\Models\Principal::find(1)->sync());
    dd(\App\Models\SuretyBond::find(1)->sync());
});
Route::get('/subagent', function (Request $request) {
    $url = config('app.env') == 'local' ? 'http://devmicroservice.jamkrindosyariah.co.id/Api/get_subagen' : 'http://192.168.190.168:8002/Api/get_subagen';
    $response = \Illuminate\Support\Facades\Http::asJson()->acceptJson()->withToken(Jamsyar::login())
    ->post($url, [
        "kode_subagen" => "",
        "nama_subagen" => "",
        "limit" => 20,
        "offset" => 0
    ]);
    dd($response);
});


/**
 * -------------------------------------------------------------------------
 * Guest routes
 * -------------------------------------------------------------------------
 */
Route::get('request-surety-bond', [SuretyBondDraftController::class, 'indexClient'])->name('client');
Route::post('request-surety-bond', [SuretyBondDraftController::class, 'storeClient']);
Route::get('request-bank-garansi', [GuaranteeBankDraftController::class, 'indexClient'])->name('bgc');
Route::post('request-bank-garansi', [GuaranteeBankDraftController::class, 'storeClient']);
Route::get('principal-client/{principal}', [PrincipalController::class, 'show'])->name('client.principal');
Route::get('obligee-client/{obligee}', [ObligeeController::class, 'show'])->name('client.obligee');
Route::get('serviceworker.js', fn() => redirect()->route('main.dashboard')); // Entah kenapa beberapa kali login malah masuk ke sini

/**
 * -------------------------------------------------------------------------
 * Select2 Route
 * -------------------------------------------------------------------------
 */

Route::group(['prefix' => '/select2', 'as' => 'select2.'], function () {
    Route::get('regional',[Select2Controller::class,'regional'])->name('regional');
    Route::get('branch',[Select2Controller::class,'branch'])->name('branch');
    Route::get('branch-client',[Select2Controller::class,'branch_client'])->name('branchClient');
    Route::get('bank',[Select2Controller::class,'bank'])->name('bank');
    Route::get('province',[Select2Controller::class,'province'])->name('province');
    Route::get('city',[Select2Controller::class,'city'])->name('city');
    Route::get('agent',[Select2Controller::class,'agent'])->name('agent');
    Route::get('insurance',[Select2Controller::class,'insurance'])->name('insurance');
    Route::get('obligee',[Select2Controller::class,'obligee'])->name('obligee');
    Route::get('principal',[Select2Controller::class,'principal'])->name('principal');
    Route::get('insurance-type',[Select2Controller::class,'insuranceType'])->name('insuranceType');
    Route::get('suretyTemplate',[Select2Controller::class,'suretyTemplate'])->name('suretyTemplate');
    Route::get('bankTemplate/{id}',[Select2Controller::class,'bankTemplate'])->name('bankTemplate');
});

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware(['auth'])->group(function () {
    Route::post('/uploader/tinymce', [UploaderController::class, 'tinyMCE'])->name('uploader.tinymce'); // tolong disesuaikan ya
    Route::get('/pdf/download/{id}', [PDFDownloadController::class, 'pdf']);
    Route::post('/pdf/download-template/', [PDFDownloadController::class, 'pdfTemplate'])->name('pdf.print');
    Route::post('/pdf/download-laporan-surety-bonds/', [PDFDownloadController::class, 'pdfSB'])->name('pdf.print.sb');

    // Master Data (bisa diakses di semua role)

    Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
        Route::get('/', fn() => redirect(route('dashboard')));
        Route::apiResource('asuransi', InsuranceController::class)->names('insurances')->except('index');
        Route::apiResource('agen', AgentController::class)->names('agents')->except('index');
        Route::put('principal/{principal}/sync', [PrincipalController::class, 'sync'])->name('principals.sync');
        Route::get('principal/sync-with-jamsyar', [PrincipalController::class, 'jamsyar'])->name('principals.jamsyar');
        Route::apiResource('principal', PrincipalController::class)->names('principals')->except('index');
        Route::apiResource('rate-agen', AgentRateController::class)->names('agent-rates')->except('index');
        Route::apiResource('jenis-jaminan', InsuranceTypeController::class)->names('insurance-types')->except('index');
        Route::apiResource('rate-asuransi', InsuranceRateController::class)->names('insurance-rates')->except('index');
        Route::apiResource('rate-bank', BankRateController::class)->names('bank-rates')->except('index');
        Route::apiResource('bank', BankController::class)->names('banks')->except('index');
        Route::put('obligee/{obligee}/sync', [ObligeeController::class, 'sync'])->name('obligees.sync');
        Route::get('obligee/sync-with-jamsyar', [ObligeeController::class, 'jamsyar'])->name('obligees.jamsyar');
        Route::apiResource('obligee', ObligeeController::class)->names('obligees')->except('index');
        Route::apiResource('template', TemplateController::class)->names('templates')->except('index');
    });

    // Pembayaran (beberapa aksi bisa diakses di semua role)

    Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
        Route::get('/', [PaymentController::class, 'tables'])->name('tables');
        Route::post('hitung', [PaymentController::class, 'calculate'])->name('calculate');
        Route::apiResource('/payment', PaymentController::class, ['only' => ['store', 'show', 'destroy']])->names('payment');
    });

    // Admin Pusat

    Route::group(['middleware' => 'main', 'as' => 'main.'], function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
        Route::apiResource('regional', RegionalController::class)->names('regionals');

        Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::get('asuransi', [InsuranceController::class, 'index'])->name('insurances.index');
            Route::get('agen', [AgentController::class, 'index'])->name('agents.index');
            Route::get('principal', [PrincipalController::class, 'index'])->name('principals.index');
            Route::get('rate-agen', [AgentRateController::class, 'index'])->name('agent-rates.index');
            Route::get('jenis-jaminan', [InsuranceTypeController::class, 'index'])->name('insurance-types.index');
            Route::get('rate-asuransi', [InsuranceRateController::class, 'index'])->name('insurance-rates.index');
            Route::get('rate-bank', [BankRateController::class, 'index'])->name('bank-rates.index');
            Route::get('bank', [BankController::class, 'index'])->name('banks.index');
            Route::get('obligee', [ObligeeController::class, 'index'])->name('obligees.index');
            Route::get('template', [TemplateController::class, 'index'])->name('templates.index');
        });

        Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [SuretyBondReportController::class, 'remain'])->name('remain');
            Route::match(['get', 'post'], '/pemasukan', [SuretyBondReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [SuretyBondReportController::class, 'expense'])->name('expense');
            Route::match(['get', 'post'], '/laba', [SuretyBondReportController::class, 'profit'])->name('profit');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [SuretyBondReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [SuretyBondReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [SuretyBondReportPrintController::class, 'remain'])->name('remain');
                Route::get('/pemasukan/{print}', [SuretyBondReportPrintController::class, 'income'])->name('income');
                Route::get('/pengeluaran/{print}', [SuretyBondReportPrintController::class, 'expense'])->name('expense');
                Route::get('/laba/{print}', [SuretyBondReportPrintController::class, 'profit'])->name('profit');
            });

            // Route untuk laporan surety bond ....
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [GuaranteeBankReportController::class, 'remain'])->name('remain');
            Route::match(['get', 'post'], '/pemasukan', [GuaranteeBankReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [GuaranteeBankReportController::class, 'expense'])->name('expense');
            Route::match(['get', 'post'], '/laba', [GuaranteeBankReportController::class, 'profit'])->name('profit');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [GuaranteeBankReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [GuaranteeBankReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [GuaranteeBankReportPrintController::class, 'remain'])->name('remain');
                Route::get('/pemasukan/{print}', [GuaranteeBankReportPrintController::class, 'income'])->name('income');
                Route::get('/pengeluaran/{print}', [GuaranteeBankReportPrintController::class, 'expense'])->name('expense');
                Route::get('/laba/{print}', [GuaranteeBankReportPrintController::class, 'profit'])->name('profit');
            });

            // Route untuk laporan bank garansi ....
        });

        Route::group(['prefix' => '/laporan-lainnya', 'as' => 'other-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/laba', [OtherReportController::class, 'profit'])->name('profit');
            Route::match(['get', 'post'], '/cicil-cabang', [OtherReportController::class, 'installment'])->name('installment');

            Route::group(['as' => 'print.'], function () {
                Route::get('/laba/{print}', [OtherReportPrintController::class, 'profit'])->name('profit');
                Route::get('/cicil-cabang/{print}', [OtherReportPrintController::class, 'installment'])->name('installment');
            });

            // Route untuk laporan lainnya ....
        });
    });

    // Admin Regional

    Route::group(['middleware' => 'regional', 'prefix' => '/{regional:slug}', 'as' => 'regional.'], function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
        Route::apiResource('cabang', BranchController::class)->names('branches');
        Route::apiResource('pengeluaran', ExpenseController::class)->names('expenses');

        Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::get('asuransi', [InsuranceController::class, 'index'])->name('insurances.index');
            Route::get('agen', [AgentController::class, 'index'])->name('agents.index');
            Route::get('principal', [PrincipalController::class, 'index'])->name('principals.index');
            Route::get('rate-agen', [AgentRateController::class, 'index'])->name('agent-rates.index');
            Route::get('jenis-jaminan', [InsuranceTypeController::class, 'index'])->name('insurance-types.index');
            Route::get('rate-asuransi', [InsuranceRateController::class, 'index'])->name('insurance-rates.index');
            Route::get('rate-bank', [BankRateController::class, 'index'])->name('bank-rates.index');
            Route::get('bank', [BankController::class, 'index'])->name('banks.index');
            Route::get('obligee', [ObligeeController::class, 'index'])->name('obligees.index');
            Route::get('template', [TemplateController::class, 'index'])->name('templates.index');
        });

        Route::group(['prefix' => '/produk', 'as' => 'products.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::get('surety-bond', [SuretyBondController::class, 'index'])->name('surety-bonds.index');
            Route::get('surety-bond/{surety_bond}', [SuretyBondController::class, 'showRegional'])->name('surety-bonds.show');
            Route::get('surety-bond/{surety_bond}/print-score', [SuretyBondController::class, 'printScoreRegional'])->name('surety-bonds.print-score');
            Route::get('bank-garansi', [GuaranteeBankController::class, 'index'])->name('guarantee-banks.index');
            Route::get('bank-garansi/{bank_garansi}', [GuaranteeBankController::class, 'showRegional'])->name('guarantee-banks.show');
            Route::get('bank-garansi/{bank_garansi}/print-score', [GuaranteeBankController::class, 'printScoreRegional'])->name('guarantee-banks.print-score');

            // Route untuk produk ....
        });

        Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
            Route::get('ke-asuransi', [PaymentController::class, 'indexRegionalToInsurance'])->name('regional-to-insurance.index');
        });

        Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [SuretyBondReportController::class, 'remain'])->name('remain');
            Route::match(['get', 'post'], '/pemasukan', [SuretyBondReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [SuretyBondReportController::class, 'expense'])->name('expense');
            Route::match(['get', 'post'], '/laba', [SuretyBondReportController::class, 'profit'])->name('profit');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [SuretyBondReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [SuretyBondReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [SuretyBondReportPrintController::class, 'remain'])->name('remain');
                Route::get('/pemasukan/{print}', [SuretyBondReportPrintController::class, 'income'])->name('income');
                Route::get('/pengeluaran/{print}', [SuretyBondReportPrintController::class, 'expense'])->name('expense');
                Route::get('/laba/{print}', [SuretyBondReportPrintController::class, 'profit'])->name('profit');
            });

            // Route untuk laporan surety bond ....
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [GuaranteeBankReportController::class, 'remain'])->name('remain');
            Route::match(['get', 'post'], '/pemasukan', [GuaranteeBankReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [GuaranteeBankReportController::class, 'expense'])->name('expense');
            Route::match(['get', 'post'], '/laba', [GuaranteeBankReportController::class, 'profit'])->name('profit');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [GuaranteeBankReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [GuaranteeBankReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [GuaranteeBankReportPrintController::class, 'remain'])->name('remain');
                Route::get('/pemasukan/{print}', [GuaranteeBankReportPrintController::class, 'income'])->name('income');
                Route::get('/pengeluaran/{print}', [GuaranteeBankReportPrintController::class, 'expense'])->name('expense');
                Route::get('/laba/{print}', [GuaranteeBankReportPrintController::class, 'profit'])->name('profit');
            });

            // Route untuk laporan bank garansi ....
        });

        Route::group(['prefix' => '/laporan-lainnya', 'as' => 'other-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/laba', [OtherReportController::class, 'profit'])->name('profit');
            Route::match(['get', 'post'], '/cicil-cabang', [OtherReportController::class, 'installment'])->name('installment');

            Route::group(['as' => 'print.'], function () {
                Route::get('/laba/{print}', [OtherReportPrintController::class, 'profit'])->name('profit');
                Route::get('/cicil-cabang/{print}', [OtherReportPrintController::class, 'installment'])->name('installment');
            });
            // Route untuk laporan lainnya ....
        });
    });

    // Admin Cabang

    Route::group(['middleware' => 'branch', 'prefix' => '/{regional:slug}/{branch:slug}', 'as' => 'branch.'], function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

        Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::get('asuransi', [InsuranceController::class, 'index'])->name('insurances.index');
            Route::get('agen', [AgentController::class, 'index'])->name('agents.index');
            Route::get('principal', [PrincipalController::class, 'index'])->name('principals.index');
            Route::get('rate-agen', [AgentRateController::class, 'index'])->name('agent-rates.index');
            Route::get('jenis-jaminan', [InsuranceTypeController::class, 'index'])->name('insurance-types.index');
            Route::get('rate-asuransi', [InsuranceRateController::class, 'index'])->name('insurance-rates.index');
            Route::get('rate-bank', [BankRateController::class, 'index'])->name('bank-rates.index');
            Route::get('bank', [BankController::class, 'index'])->name('banks.index');
            Route::get('obligee', [ObligeeController::class, 'index'])->name('obligees.index');
            Route::get('template', [TemplateController::class, 'index'])->name('templates.index');
        });

        Route::group(['prefix' => '/produk', 'as' => 'products.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::put('surety-bond/{surety_bond}/update-status', [SuretyBondController::class, 'changeStatus'])->name('surety-bonds.update-status');
            Route::get('surety-bond/{surety_bond}/print-score', [SuretyBondController::class, 'printScore'])->name('surety-bonds.print-score');
            Route::get('surety-bond/{surety_bond}/cetak', [SuretyBondController::class, 'print'])->name('surety-bonds.print');
            Route::apiResource('surety-bond', SuretyBondController::class)->names('surety-bonds');
            Route::apiResource('surety-bond-draft', SuretyBondDraftController::class)->names('draft');
            Route::post('surety-bond-draft/{surety_bond_draft}', [SuretyBondDraftController::class, 'approve'])->name('client.approve');
            Route::put('surety-bond-draft/{surety_bond_draft}', [SuretyBondDraftController::class, 'decline'])->name('client.decline');
            Route::put('bank-garansi/{bank_garansi}/update-status', [GuaranteeBankController::class, 'changeStatus'])->name('guarantee-banks.update-status');
            Route::get('bank-garansi/{bank_garansi}/print-score', [GuaranteeBankController::class, 'printScore'])->name('guarantee-banks.print-score');
            Route::get('bank-garansi/{bank_garansi}/cetak', [GuaranteeBankController::class, 'print'])->name('guarantee-banks.print');
            Route::apiResource('bank-garansi', GuaranteeBankController::class)->names('guarantee-banks');
            Route::apiResource('bank-garansi-draft', GuaranteeBankDraftController::class)->names('draft.bg');
            Route::post('bank-garansi-draft/{bank_garansi_draft}', [GuaranteeBankDraftController::class, 'approve'])->name('client.approve.bg');
            Route::put('bank-garansi-draft/{bank_garansi_draft}', [GuaranteeBankDraftController::class, 'decline'])->name('client.decline.bg');

            // Route untuk produk ....
        });

        Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
            Route::get('ke-agen', [PaymentController::class, 'indexBranchToAgent'])->name('branch-to-agent.index');

            Route::get('ke-regional', [InstalmentController::class, 'index'])->name('branch-to-regional.index');
            Route::post('ke-regional/store', [InstalmentController::class, 'store'])->name('branch-to-regional.store');
            Route::post('ke-regional/calculate', [InstalmentController::class, 'calculate'])->name('branch-to-regional.calculate');
            Route::post('ke-regional/payable', [InstalmentController::class, 'payable'])->name('branch-to-regional.payable');
            Route::delete('ke-regional/{instalment}/destroy', [InstalmentController::class, 'destroy'])->name('branch-to-regional.destroy');
        });

        Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [SuretyBondReportController::class, 'remain'])->name('remain');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [SuretyBondReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [SuretyBondReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [SuretyBondReportPrintController::class, 'remain'])->name('remain');
            });

            // Route untuk laporan surety bond ...
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'production'])->name('production');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/sisa-agen', [GuaranteeBankReportController::class, 'remain'])->name('remain');

            Route::group(['as' => 'print.'], function () {
                Route::get('/produksi/{print}', [GuaranteeBankReportPrintController::class, 'production'])->name('production');
                Route::get('/keuangan/{print}', [GuaranteeBankReportPrintController::class, 'finance'])->name('finance');
                Route::get('/sisa-agen/{print}', [GuaranteeBankReportPrintController::class, 'remain'])->name('remain');
            });

            // Route untuk laporan bank garansi ...
        });

        Route::group(['prefix' => '/laporan-lainnya', 'as' => 'other-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/cicil-cabang', [OtherReportController::class, 'installment'])->name('installment');
            Route::get('/cicil-cabang/{print}', [OtherReportPrintController::class, 'installment'])->name('print.installment');

            // Route untuk laporan lainnya ....
        });
    });
});
