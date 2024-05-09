<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

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
  
// Route::get('/', function () {
//     return view('welcome');
// });



Route::get('login', [AuthController::class,'login'])->name('login');
Route::post('login-submit', [AuthController::class, 'login_submit'])->name('login_submit');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [AuthController::class, 'register'])->name('register');
Route::post('register-submit', [AuthController::class, 'register_submit'])->name('register_submit');

////// Admin Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('index', [AuthController::class, 'index'])->name('admin.index');
    Route::get('edit-user/{id}', [AuthController::class, 'edit_user'])->name('admin.edit_user');
    Route::post('update', [AuthController::class, 'update'])->name('admin.update');
    Route::post('delete_user', [AuthController::class, 'delete_user'])->name('admin.delete_user');
    Route::post('showdata', [AuthController::class, 'showdata'])->name('admin.showdata');
    

  


});




