<?php

use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentRateController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InsuranceTypeController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\Select2Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn () => view('welcome'))->name('dashboard');
Route::get('/uploader/tinymce', null)->name('uploader.tinymce'); // tolong disesuaikan ya
Route::resource('branches',BranchController::class);
Route::resource('regionals',RegionalController::class);
Route::resource('insurances',InsuranceController::class);
Route::resource('agents',AgentController::class);
Route::resource('bank_accounts',BankAccountController::class);
Route::apiResource('principals',PrincipalController::class);
Route::apiResource('agent-rates',AgentRateController::class);
Route::resource('insurance-types',InsuranceTypeController::class);

Route::get('select2/regional',[Select2Controller::class,'regional'])->name('select2.regional');
Route::get('select2/branch',[Select2Controller::class,'branch'])->name('select2.branch');
Route::get('select2/bank',[Select2Controller::class,'bank'])->name('select2.bank');
Route::get('select2/province',[Select2Controller::class,'province'])->name('select2.province');
Route::get('select2/city',[Select2Controller::class,'city'])->name('select2.city');
Route::get('select2/agent',[Select2Controller::class,'agent'])->name('select2.agent');
Route::get('select2/insurance',[Select2Controller::class,'insurance'])->name('select2.insurance');
Route::get('select2/insurance-type',[Select2Controller::class,'insuranceType'])->name('select2.insuranceType');
/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/{page}', DesignController::class);
