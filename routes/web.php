<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\LulusController;

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

Route::get('/', function () {
    return view('homepage');
});

Route::get('/pjj', [GoogleDriveController::class, 'index']);
Route::get('/pjj/siswa', [GoogleDriveController::class, 'listFiles']);
Route::get('/pjj/guru', [GoogleDriveController::class, 'indexGuru']);
Route::post('/pjj/upload-file/{kelas}/{hari}', [GoogleDriveController::class, 'uploadToGD']);
Route::get('/pjj/login', [GoogleDriveController::class, 'login']);
Route::get('/pjj/logout', [GoogleDriveController::class, 'logout']);
Route::get('/pjj/upload', [GoogleDriveController::class, 'uploadPage']);
Route::get('/pjj/callback', [GoogleDriveController::class, 'callback']);
Route::get('/download/{fileId}', 'App\Http\Controllers\PJJController@download')->name('download');

Route::get('/lulus',[LulusController::class,'index']);
