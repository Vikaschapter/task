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

///////////////////////it is for delete image
Route::delete('/delete-image/{id}',[\App\Http\Controllers\admin\HomeController::class,'delete'])->name('admin.image.delete');


