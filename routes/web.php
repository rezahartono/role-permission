<?php

use App\Http\Controllers\AuthenticationController;
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

Route::prefix('login')->group(function () {
    Route::get('/', 'AuthenticationController@login')->name('login');
    Route::post('/', 'AuthenticationController@doLogin');
});
Route::get('logout', 'AuthenticationController@doLogout')->name('logout');


Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', 'General\DashboardController@index')->name('dashboard');
    });
    Route::prefix('master-data')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', 'MasterData\UsersController@index')->name('master_data.users');
            Route::get('create', 'MasterData\UsersController@store')->name('master_data.users.create');
            Route::get('edit/{id}', 'MasterData\UsersController@edit')->name('master_data.users.edit');
            Route::post('create', 'MasterData\UsersController@create')->name('master_data.users.create');
            Route::post('edit/{id}', 'MasterData\UsersController@update')->name('master_data.users.update');
            Route::get('delete/{id}', 'MasterData\UsersController@delete')->name('master_data.users.delete');
        });
        Route::prefix('groups')->group(function () {
            Route::get('/', 'MasterData\GroupsController@index')->name('master_data.groups');
            Route::get('create', 'MasterData\GroupsController@store')->name('master_data.groups.create');
            Route::get('edit/{id}', 'MasterData\GroupsController@edit')->name('master_data.groups.edit');
            Route::post('create', 'MasterData\GroupsController@create');
            Route::post('edit/{id}', 'MasterData\GroupsController@update')->name('master_data.groups.update');
            Route::get('delete/{id}', 'MasterData\GroupsController@delete');
        });
    });

    Route::prefix('settings')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::get('/', 'Settings\RoleController@index')->name('settings.roles');
            Route::get('create', 'Settings\RoleController@store')->name('settings.roles.create');
            Route::get('edit/{id}', 'Settings\RoleController@edit')->name('settings.roles.edit');
            Route::post('create', 'Settings\RoleController@create')->name('settings.roles.delete');
            Route::post('edit/{id}', 'Settings\RoleController@update')->name('settings.roles.update');
            Route::get('delete/{id}', 'Settings\RoleController@delete')->name('settings.roles.delete');
        });
        Route::prefix('menu-list')->group(function () {
            Route::get('/', 'Settings\MenuListController@index')->name('settings.menu_list');
            Route::get('create', 'Settings\MenuListController@store')->name('settings.menu_list.create');
            Route::get('edit/{id}', 'Settings\MenuListController@edit')->name('settings.menu_list.edit');
            Route::post('create', 'Settings\MenuListController@create')->name('settings.menu_list.create');
            Route::post('edit/{id}', 'Settings\MenuListController@update')->name('settings.menu_list.update');
            Route::get('delete/{id}', 'Settings\MenuListController@delete');
        });
        Route::prefix('access-list')->group(function () {
            Route::get('/', 'Settings\AccessListController@index')->name('settings.access_list');
            Route::get('create', 'Settings\AccessListController@store')->name('settings.access_list.create');
            Route::get('edit/{id}', 'Settings\AccessListController@edit')->name('settings.access_list.edit');
            Route::post('create', 'Settings\AccessListController@create')->name('settings.access_list.create');
            Route::post('edit/{id}', 'Settings\AccessListController@update')->name('settings.access_list.update');
            Route::get('delete/{id}', 'Settings\AccessListController@delete');
        });
    });

    Route::prefix('lookup-data')->group(function () {
        Route::get('menu-list', 'LookupDatatableRenderer@menuList')->name('lookup.menu_list');
    });
});
