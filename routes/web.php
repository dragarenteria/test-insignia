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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/libros', 'libroController@index');
Route::post('/libros/crear', 'libroController@setLibro');
Route::post('/libros/editar', 'libroController@putLibro');
Route::delete('/libros/eliminar/{id}', 'libroController@deleteLibro');
Route::get('/libros/getlibros', 'libroController@getLibros');
Route::post('/registro', 'UserController@registro');

// Route::get('/password/reset/{token}', 'UserController@getReset');
// Route::post('/password/reset', 'UserController@postReset');


Route::group(['middelware' => ['auth']], function(){

    // Route::get('/password', 'UserController@viewPass');
    // Route::post('/editpass', 'UserController@editPass');

    Route::get('/users', 'UserController@index');
    Route::get('/users/getusers', 'UserController@getUsers');

     Route::get('/prestar-libros', 'LibroUsuarioController@index');
     Route::post('/prestar-libros/setprestamo', 'LibroUsuarioController@setPrestamo');
     Route::get('/prestar-libros/getprestamo', 'LibroUsuarioController@getPrestamo');
     Route::get('/prestar-libros/datosSelect', 'LibroUsuarioController@datosSelect');
     Route::post('/prestar-libros/putprestamo', 'LibroUsuarioController@putPrestamo');

    
});