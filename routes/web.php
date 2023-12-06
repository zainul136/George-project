<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractorsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RolePermisssion;
use App\Http\Controllers\UserController;
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


// use Illuminate\Support\Facades\DB;

// Route::get('/check-database', function () {
//     try {
//         DB::connection()->getPdo();
//         if (DB::connection()->getDatabaseName()) {
//             return "Successfully connected to the database: " . DB::connection()->getDatabaseName();
//         }
//     } catch (\Exception $e) {
//         return "Could not connect to the database. Please check your configuration. Error: " . $e->getMessage();
//     }
// });


Route::controller(Controller::class)->group(function () {
    Route::get('view-invitation-email/{invitation_id}/{email}/{password}', 'view_invitation_email')->name('view.invitation');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'login')->name('admin:login');
    Route::post('/auth', 'auth')->name('admin:auth');
    Route::get('admins/dashboard', 'dashboard')->name('admin:dashboard')->middleware('url:dashboard');
    Route::post('income-expense-chart', 'get_income_expense_chart')->name('admin:get_income_expense_chart');
    Route::post('profit-bar-chart', 'get_profit_data')->name('admin:get_profit_data');
    Route::get('admins/dashboard_calendar', 'dashboard_calendar')->name('admin:dashboard_calendar')->middleware('url:dashboard');
    Route::get('/logout', 'logout')->name('admin:logout');
    Route::get('/forget', 'forgot')->name('admin:forgot');
    Route::get('admins/profile', 'profile')->name('admin:profile');
    Route::post('/forgot-password', 'forgot_password')->name('admin:forgotPassword');
    Route::post('/reset-password', 'reset_password')->name('admin:resetPassword');
    Route::get('/reset-password/{token}', 'reset_password')->name('admin.password.get');
    Route::post('/change-password', 'change_password')->name('admin.password.change');

    // Createing Admin
    Route::get('admins/admin-create', 'create')->name('admin:create')->middleware('url:admin-create');
    Route::get('admins/admin-list', 'list')->name('admin:list')->middleware('url:admin-list');
    Route::post('admins/admin-store', 'store')->name('admin:store')->middleware('url:admin-store');
    Route::get('admins/admin-edit/{code}', 'edit')->name('admin:edit')->middleware('url:admin-edit');
    Route::post('admins/admin-update-password', 'admin_change_password')->name('admin:update.change_password')->middleware('url:admin-update-password');
    Route::get('admins/admin-view/{code}', 'view')->name('admin:view')->middleware('url:admin-view');
    Route::post('admins/admin-update', 'update')->name('admin:update')->middleware('url:admin-update');
    Route::delete('admins/admin-delete', 'delete')->name('admin:delete')->middleware('url:admin-delete');
    Route::post('admins/admin-find', 'find')->name('admin:find')->middleware('url:admin-find');
    Route::post('admins-update-status', 'update_status')->name('admin:update_status')->middleware('url:admin-status');
});

// Route::controller(UserController::class)->group(function () {
//     Route::get('/user-create', 'create')->name('user:create')->middleware('url');
//     Route::get('/user-list', 'list')->name('user:list')->middleware('url');
//     Route::post('/user-store', 'store')->name('user:store')->middleware('url');
// });
Route::get('/project-to-do', [ProjectController::class, 'to_do_list'])->name('project:to_do_list');
Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::get('/project-create', 'create')->name('project:create')->middleware('url:project-create');
    Route::get('/project-list', 'list')->name('project:list')->middleware('url:project-list');
    Route::post('/project-store', 'store')->name('project:store')->middleware('url:project-store');
    Route::get('/project-edit/{code}', 'edit')->name('project:edit')->middleware('url:project-edit');
    Route::get('/project-view/{code}', 'view')->name('project:view')->middleware('url:project-view');
    Route::post('/project-update', 'update')->name('project:update')->middleware('url:project-update');
    Route::delete('/project-delete', 'delete')->name('project:delete')->middleware('url:project-delete');
    Route::post('/project-find', 'find')->name('project:find')->middleware('url:project-find');
    Route::post('/project-update-status', 'update_status')->name('project:update_status')->middleware('url:project-update-status');
    // Route::get('/project-find', 'find')->name('project:find')->middleware('url');
    // Route::post('/project-update-status', 'update_status')->name('project:update_status')->middleware('url');
    Route::post('/project-fetch_available_contractors', 'fetch_available_contractors')->name('project:fetch_available_contractors');
    Route::post('/project-add-event', 'add_event')->name('project:add_event')->middleware('url:project-update');
    Route::get('/project-event-details/{id}', 'eventDetails')->name('project:event-details');
    Route::get('/project-event-sortable', 'eventDetailsUpdate')->name('project:event-sortable');
    Route::post('/project-event-update', 'updateEventDates')->name('project:updateEventDates');
    Route::post('/event-update-status', 'updateEventStatus')->name('project:event.updateStatus');
    Route::post('/event-find', 'eventFind')->name('Event:find');
    Route::post('/project-edit-event', 'edit_event')->name('project:edit_event');
    Route::post('/update-status', 'ProjectController@updateStatus')->name('project.updateStatus');
    Route::delete('/project-delete-event', 'delete_event')->name('project:delete_event');
    Route::delete('/project-delete-invitation', 'delete_invitation')->name('project:delete_invitation');
    Route::delete('/project-delete-payment', 'delete_payment')->name('project:delete_payment');
    Route::post('/project-add-payment', 'add_payment')->name('project:add_payment')->middleware('url:project-update');
});

Route::prefix('employees')->controller(EmployeeController::class)->group(function () {
    Route::get('/employee-create', 'create')->name('employee:create')->middleware('url:employee-create');
    Route::post('/employee-store', 'store')->name('employee:store')->middleware('url:employee-store');
    Route::get('/employee-list', 'list')->name('employee:list')->middleware('url:employee-list');
    Route::get('/employee-edit/{code}', 'edit')->name('employee:edit')->middleware('url:employee-edit');
    Route::get('/employee-view/{code}', 'view')->name('employee:view')->middleware('url:employee-view');
    Route::post('/employee-update', 'update')->name('employee:update')->middleware('url:employee-update');
    Route::delete('/employee-delete', 'delete')->name('employee:delete')->middleware('url:employee-delete');
    Route::post('/employee-find', 'find')->name('employee:find')->middleware('url:employee-find');
    Route::post('/employee-add-payment', 'add_payment')->name('employee:add_payment');


    Route::post('/employee-update-status', 'update_status')->name('employee:update_status')->middleware('url:employee-update-status');
    Route::post('/employee-update-password', 'update_password')->name('employee:update_password')->middleware('url:employee-update-password');
});

Route::prefix('companies')->controller(CompanyController::class)->group(function () {
    Route::get('/company-create', 'create')->name('company:create')->middleware('url:company-create');
    Route::post('/company-store', 'store')->name('company:store')->middleware('url:company-store');
    Route::get('/company-list', 'list')->name('company:list')->middleware('url:company-list');
    Route::get('/company-edit/{code}', 'edit')->name('company:edit')->middleware('url:company-edit');
    Route::get('/company-view/{code}', 'view')->name('company:view')->middleware('url:company-view');
    Route::post('/company-update', 'update')->name('company:update')->middleware('url:company-update');
    Route::delete('/company-delete', 'delete')->name('company:delete')->middleware('url:company-delete');
    Route::post('/company-find', 'find')->name('company:find')->middleware('url:company-find');
    Route::post('/company-update-status', 'update_status')->name('company:update_status')->middleware('url:company-update-status');
});

Route::prefix('contractors')->controller(ContractorsController::class)->group(function () {
    Route::get('/contractor-create', 'create')->name('contractor:create')->middleware('url:contractor-create');
    Route::post('/contractor-store', 'store')->name('contractor:store')->middleware('url:contractor-store');
    Route::get('/contractor-list', 'list')->name('contractor:list')->middleware('url:contractor-list');
    Route::get('/contractor-edit/{code}', 'edit')->name('contractor:edit')->middleware('url:contractor-edit');
    Route::get('/contractor-view/{code}', 'view')->name('contractor:view')->middleware('url:contractor-view');
    Route::post('/contractor-update', 'update')->name('contractor:update')->middleware('url:contractor-update');
    Route::delete('/contractor-delete', 'delete')->name('contractor:delete')->middleware('url:contractor-delete');
    Route::post('/contractor-find', 'find')->name('contractor:find')->middleware('url:contractor-find');
    Route::post('/contractor-add-payment', 'add_payment')->name('contractor:add_payment');
    Route::post('/contractor-update-status', 'update_status')->name('contractor:update_status')->middleware('url:contractor-update-status');
    Route::post('/contractor-update-password', 'update_password')->name('contractor:update_password')->middleware('url:contractor-update-password');
});

Route::prefix('clients')->controller(ClientController::class)->group(function () {
    Route::get('/client-create', 'create')->name('client:create')->middleware('url:client-create');
    Route::post('/client-store', 'store')->name('client:store')->middleware('url:client-store');
    Route::get('/client-list', 'list')->name('client:list')->middleware('url:client-list');
    Route::get('/client-edit/{code}', 'edit')->name('client:edit')->middleware('url:client-edit');
    Route::get('/client-view/{code}', 'view')->name('client:view')->middleware('url:client-view');
    Route::post('/client-update', 'update')->name('client:update')->middleware('url:client-update');
    Route::delete('/client-delete', 'delete')->name('client:delete')->middleware('url:client-delete');
    Route::post('/client-find', 'find')->name('client:find')->middleware('url:client-find');
    Route::post('/client-update-status', 'update_status')->name('client:update_status')->middleware('url:client-update-status');
});

Route::prefix('role_permission')->controller(RolePermisssion::class)->group(function () {
    Route::get('/role-create', 'create')->name('role:create')->middleware('url:role-create');
    Route::get('/role-list', 'list')->name('role:list')->middleware('url:role-list');
    Route::post('/role-store', 'store')->name('role:store')->middleware('url:role-store');
    Route::post('/role-update', 'update')->name('role:update')->middleware('url:role-update');
});

Route::prefix('invitations')->controller(InvitationController::class)->group(function () {
    Route::get('/invite-create', 'create')->name('invite:create')->middleware('url:invite-create');
    Route::post('/invite-store', 'store')->name('invite:store')->middleware('url:invite-store');
    Route::get('/invite-list', 'list')->name('invite:list')->middleware('url:invite-list');
    Route::get('/invite-edit/{code}', 'edit')->name('invite:edit')->middleware('url:invite-edit');
    Route::get('/invite-view/{code}', 'view')->name('invite:view')->middleware('url:invite-view');
    Route::post('/invite-find', 'find')->name('invite:find')->middleware('url:invite-find');
    Route::post('/invite-update', 'update')->name('invite:update')->middleware('url:invite-update');
    Route::post('/invite-update-status', 'update_status')->name('invite:update_status')->middleware('url:invite-update-status');

    // Route::get('/invite-create', 'create')->name('invite:create')->middleware('url');
    // Route::get('/invite-list', 'list')->name('invite:list')->middleware('url');
    // Route::post('/invite-store', 'store')->name('invite:store')->middleware('url');
    // Route::get('/invite-edit/{code}', 'edit')->name('invite:edit')->middleware('url');
    // Route::post('/invite-update', 'update')->name('invite:update')->middleware('url');
});
