<?php

use App\Http\Controllers\DesignController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\RegionalController;
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

/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/{page}', DesignController::class);
