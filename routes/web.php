<?php

use App\Http\Controllers\auth\PermissionController;
use App\Http\Controllers\auth\RoleController;
use App\Http\Controllers\BOM\BomsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\master_aks\AksesorisController;
use App\Http\Controllers\master_aks\ProductGroupsController;
use App\Http\Controllers\master_data\ArticlesController;
use App\Http\Controllers\master_data\BrandsController;
use App\Http\Controllers\master_data\MeasuresController;
use App\Http\Controllers\master_data\SizeController;
use App\Http\Controllers\master_data\SuppliersController;
use App\Http\Controllers\master_rm\FabricsController;
use App\Http\Controllers\master_rm\KomposisiController;
use App\Http\Controllers\master_rm\MaterialsController;
use App\Http\Controllers\master_warna\ColorAksController;
use App\Http\Controllers\master_warna\ColorsController;
use App\Http\Controllers\master_warna\PantonesController;
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
Route::get('/images/{path}/{file}',[MainController::class,'viewImage']);
Route::get('/images/conversions/{path}/{file}',[MainController::class,'viewThumbnail']);
//region Master RM
Route::prefix('master-rm')->middleware(['auth'/*,'permission:create-master'*/])->name('master-rm.')->group(function (){
//region Fabric
    Route::get('fabric/generate-code',[FabricsController::class,'generateCode'])->name('fabric.generate-code');
    Route::resource('fabric', FabricsController::class)->except(['create','show']);
//endregion

//region Komposisi
    Route::resource('komposisi', KomposisiController::class)->except(['create','show']);
//endregion
//region material
    Route::get('/raw-material/generate-code',[MaterialsController::class,'generateCode'])->name('raw-material.generate-code');
    Route::get('/raw-material/data',[MaterialsController::class,'data'])->name('raw-material.data');
    Route::get('raw-material/view-image/{file}',[MaterialsController::class,'viewImage'])->name('raw-material.view-image');
    Route::resource('raw-material',MaterialsController::class);
//endregion
});
//endregion

//region Master Warna
Route::prefix('master-warna')->middleware('auth:web')->name('master-warna.')->group(function (){
//Region Warna MD
    Route::resource('warna', ColorsController::class)->except(['create','show']);
//endregion
//region Warna Pantone
    Route::resource('pantone', PantonesController::class)->except(['create','show']);
//endregion
//region Warna Aksesoris
    Route::resource('warna-aksesoris', ColorAksController::class)->except(['create','show']);
//endregion
});
//endregion

//region Master Data
Route::prefix('master-data')->middleware('auth:web')->group(function (){
//region Brand
    Route::resource('brands', BrandsController::class)->except(['create','show']);
//endregion
//region Unit of Measure
    Route::resource('measure', MeasuresController::class)->except(['show','create']);
//endregion
//region Supplier
    Route::resource('supplier', SuppliersController::class)->names(['show' => 'supplier.data']);
    Route::get('data-supplier',[SuppliersController::class,'getSupplier'])->name('suppliers.data-supplier');
//endregion
//region Article
    Route::get('/articles/data',[ArticlesController::class,'data'])->name('articles.data');
    Route::resource('articles', ArticlesController::class)->except('show');
//endregion
//region Aricle Size
    Route::resource('article-size', SizeController::class)->except(['show','create']);
//endregion
});
//endregion

//region Master Aksesoris
Route::prefix('master-aksesoris')->middleware('auth:web')->name('master-aks.')->group(function (){
//region Product Group
    Route::resource('product-group', ProductGroupsController::class)->except(['create','show']);
//endregion
    Route::get('/aksesoris/data',[AksesorisController::class,'data'])->name('aksesoris.data');
    Route::get('/aksesoris/view-image/{file}',[AksesorisController::class,'viewImage'])->name('aksesoris.view-image');
    Route::resource('aksesoris', AksesorisController::class);
});
//endregion

//region BOM
Route::prefix('bom')->middleware('auth:web')->name('bom.')->group(function (){
    Route::get('/',[BomsController::class,'index'])->name('index');

});
//endregion

//Region Auth
Route::prefix('auth')->middleware(['auth','role:Super Admin'])->group(function (){
//region Role
    Route::resource('role', RoleController::class)->except(['create','show']);
// endregion
//region Permission
    Route::resource('permission', PermissionController::class)->except(['create','show']);
//endregion
});
//endregion
