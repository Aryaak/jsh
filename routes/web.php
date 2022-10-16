<?php

use App\Http\Controllers\DesignController;
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


/**
 * -------------------------------------------------------------------------
 * Design Only Route
 * -------------------------------------------------------------------------
 */

Route::get('/design/{page}', DesignController::class);
