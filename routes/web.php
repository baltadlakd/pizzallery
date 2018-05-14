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

if (env('APP_ENV') === 'local') {
    \URL::forceScheme('https');
}

Route::get('/', function () {
    return view('pizzas.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');
Route::get('/admin','HomeController@admin')->name('admin')->middleware('auth','role:admin');

//=== Redes sociales

Route::get('login/{provider}/redirect', 'SocialController@redirect')->name('redirect');
Route::get('login/{provider}/callback', 'SocialController@callback')->name('callback');

Route::delete('social/{provider}','SocialController@destroy')->name('socialDestroy')->middleware('auth');

//===Usuarios

Route::post('usuario/panel','UserController@panel')->name('userPanel')->middleware('auth');
Route::get('usuario/panel','UserController@panel')->name('userPanel')->middleware('auth');

Route::post('usuario/panel/editc/{user}','UserController@createPassword')->name('createPassword')->middleware('auth');
Route::post('usuario/panel/editp/{user}','UserController@updatePassword')->name('updatePassword')->middleware('auth');
Route::post('usuario/panel/editn/{user}','UserController@editName')->name('editName')->middleware('auth');

Route::get('usuario/all','UserController@all')->name('userAll')->middleware('auth');
Route::get('usuario/{user}','UserController@show')->name('userShow')->middleware('auth');

Route::patch('usuario/{user}','UserController@update')->name('userUpdate')->middleware('auth');

Route::delete('usuario/{user}','UserController@destroy')->name('deleteUser')->middleware('auth');
//========Tarjetas

Route::resource('tarjetas', 'TarjetaController')->except([
    'create', 'show'
]);
//====  $pizzas

Route::get('pizza','PizzaController@index')->name('pizzaIndex');
Route::get('pizza/{pizza}','PizzaController@show')->name('pizzaShow')->middleware('auth');

//====  $hamburguesas

Route::get('hamburguesa','HamburgerController@index')->name('hamburgerIndex');
Route::get('hamburguesa/{hamburger}','HamburgerController@show')->name('hamburgerShow')->middleware('auth');

//==== comments

Route::get('comentarios/{type}/{id}','CommentController@index')->middleware('auth');
Route::post('comentarios/{type}/{id}','CommentController@store')->middleware('auth');

//==== ingredientes
Route::get('ingredientes/{type}/{id}','TagController@index')->middleware('auth');
Route::post('ingredientes/{type}/{id}','TagController@store')->middleware('auth');
