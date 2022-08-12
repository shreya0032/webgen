<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\TableController; 
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\PermissionMiddlware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::redirect('/', 'login');

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// // Route::get('/', [HomeController::class, 'login'])->name('auth.login');
// Route::post('/login', [HomeController::class, 'checkLogin'])->name('check.login');

Route::get('/dashboard', [HomeController::class, 'showDashboard'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {


    // resources/views/admin/table/tableFilter.blade.php   

    /*===================Dynamic Table========================*/
    // Route::group(['middleware' => [PermissionMiddlware::class, 'users']], function() {

    // Route::get('table/{table}', [TableController::class, 'tableShow'])->name('table.show')->middleware(['permission:details|add|edit']);
    // Route::get('table/{table}/get', [TableController::class, 'getTableData'])->name('product.get')->middleware('permission:details');
    // Route::get('table/{table}/add', [TableController::class, 'tableAdd'])->name('product.add')->middleware('permission:add');
    // Route::post('table/{table}/add/save', [TableController::class, 'tableSave'])->name('product.add.save')->middleware('permission:add');
    // Route::get('table/{table}/edit/{id?}', [TableController::class, 'editTableList'])->name('product.edit')->middleware('permission:edit');
    // Route::post('table/{table}/edit/update', [TableController::class, 'updateTableList'])->name('product.update')->middleware('permission:edit');
    // Route::get('table/{table}/delete/{id?}', [TableController::class, 'deleteTableList'])->name('product.delete')->middleware('permission:delete');
    // Route::get('table/{table}/getrow', [TableController::class, 'getrow']);
    // Route::get('table/filter/{table}/', [TableController::class, 'filter'])->name('filter');
    // Route::post('table/filter-search/{table}/', [TableController::class, 'filterSearch'])->name('filter.search');
    // // Route::get('table/{table}/filter-result', function(){return view('admin.table.tableFilter');})->name('filter.result');
    // Route::get('export/csv/{table}', [TableController::class, 'exportCsv'])->name('export.csv');

    // });





    /*===================Role========================*/
    // Route::group(['middleware' => 'role:super admin'], function () {

    // Route::get('/activity-log', [TableController::class, 'activityLog'])->name('activity_log');
    // Route::get('/activity-log/getAjax', [TableController::class, 'getactivityLog'])->name('activity_log.show');

    Route::group(['prefix' => 'roles'], function () {
        Route::get('index', [RoleController::class, 'index'])->name('roles.index')->middleware(['permission:Details|Add|Edit|Delete']);
        Route::get('role-list-ajax', [RoleController::class, 'getRoleList'])->name('roles.list')->middleware('permission:Details');;
        Route::get('create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:Add');
        Route::post('store', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:Add');
        Route::get('edit/{id?}', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:Edit');
        Route::post('update', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:Edit');
        Route::get('delete/{id?}', [RoleController::class, 'delete'])->name('roles.delete')->middleware('permission:Delete');
        Route::post('delete/selected', [RoleController::class, 'deleteSelected'])->name('roles.delete.selected')->middleware('permission:Delete');
        Route::get('manage-permission/{id?}', [RoleController::class, 'managePermission'])->name('roles.permission')->middleware('permission:Delete');
        Route::post('update/manage-permission', [RoleController::class, 'updatePermission'])->name('roles.permission.update')->middleware('permission:Edit');
        Route::get('delete/manage-permission/{rid?}/{pid?}', [RoleController::class, 'deletePermission'])->name('roles.permission.delete')->middleware('permission:Delete');
    });

    // /*===================Permission========================*/ 
    Route::group(['prefix' => 'permission'], function () {
        Route::get('index', [PermissionController::class, 'index'])->name('permission.index')->middleware(['permission:Details|Add|Edit|Delete']);
        Route::get('permission-list-ajax', [PermissionController::class, 'getPermissionList'])->name('permission.list')->middleware('permission:Details');
        Route::get('permission-table-list-ajax', [PermissionController::class, 'getTableList'])->name('permission.table.list')->middleware('permission:Details');
        Route::get('create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:Add');
        Route::post('store', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:Add');
        Route::get('edit/{id?}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware('permission:Edit');
        Route::post('update', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:Edit');
        Route::get('delete/{id?}', [PermissionController::class, 'delete'])->name('permission.delete')->middleware('permission:Delete');
        Route::post('delete/selected', [PermissionController::class, 'deleteSelectedPermission'])->name('permission.delete.selected')->middleware('permission:Delete');
    });

    /*===================Company========================*/
    Route::group(['prefix' => 'company'], function () {
        Route::get('index', [CompanyController::class, 'index'])->name('company.index')->middleware(['permission:Details|Add|Edit|Delete']);
        Route::get('company-list-ajax', [CompanyController::class, 'getCompanyList'])->name('company.list')->middleware('permission:Details');
        Route::get('create', [CompanyController::class, 'create'])->name('company.create')->middleware('permission:Add');
        Route::post('store', [CompanyController::class, 'store'])->name('company.store')->middleware('permission:Add');
        Route::get('edit/{id?}', [CompanyController::class, 'edit'])->name('company.edit')->middleware('permission:Edit');
        Route::post('update', [CompanyController::class, 'update'])->name('company.update')->middleware('permission:Edit');
        Route::get('delete/{id?}', [CompanyController::class, 'delete'])->name('company.delete')->middleware('permission:Delete');
    });

    /*===================Employee========================*/
    Route::group(['prefix' => 'employee'], function () {
        Route::get('index', [EmployeeController::class, 'index'])->name('employee.index')->middleware(['permission:Details|Add|Edit|Delete']);
        Route::get('employee-list-ajax', [EmployeeController::class, 'getEmployeeList'])->name('employee.list')->middleware('permission:Details');;
        Route::get('create', [EmployeeController::class, 'create'])->name('employee.create')->middleware('permission:Add');
        Route::post('store', [EmployeeController::class, 'store'])->name('employee.store')->middleware('permission:Add');
        Route::get('edit/{id?}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware('permission:Edit');
        Route::post('update', [EmployeeController::class, 'update'])->name('employee.update')->middleware('permission:Edit');
        Route::get('delete/{id?}', [EmployeeController::class, 'delete'])->name('employee.delete')->middleware('permission:Delete');
        Route::post('delete/selected', [EmployeeController::class, 'deleteEmployeeSelected'])->name('employee.delete.selected')->middleware('permission:Delete');
    });
});
