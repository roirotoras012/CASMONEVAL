<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegistrationKeyController;
use App\Http\Middleware\CheckRole;

use App\Http\Controllers\RegionalDirector;
use App\Http\Controllers\ProvincialDirectorController;
use App\Http\Controllers\RegionalPlanningOfficerController;
use App\Http\Controllers\ProvincialPlanningOfficerController;
use App\Http\Controllers\DivisionChiefController;


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

Route::post('/registerUser', [RegistrationKeyController::class, 'create'])->name('registerUser.create');
Route::get('/register-validated', [RegistrationKeyController::class, 'index'])->name('registerUser.index');
Route::get('/register-error', [RegistrationKeyController::class, 'error'])->name('registerUser.error');
Route::get('/register-key', [RegistrationKeyController::class, 'checkKey'])->name('registerUser.checkKey');



Route::middleware(['auth', 'App\Http\Middleware\CheckRole:1'])->group(function () {
    // RD routes here
     // Regional Director
     Route::get('rd/dashboard', [RegionalDirector::class, 'index'])->name('rd.index');
     Route::get('rd/assessment', [RegionalDirector::class, 'assessment']);
     Route::get('rd/profile', [RegionalDirector::class, 'profile']);
     Route::get('rd/opcr-target', [RegionalDirector::class, 'opcr_target'])->name('rd.opcr_target');
     Route::post('add_targets', [RegionalDirector::class, 'add_targets'])->name('add_targets');
});
    

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:2'])->group(function () {
   
    // Regional Planning Officer
    Route::get('rpo/dashboard', [RegionalPlanningOfficerController::class, 'index'])->name('rpo.index');
    Route::get('rpo/addtarget', [RegionalPlanningOfficerController::class, 'addtarget']);
    Route::get('rpo/savetarget', [RegionalPlanningOfficerController::class, 'savetarget']);
    Route::get('rpo/assessment', [RegionalPlanningOfficerController::class, 'assessment']);
    Route::get('rpo/profile', [RegionalPlanningOfficerController::class, 'profile']);
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:3'])->group(function () {
    // PD routes here
     // Provincial Director
     Route::get('pd/dashboard', [ProvincialDirectorController::class, 'index'])->name('pd.index');
     Route::get('pd/addtarget', [ProvincialDirectorController::class, 'addtarget']);
     Route::get('pd/savetarget', [ProvincialDirectorController::class, 'savetarget']);
     Route::get('pd/assessment', [ProvincialDirectorController::class, 'assessment']);
     Route::get('pd/profile', [ProvincialDirectorController::class, 'profile']);
     Route::get('pd/accomplishment', [ProvincialDirectorController::class, 'accomplishment']);
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:4'])->group(function () {
    // Provincial Planning Officer
    Route::get('ppo/dashboard', [ProvincialPlanningOfficerController::class, 'index'])->name('ppo.index');
    Route::get('ppo/addtarget', [ProvincialPlanningOfficerController::class, 'addtarget']);
    Route::get('ppo/savetarget', [ProvincialPlanningOfficerController::class, 'savetarget']);
    Route::get('ppo/accomplishment', [ProvincialPlanningOfficerController::class, 'accomplishment']);
    Route::get('ppo/assessment', [ProvincialPlanningOfficerController::class, 'assessment']);
    Route::get('ppo/profile', [ProvincialPlanningOfficerController::class, 'profile']);
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:5'])->group(function () {
  // Division Chief
  Route::get('dc/dashboard', [DivisionChiefController::class, 'index'])->name('dc.index');
  Route::get('dc/coaching', [DivisionChiefController::class, 'coaching']);
  Route::get('dc/job-farm', [DivisionChiefController::class, 'jobfam']);
  Route::get('dc/accomplishment', [DivisionChiefController::class, 'accomplishment']);
  Route::get('dc/profile', [DivisionChiefController::class, 'profile']);
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:6'])->group(function () {
    // ADMIN
    // Route::resource('users', UserController::class)->middleware(['auth']);
    // Route::get('/users', [UserController::class, 'index'])->name('users.index');
    // Route::get('/admin/users', [UserController::class, 'adminView'])->name('users.adminView');
    // Route::get('/home', [HomeController::class, 'index'])->name('home');


    // Route::resource('admin', UserController::class)->middleware(['auth']);
    // Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
    // Route::get('/admin/users', [UserController::class, 'adminView'])->name('admin.adminView');
    // Route::get('/admin/home', [HomeController::class, 'index'])->name('home');
    Route::resource('admin', UserController::class);
    Route::get('/admin', [UserController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [UserController::class, 'adminView'])->name('admin.adminView');
    Route::get('/admin/home', [HomeController::class, 'index'])->name('home');

  });


   