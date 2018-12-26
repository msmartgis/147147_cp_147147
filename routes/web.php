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

//home page
Route::get('/', function () {
    return view('index');
})->name('home');


//projets
Route::get('projets', function () {
    return view('projets');
});

//demandes
Route::get('demandes', function () {
    return view('demandes.demandes');
})->name('demandes');

//conventions
Route::get('conventions', function () {
    return view('conventions');
});

//appels_offres
Route::get('appels_offres', function () {
    return view('appels_offres');
});

//suivi_versements
Route::get('suivi_versements', function () {
    return view('suivi_versements');
});


//statistiques
Route::get('statistiques', function () {
    return view('statistiques');
});

//cartographie
Route::get('cartographie', function () {
    return view('cartographie');
});

