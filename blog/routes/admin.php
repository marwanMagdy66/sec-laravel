<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('admin/dashboard/login',[AdminLoginController::class,'login'])->name('admin.dashboard.login');

Route::post('admin/dashboard/login',[AdminLoginController::class,'checkLogin'])->name('admin.dashboard.check');

Route::get('admin/dashboard/register',[AdminRegisterController::class,'register'])->name('admin.dashboard.register');

Route::post('admin/dashboard/register',[AdminRegisterController::class,'store'])->name('admin.dashboard.store');

Route::post('admin/dashboard/logout',[AdminLoginController::class,'logout'])->name('admin.dashboard.logout');



// Route::middleware(['admin'])->group(function(){


    Route::get('admin/posts/create',[AdminHomeController::class,'create'])->name('admin.posts.create')->middleware('auth:admin');
    
    Route::get('admin/posts/{post}',[AdminHomeController::class,'show'])->name('admin.posts.show')->middleware('auth:admin');
    
    Route::post('admin/posts',[AdminHomeController::class,'store'])->name('admin.posts.store')->middleware('auth:admin');
    
    Route::get('admin/posts/{post}/edit',[AdminHomeController::class,'edit'])->name('admin.posts.edit')->middleware('auth:admin');
    
    Route::put('admin/posts/{post}', [AdminHomeController::class,'update'])->name('admin.posts.update')->middleware('auth:admin');
    
    Route::delete('admin/posts/{post}',[AdminHomeController::class,'destroy'])->name('admin.posts.destroy')->middleware('auth:admin');
    
    Route::get('admin/dashboard/home',[AdminHomeController::class,'home'])->name('admin.dashboard.home')->middleware('auth:admin');

    Route::get('admin/dashboard/edit/users',[AdminHomeController::class,'edit_users'])->name('admin.edit.users')->middleware('auth:admin');
   
    Route::delete('/posts/{post}',[AdminHomeController::class,'delete_users'])->name('admin.destroy')->middleware('auth:admin');
    
    // });
    
    // Auth::routes(['verify'=>true]);
