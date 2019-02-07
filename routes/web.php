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
Route::resource('pieces', 'PieceController');
Route::resource('points_desservis', 'PointDesserviController');
Route::resource('communes', 'CommunesController');
Route::post('/loadPoint', 'PointDesserviController@loadPoint');
Route::get('demande', 'DemandesController@getDemandes')->name('get.demandes');
Route::get('demande/is_affecter', 'DemandesController@getDemandesAffectees')->name('get.demandes.affectees');
Route::post('demandes/affecter_cnv', 'DemandesController@affecterAuxConventions')->name('affecter_cnv');
Route::post('demandes/accord_definitif', 'DemandesController@accordDefinitif')->name('accord_definitif');
Route::post('demandes/a_traiter', 'DemandesController@aTraiter')->name('a_traiter');
Route::post('demandes/restaurer', 'DemandesController@restaurerDemande')->name('restaurer_demande');
Route::post('pieces/add_piece', 'PieceController@addPiece')->name('add_piece');
Route::post('pieces/delete_piece', 'PieceController@deletePiece')->name('delete_piece');
Route::post('partenaire/delete_partenaire', 'PartenaireTypeController@deletePartenaire')->name('delete_partenaire');
Route::post('partenaire/add_partenaire', 'PartenaireTypeController@addPartenaire')->name('add_partenaire');

//Route::post('/load_points_desservis', 'LoadPointsDesservis@load_points_desservis')->name('load_point');
//Route::get('load_points', 'LoadPointsDesservis@load_points_desservis');
//Route::post('/load_localites', 'PointDesserviController@load_localites');

