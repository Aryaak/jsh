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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SuretyBondReportController;
use App\Http\Controllers\GuaranteeBankReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/{page}', DesignController::class);

/**
 * -------------------------------------------------------------------------
 * Select2 Route
 * -------------------------------------------------------------------------
 */

Route::group(['prefix' => '/select2', 'as' => 'select2.'], function () {
    Route::get('regional',[Select2Controller::class,'regional'])->name('regional');
    Route::get('branch',[Select2Controller::class,'branch'])->name('branch');
    Route::get('bank',[Select2Controller::class,'bank'])->name('bank');
    Route::get('province',[Select2Controller::class,'province'])->name('province');
    Route::get('city',[Select2Controller::class,'city'])->name('city');
    Route::get('agent',[Select2Controller::class,'agent'])->name('agent');
    Route::get('insurance',[Select2Controller::class,'insurance'])->name('insurance');
    Route::get('obligee',[Select2Controller::class,'obligee'])->name('obligee');
    Route::get('principal',[Select2Controller::class,'principal'])->name('principal');
    Route::get('insurance-type',[Select2Controller::class,'insuranceType'])->name('insuranceType');
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

    // Master Data (bisa diakses di semua role)

    Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
        Route::get('/', fn() => redirect(route('dashboard')));
        Route::apiResource('asuransi', InsuranceController::class)->names('insurances')->except('index');
        Route::apiResource('agen', AgentController::class)->names('agents')->except('index');
        Route::apiResource('principal', PrincipalController::class)->names('principals')->except('index');
        Route::apiResource('rate-agen', AgentRateController::class)->names('agent-rates')->except('index');
        Route::apiResource('jenis-jaminan', InsuranceTypeController::class)->names('insurance-types')->except('index');
        Route::apiResource('rate-asuransi', InsuranceRateController::class)->names('insurance-rates')->except('index');
        Route::apiResource('rate-bank', BankRateController::class)->names('bank-rates')->except('index');
        Route::apiResource('bank', BankController::class)->names('banks')->except('index');
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
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/pemasukan', [SuretyBondReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [SuretyBondReportController::class, 'expense'])->name('expense');

            // Route untuk laporan surety bond ....
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/pemasukan', [GuaranteeBankReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [GuaranteeBankReportController::class, 'expense'])->name('expense');

            // Route untuk laporan bank garansi ....
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
            Route::get('bank-garansi', [GuaranteeBankController::class, 'index'])->name('guarantee-banks.index');
            Route::get('bank-garansi/{bank_garansi}', [GuaranteeBankController::class, 'showRegional'])->name('guarantee-banks.show');

            // Route untuk produk ....
        });

        Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
            Route::get('ke-asuransi', [PaymentController::class, 'indexRegionalToInsurance'])->name('regional-to-insurance.index');
        });

        Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/pemasukan', [SuretyBondReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [SuretyBondReportController::class, 'expense'])->name('expense');

            // Route untuk laporan surety bond ....
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
            Route::match(['get', 'post'], '/pemasukan', [GuaranteeBankReportController::class, 'income'])->name('income');
            Route::match(['get', 'post'], '/pengeluaran', [GuaranteeBankReportController::class, 'expense'])->name('expense');

            // Route untuk laporan bank garansi ....
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
            Route::apiResource('surety-bond', SuretyBondController::class)->names('surety-bonds');
            Route::apiResource('bank-garansi', GuaranteeBankController::class)->names('guarantee-banks');

            // Route untuk produk ....
        });

        Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
            Route::get('ke-regional', [PaymentController::class, 'indexBranchToRegional'])->name('branch-to-regional.index');
            Route::get('ke-agen', [PaymentController::class, 'indexBranchToAgent'])->name('branch-to-agent.index');
            Route::post('payment-to-regional', [PaymentController::class, 'storeToRegional'])->name('branch-to-regional.store');
            Route::post('calculate-to-regional', [PaymentController::class, 'calculateToRegional'])->name('branch-to-regional.calculate');
        });

        Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [SuretyBondReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [SuretyBondReportController::class, 'finance'])->name('finance');
        });

        Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
            Route::get('/', fn() => redirect(route('dashboard')));
            Route::match(['get', 'post'], '/produksi', [GuaranteeBankReportController::class, 'product'])->name('product');
            Route::match(['get', 'post'], '/keuangan', [GuaranteeBankReportController::class, 'finance'])->name('finance');
        });
    });
});
