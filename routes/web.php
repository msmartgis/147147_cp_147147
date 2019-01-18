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

 //index
Route::get('/', 'PagesController@index');



//resources for demande controller
Route::resource('demandes', 'DemandesController');
Route::resource('points_desservis', 'PointDesserviController');
Route::resource('communes', 'CommunesController');
Route::post('/loadPoint', 'PointDesserviController@loadPoint');
Route::get('demande', 'DemandesController@getDemandes')->name('get.demandes');

//Route::post('/load_points_desservis', 'LoadPointsDesservis@load_points_desservis')->name('load_point');
//Route::get('load_points', 'LoadPointsDesservis@load_points_desservis');
//Route::post('/load_localites', 'PointDesserviController@load_localites');

