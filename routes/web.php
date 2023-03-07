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
use App\Http\Controllers\ProfileUpdateHandlerController;



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
     Route::get('rd/logout', [RegionalDirector::class, 'logout'])->name('rd.logout');
     Route::post('add_targets', [RegionalDirector::class, 'add_targets'])->name('add_targets');
    });
    

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:2'])->group(function () {
   
    // Regional Planning Officer
    Route::get('rpo/dashboard', [RegionalPlanningOfficerController::class, 'adminView'])->name('rpo.adminView');

    Route::get('rpo/users', [RegionalPlanningOfficerController::class, 'users'])->name('rpo.users');
    
    Route::get('rpo/addtarget', [RegionalPlanningOfficerController::class, 'opcr_target'])->name('rpo.opcr_target');
    Route::get('rpo/savedtarget  ', [RegionalPlanningOfficerController::class, 'savetarget']);
    Route::get('rpo/opcr/{id}  ', [RegionalPlanningOfficerController::class, 'show'])->name('rpo.show');
    Route::get('rpo/assessment', [RegionalPlanningOfficerController::class, 'assessment']);
    Route::get('rpo/profile', [RegionalPlanningOfficerController::class, 'profile'])->name('profile');
    Route::post('rpo/profile/update-email', [RegionalPlanningOfficerController::class, 'updateEmailHandler'])->name('rpo.updateEmailHandler');
    Route::post('rpo/profile/update-password', [RegionalPlanningOfficerController::class, 'updatePasswordHandler'])->name('rpo.updatePasswordHandler');
    Route::post('add_targets', [RegionalPlanningOfficerController::class, 'add_targets'])->name('add_targets');
    Route::post('update_targets', [RegionalPlanningOfficerController::class, 'update_targets'])->name('update_targets');


    
    // Route::get('rpo/dashboard', [RegionalPlanningOfficerController::class, 'users_view'])->name('users_view');
    Route::resource('rpo', RegionalPlanningOfficerController::class)->middleware(['auth']);
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
    Route::get('ppo/addtarget', [ProvincialPlanningOfficerController::class, 'addtarget'])->name('addtarget');
    Route::get('ppo/add-driver', [ProvincialPlanningOfficerController::class, 'savetarget']);
    Route::get('ppo/manage', [ProvincialPlanningOfficerController::class, 'accomplishment'])->name('manage');
    Route::get('ppo/assessment', [ProvincialPlanningOfficerController::class, 'assessment']);
    Route::get('ppo/profile', [ProvincialPlanningOfficerController::class, 'profile']);
    Route::post('ppo/drivers', [ProvincialPlanningOfficerController::class, 'store'])->name('drivers.store');
    Route::post('ppo/measures', [ProvincialPlanningOfficerController::class, 'store'])->name('measures.store');
    Route::post('measure_update', [ProvincialPlanningOfficerController::class, 'measure_update'])->name('measure_update');
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:5'])->group(function () {
  // Division Chief
  Route::get('dc/dashboard', [DivisionChiefController::class, 'index'])->name('dc.index');
  Route::get('dc/coaching', [DivisionChiefController::class, 'coaching']);
  Route::get('dc/job-fam', [DivisionChiefController::class, 'jobfam']);
  Route::get('dc/accomplishment', [DivisionChiefController::class, 'accomplishment']);
  Route::get('dc/profile', [DivisionChiefController::class, 'profile']);

});

// Route::middleware(['auth', 'App\Http\Middleware\CheckRole:6'])->group(function () {
//     // ADMIN
//     // Route::resource('users', UserController::class)->middleware(['auth']);
//     // Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     // Route::get('/admin/users', [UserController::class, 'adminView'])->name('users.adminView');
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
// });

