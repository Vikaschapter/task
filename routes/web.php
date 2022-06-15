<?php

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

////////////////////It Is for admin Home dashboard
Route::get('/',[\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

///////////////////////it is for image create
Route::get('/create-image',[\App\Http\Controllers\Admin\HomeController::class, 'create'])->name('admin.image.create');
Route::post('/store-image',[\App\Http\Controllers\Admin\HomeController::class, 'store'])->name('admin.image.store');
Route::post('/store-upload',[\App\Http\Controllers\Admin\HomeController::class, 'filepond'])->name('admin.image.upload');
Route::post('/delete-upload',[\App\Http\Controllers\Admin\HomeController::class, 'deletefilepond_image'])->name('admin.image.delete.filepond');

///////////////////////it is for delete image
Route::delete('/delete-image/{id}',[\App\Http\Controllers\Admin\HomeController::class,'delete'])->name('admin.image.delete');
Route::Get('/delete-all-image',[\App\Http\Controllers\Admin\HomeController::class,'delete_all'])->name('admin.image.delete.all');


Route::get('/image-edit/{id}',[\App\Http\Controllers\Admin\HomeController::class,'edit'])->name('admin.image.edit');
Route::post('/image-edit/{id}',[\App\Http\Controllers\Admin\HomeController::class,'update'])->name('admin.image.update');
Route::get('/image-remove',[\App\Http\Controllers\Admin\HomeController::class,'removeimage'])->name('admin.image.remove');

/////////////////it is for status of image 
Route::post('/image/status/{id}', [\App\Http\Controllers\Admin\HomeController::class,'status'])->name('admin.image.status');
Route::get('/image/status/activate_all', [\App\Http\Controllers\Admin\HomeController::class,'status_activate'])->name('admin.image.status.activate');

Route::get('/image/status/inactivate_all', [\App\Http\Controllers\Admin\HomeController::class,'status_inactivate'])->name('admin.image.status.inactivate');
