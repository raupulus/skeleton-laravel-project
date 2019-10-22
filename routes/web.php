<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

## Rutas para contactar.
Route::get('/contact', 'ContactController@view')->name('contact');
Route::post('/contact/send', 'ContactController@send')->name('contact-send');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/privacity', function () {
    return view('privacity');
})->name('privacity');

Route::get('/cookies', function () {
    return view('cookies');
})->name('cookies');

/******************************************
 *           Rutas de errores
 ******************************************/
Route::group(['prefix' => 'error'], function() {
    Route::get('/404', function() {
        return view('errors.404');
    })->name('error-404');

    Route::get('/500', function() {
        return view('errors.500');
    })->name('error-500');
});

/******************************************
 *            PANEL DE GESTIÓN
 ******************************************/
Route::group([
    'prefix' => 'datatable',
    'middleware' => [

    ]
], function() {

    Route::get('/translation', function() {
        return response()->file(base_path('public/json/datatable/datatable-translation-es.json'));
    })->name('datatable.translation');
});

/******************************************
 *            PANEL DE GESTIÓN
 ******************************************/
Route::group([
    'prefix' => 'panel',
    'middleware' => [
        'auth'
    ]
], function() {
    Route::get('/', function() {
        return view('panel.index');
    })->name('panel.index');

    Route::get('/login', function() {
        return view('panel.login');
    })->name('panel.login');

    Route::get('/forgot-password', function() {
        return view('panel.forgot-password');
    })->name('panel.forgot.password');

    Route::get('/register', function() {
        return view('panel.register');
    })->name('panel.register');

    ## Usuarios
    Route::group([
        'prefix' => 'user',
        'middleware' => [

        ]
    ], function() {
        ## Ver un usuario concreto.
        Route::get('/view/{id}/{nick?}', 'Panel\UserController@view')->name('panel.users.view');

        ## Ver todos los usuarios.
        Route::get('/index', 'Panel\UserController@index')->name('panel.users.index');

        ## Añadir o editar un nuevo usuario.
        Route::get('/add/{user_id?}', 'Panel\UserController@add')->name('panel.users.add');
        Route::post('/add/{user_id?}', 'Panel\UserController@edit')->name('panel.users.edit');

        /**
         * Datatables
         */
        Route::get('/table-all-users', 'Panel\UserController@getTableAllUser')
            ->name('panel.users.table.allusers');
        Route::get('/table-thismonth-users', 'Panel\UserController@getTableThisMontUsers')
            ->name('panel.users.table.thismonth');
        Route::get('/table-inactive-users', 'Panel\UserController@getTableInactiveUsers')
            ->name('panel.users.table.inactive');
        Route::get('/table-blocked-users', 'Panel\UserController@getTableBlockedUsers')
            ->name('panel.users.table.blocked');
    });

    ## Errores
    Route::get('/404', function() {
        return view('panel.errors.404');
    })->name('panel.404');

    Route::get('/500', function() {
        return view('panel.errors.500');
    })->name('panel.500');

    Route::get('/blank', function() {
        return view('panel.blank');
    })->name('panel.blank');

    ## DEMOS
    Route::group(['prefix' => 'demos'], function() {
        Route::get('/charts', function () {
            return view('panel.demos.charts');
        })->name('panel.demo.charts');

        Route::get('/tables', function () {
            return view('panel.demos.tables');
        })->name('panel.demo.tables');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
