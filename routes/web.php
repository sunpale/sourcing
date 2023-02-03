<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\master_rm\FabricsController;
use App\Http\Controllers\master_rm\KomposisiController;
use App\Http\Controllers\master_warna\ColorsController;
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

Route::get('/', [MainController::class,'index'])->name('main')->middleware('auth:web');
//region Master RM
Route::prefix('master-rm')->middleware('auth:web')->group(function (){
//region Fabric
    Route::get('fabric/generate-code',[FabricsController::class,'generateCode'])->name('fabric.generate-code');
    Route::resource('fabric', FabricsController::class)->except(['create','show']);
//endregion

//region Komposisi
    Route::resource('komposisi', KomposisiController::class)->except(['create','show']);
//endregion
});
//endregion

//region Master Warna
Route::prefix('master-warna')->middleware('auth:web')->group(function (){
//Region Warna MD
    Route::resource('warna', ColorsController::class)->except(['create','show']);
//endregion
});
//endregion
