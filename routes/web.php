<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(ImageController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/download/{id}', 'download')->name('image.download_as_zip');
    Route::post('/image','store')->name('image.store');
});
