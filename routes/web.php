<?php
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\RegionalDirector;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\DivisionChiefController;
use App\Http\Controllers\RegistrationKeyController;
use App\Http\Controllers\ProvincialDirectorController;
use App\Http\Controllers\ProfileUpdateHandlerController;

use App\Http\Controllers\RegionalPlanningOfficerController;
use App\Http\Controllers\ProvincialPlanningOfficerController;

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
    Route::post('rd/profile/update-email', [RegionalDirector::class, 'updateEmailHandler'])->name('rd.updateEmailHandler');
    Route::post('rd/profile/update-password', [RegionalDirector::class, 'updatePasswordHandler'])->name('rd.updatePasswordHandler');
    Route::get('rd/opcr-target', [RegionalDirector::class, 'opcr_target'])->name('rd.opcr_target');
    Route::get('rd/logout', [RegionalDirector::class, 'logout'])->name('rd.logout');
    Route::post('add_targets', [RegionalDirector::class, 'add_targets'])->name('add_targets');
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:2'])->group(function () {
    // Regional Planning Officer
    Route::get('rpo/dashboard', [RegionalPlanningOfficerController::class, 'index'])->name('rpo.index');

    Route::get('rpo/users', [RegionalPlanningOfficerController::class, 'users'])->name('rpo.users');
    Route::get('rpo/measures', [RegionalPlanningOfficerController::class, 'measures'])->name('rpo.measures');
    Route::get('rpo/addtarget', [RegionalPlanningOfficerController::class, 'opcr_target'])->name('rpo.opcrarget');
    Route::get('rpo/savedtarget  ', [RegionalPlanningOfficerController::class, 'savetarget']);
    Route::get('rpo/opcr/{id}  ', [RegionalPlanningOfficerController::class, 'show'])->name('rpo.show');
    Route::get('rpo/assessment', [RegionalPlanningOfficerController::class, 'assessment']);
    Route::get('rpo/profile', [RegionalPlanningOfficerController::class, 'profile'])->name('profile');
    Route::post('rpo/profile/update-email', [RegionalPlanningOfficerController::class, 'updateEmailHandler'])->name('rpo.updateEmailHandler');
    Route::post('rpo/profile/update-password', [RegionalPlanningOfficerController::class, 'updatePasswordHandler'])->name('rpo.updatePasswordHandler');
    Route::post('add_targets', [RegionalPlanningOfficerController::class, 'add_targets'])->name('add_targets');
    Route::post('update_targets', [RegionalPlanningOfficerController::class, 'update_targets'])->name('update_targets');
    Route::post('add_objective', [RegionalPlanningOfficerController::class, 'add_objective'])->name('rpo.add_objective');
    Route::post('add_measure', [RegionalPlanningOfficerController::class, 'add_measure'])->name('rpo.add_measure');
    Route::post('remove_objective', [RegionalPlanningOfficerController::class, 'remove_objective'])->name('rpo.remove_objective');
    Route::post('remove_measure', [RegionalPlanningOfficerController::class, 'remove_measure'])->name('rpo.remove_measure');

    // Route::get('rpo/dashboard', [RegionalPlanningOfficerController::class, 'users_view'])->name('users_view');
    Route::resource('rpo', RegionalPlanningOfficerController::class)->middleware(['auth']);
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:3'])->group(function () {
    // PD routes here
    // Provincial Director
    Route::get('pd/dashboard', [ProvincialDirectorController::class, 'index'])->name('pd.index');
    Route::get('pd/addtarget', [ProvincialDirectorController::class, 'addtarget']);
    Route::get('pd/savetarget', [ProvincialDirectorController::class, 'savetarget']);
    //  Route::get('pd/assessment', [ProvincialDirectorController::class, 'assessment']);
    Route::get('pd/profile', [ProvincialDirectorController::class, 'profile']);
    Route::post('pd/profile/update-email', [ProvincialDirectorController::class, 'updateEmailHandler'])->name('pd.updateEmailHandler');
    Route::post('pd/profile/update-password', [ProvincialDirectorController::class, 'updatePasswordHandler'])->name('pd.updatePasswordHandler');
    Route::get('pd/accomplishment', [ProvincialDirectorController::class, 'accomplishment']);
    Route::get('pd/assessment', [ProvincialDirectorController::class, 'assessment'])->name('pd.assessment');
    Route::post('eval/remark', [EvaluationController::class, 'addRemark'])->name('eval.remark');

    Route::get('pd/savedtarget  ', [ProvincialDirectorController::class, 'savetarget']);
    Route::get('pd/opcr/{id}  ', [ProvincialDirectorController::class, 'show'])->name('pd.show');
});
Route::middleware(['auth', 'App\Http\Middleware\CheckRole:4'])->group(function () {
    // Provincial Planning Officer
    Route::get('ppo/dashboard', [ProvincialPlanningOfficerController::class, 'index'])->name('ppo.index');
    Route::get('ppo/opcr', [ProvincialPlanningOfficerController::class, 'opcr'])->name('opcr');
    // Route::get('ppo/add-driver', [ProvincialPlanningOfficerController::class, 'savetarget'])->name('add-driver');
    // Route::get('ppo/manage', [ProvincialPlanningOfficerController::class, 'manage'])->name('manage');
    Route::get('ppo/bdd', [ProvincialPlanningOfficerController::class, 'bdd'])->name('bdd');
    Route::get('ppo/cpd', [ProvincialPlanningOfficerController::class, 'cpd'])->name('cpd');
    Route::get('ppo/fad', [ProvincialPlanningOfficerController::class, 'fad'])->name('fad');
    Route::get('ppo/profile', [ProvincialPlanningOfficerController::class, 'profile']);
    Route::post('ppo/profile/update-email', [ProvincialPlanningOfficerController::class, 'updateEmailHandler'])->name('ppo.updateEmailHandler');
    Route::post('ppo/profile/update-password', [ProvincialPlanningOfficerController::class, 'updatePasswordHandler'])->name('ppo.updatePasswordHandler');
    Route::post('ppo/drivers', [ProvincialPlanningOfficerController::class, 'store'])->name('drivers.store');
    Route::post('ppo/measures', [ProvincialPlanningOfficerController::class, 'store'])->name('measures.store');
    Route::post('measure_update', [ProvincialPlanningOfficerController::class, 'measure_update'])->name('measure_update');
    Route::post('ppo/submit_to_division', [ProvincialPlanningOfficerController::class, 'submit_to_division'])->name('submit_to_division');
    // Route::post('eval/reason', [EvaluationController::class, 'addReason'])->name('eval.store');
    Route::post('ppo/dashboard', [ProvincialPlanningOfficerController::class, 'notifyToDC'])->name('notify_to_dc');
    Route::post('ppo/monthly_target_validate', [ProvincialPlanningOfficerController::class, 'validateMonthlyTarget'])->name('monthly_target.validate');
});

Route::middleware(['auth', 'App\Http\Middleware\CheckRole:5'])->group(function () {
  // Division Chief
  Route::get('dc/dashboard', [DivisionChiefController::class, 'index'])->name('dc.index');
  Route::get('dc/manage', [DivisionChiefController::class, 'manage'])->name('dc.manage');
  Route::get('dc/coaching', [DivisionChiefController::class, 'coaching']);
  Route::get('dc/job-fam', [DivisionChiefController::class, 'jobfam']);
  Route::get('dc/view-target', [DivisionChiefController::class, 'bukidnunBddIndex'])->name('dc.bukidnunBddIndex');
  Route::get('dc/accomplishment', [DivisionChiefController::class, 'accomplishment'])->name('dc.accomplishments');
  
  Route::post('dc/monthly_targets', [DivisionChiefController::class, 'store'])->name('dc.store');
  Route::post('dc/dashboard', [DivisionChiefController::class, 'updateTar'])->name('dc.updateTar');
  Route::post('dc/monthly_accomplishment', [DivisionChiefController::class, 'storeAccom'])->name('dc.store-accom');
  Route::get('dc/profile', [DivisionChiefController::class, 'profile']);
  Route::post('dc/profile/update-email', [DivisionChiefController::class, 'updateEmailHandler'])->name('dc.updateEmailHandler');
  Route::post('dc/profile/update-password', [DivisionChiefController::class, 'updatePasswordHandler'])->name('dc.updatePasswordHandler');
  Route::post('eval/reason', [EvaluationController::class, 'addReason'])->name('eval.reason');
  Route::post('add_driver', [DivisionChiefController::class, 'add_driver'])->name('dc.add_driver');

  Route::post('dc/accomplishment', [DivisionChiefController::class, 'sentToPD'])->name('notify_to_pd');
  
});

// NOTIFICATIONS

// PPO
Route::get('/notifications', [ProvincialPlanningOfficerController::class, 'getNotifications'])
    ->name('get_notifications')
    ->middleware('auth');
Route::post('/notifications/mark-all-as-read', [ProvincialPlanningOfficerController::class, 'markNotificationsAsRead'])
    ->name('mark_all_as_read')
    ->middleware('auth');

Route::post('/notifications/mark-as-read', [ProvincialPlanningOfficerController::class, 'markAsRead'])
    ->name('mark_as_read')
    ->middleware('auth');


// PD

Route::get('/notifications', [ProvincialDirectorController::class, 'getNotifications'])
->name('get_notifications')
->middleware('auth');
Route::post('/notifications/mark-all-as-read', [ProvincialDirectorController::class, 'markNotificationsAsRead'])
->name('mark_all_as_read')
->middleware('auth');

Route::post('/notifications/mark-as-read', [ProvincialDirectorController::class, 'markAsRead'])
->name('mark_as_read')
->middleware('auth');

// DIVISION CHIEF
Route::get('/notifications', [DivisionChiefController::class, 'getNotifications'])
    ->name('get_notifications')
    ->middleware('auth');
Route::post('/notifications/mark-all-as-read', [DivisionChiefController::class, 'markNotificationsAsRead'])
    ->name('mark_all_as_read')
    ->middleware('auth');

Route::post('/notifications/mark-as-read', [DivisionChiefController::class, 'markAsRead'])
    ->name('mark_as_read')
    ->middleware('auth');


