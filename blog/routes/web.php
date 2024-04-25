<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\PostController;
use  App\Http\Controllers\user\ProfileController;

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
   return view('welcome');
});



 




///// the first blog using laravel ////////
Route::middleware('verified')->group(function(){


   Route::get('/posts/create',[PostController::class,'create'])->name('posts.create');
   
   Route::get('/posts/{post}',[PostController::class,'show'])->name('posts.show');
   
   Route::post('/posts',[PostController::class,'store'])->name('posts.store');
   
   Route::get('/posts/{post}/edit',[PostController::class,'edit'])->name('posts.edit');
   
   Route::put('/posts/{post}', [PostController::class,'update'])->name('posts.update');
   
   Route::post('/posts/{post}', [PostController::class,'destroy'])->name('posts.destroy');
   
   Route::get('/posts',[PostController::class,'index'])->name('posts.index');
   
   Route::get('/user/profile', [ProfileController::class,'profileInfo'])->name( 'user.profile' );
   
   ///// maroooooooooooooooooooooooooooooooooo
   });
   
   Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
