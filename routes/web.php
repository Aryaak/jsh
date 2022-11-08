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
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', fn () => view('welcome'))->name('dashboard');
Route::post('/uploader/tinymce', [UploaderController::class, 'tinyMCE'])->name('uploader.tinymce'); // tolong disesuaikan ya
Route::get('/pdf/download/{id}', [PDFDownloadController::class, 'pdf']);

Route::group(['prefix' => '/master-data', 'as' => 'master.'], function () {
    // Route::get('/', fn() => redirect(route('dashboard')));

    Route::apiResource('cabang',BranchController::class)->names('branches');
    Route::apiResource('regional',RegionalController::class)->names('regionals');
    Route::apiResource('asuransi',InsuranceController::class)->names('insurances');
    Route::apiResource('agen',AgentController::class)->names('agents');
    Route::apiResource('principal',PrincipalController::class)->names('principals');
    Route::apiResource('rate-agen',AgentRateController::class)->names('agent-rates');
    Route::apiResource('jenis-jaminan',InsuranceTypeController::class)->names('insurance-types');
    Route::apiResource('rate-asuransi',InsuranceRateController::class)->names('insurance-rates');
    Route::apiResource('rate-bank',BankRateController::class)->names('bank-rates');
    Route::apiResource('bank',BankController::class)->names('banks');
    Route::apiResource('obligee',ObligeeController::class)->names('obligees');
    Route::apiResource('template',TemplateController::class)->names('templates');
    Route::apiResource('/',DashboardController::class)->names('dashboard');
});

Route::group(['prefix' => '/produk', 'as' => 'products.'], function () {
    Route::apiResource('surety-bond',SuretyBondController::class)->names('surety-bonds');
    Route::apiResource('bank-garansi',GuaranteeBankController::class)->names('guarantee-banks');
    // Route::get('/', fn() => redirect(route('dashboard')));

    // Route untuk produk ....
});

Route::group(['prefix' => '/pembayaran', 'as' => 'payments.'], function () {
    Route::get('/',[PaymentController::class,'tables'])->name('tables');
    Route::post('calculate',[PaymentController::class,'calculate'])->name('calculate');
    Route::get('principal-ke-cabang',[PaymentController::class,'indexPrincipalToBranch'])->name('principal-to-branch.index');
    Route::get('regional-ke-asuransi',[PaymentController::class,'indexRegionalToInsurance'])->name('regional-to-insurance.index');
    Route::apiResource('/payment',PaymentController::class,['only' => ['store','show','destroy']])->names('payment');
    // Route::group(['prefix' => '/hitung','as' => 'calculate.'], function () {
    //     Route::get('principal-ke-cabang',[PaymentController::class,'calculatePrincipalToBranch'])->name('principal-to-branch');
    // });
    // Route untuk pembayaran ....
});

Route::group(['prefix' => '/laporan-surety-bond', 'as' => 'sb-reports.'], function () {
    Route::get('/', fn() => redirect(route('dashboard')));

    // Route untuk laporan surety bond ....
});

Route::group(['prefix' => '/laporan-bank-garansi', 'as' => 'bg-reports.'], function () {
    Route::get('/', fn() => redirect(route('dashboard')));

    // Route untuk laporan bank garansi ....
});

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

/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/{page}', DesignController::class);
