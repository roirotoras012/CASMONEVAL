<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationKeyController;

use App\Http\Controllers\RegionalDirector;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::middleware(['auth'])->group(function () {
//     Route::resource('users', UserController::class);
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');

//     Route::get('/admin/users', [UserController::class, 'adminView'])->name('users.adminView');

// });

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/admin/users', [UserController::class, 'adminView'])->name('users.adminView');
    Route::resource('users', UserController::class)->middleware(['auth']);
    Route::post('/registerUser', [RegistrationKeyController::class, 'create'])->name('registerUser.create');

});



// Regional Director

// Route::middleware(['auth'])->group(function () {
//     Route::get('rd/dashboard', [UserController::class, 'index'])->name('users.index');
   
// });
Route::get('rd/dashboard', [RegionalDirector::class, 'index'])->name('users.index');