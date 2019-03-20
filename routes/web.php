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
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::resources([
            'conventions' => 'ConventionController',
            'projets' => 'ProjetController',
            'points_desservis' => 'PointDesserviController',
            'communes' => 'CommunesController',
            'demandes' => 'DemandesController',
            'pieces' => 'PieceController',
            'cartographie' => 'CartographieController',
            'suivi_versement' => 'SuiviVersementController'
        ]);

        Route::get('/demande/create','DemandesController@create')->name('createDemande');

        Route::get('/demande','DemandesController@index')->name('indexDemande');


        Route::get('/projet','ProjetController@index')->name('indexProjet');

        Route::get('/convention','ConventionController@index')->name('indexConvention');

        Route::get('/suivi_versement','SuiviVersementController@index')->name('indexSuiviVersement');


        Route::post('/loadPoint', 'PointDesserviController@loadPoint');

//demandes
        Route::get('/demande/en_cours', 'DemandesController@getDemandes');
        Route::get('/demande/tab_programmee', 'DemandesController@getDemandesProgrammee');
        Route::get('/demande/tab_realisee', 'DemandesController@getDemandesRealisee');
        Route::get('/demande/tab_a_traiter', 'DemandesController@getDemandesATraiter');
        Route::post('/demande/demandeSpreadSheetEnCours', 'SpreadSheetController@demandeSpread_en_cours')->name('spread_demande_en_cours');
        Route::get('/demande/is_affecter', 'DemandesController@getDemandesAffectees')->name('get.demandes.affectees');
        Route::get('/demande/tab_accord_definitif', 'DemandesController@getDemandesAccordDefinitif')->name('get.demandes.accord_definitif');
        Route::post('/demandes/affecter_cnv', 'DemandesController@affecterAuxConventions')->name('affecter_cnv');
        Route::post('/demandes/accord_definitif', 'DemandesController@accordDefinitif')->name('accord_definitif');
        Route::post('/demandes/a_traiter', 'DemandesController@aTraiter')->name('a_traiter');
        Route::post('/demande/restaurer', 'DemandesController@restaurerDemande')->name('restaurer_demande');
        Route::post('/demande/restaurer_from_affectation', 'DemandesController@restaurerDemandeFromAffectation')->name('restaurer_demande_from_affectation');




//Routes for conventions
        Route::get('/conventions', 'ConventionController@index');
        Route::post('/conventions/conventionSpreadSheet', 'SpreadSheetController@conventionsSpreadSheet')->name('spreadSheetConvention');


//routes for projets
        Route::post('/conventions/projetsSpreadSheet', 'SpreadSheetController@projetsSpreadSheet')->name('spreadSheetProjet');


//pieces
        Route::post('/pieces/add_piece', 'PieceController@addPiece')->name('add_piece');
        Route::post('/pieces/delete_piece', 'PieceController@deletePiece')->name('delete_piece');
        Route::post('/partenaire/delete_partenaire', 'PartenaireTypeController@deletePartenaire')->name('delete_partenaire');
        Route::post('/partenaire/add_partenaire', 'PartenaireTypeController@addPartenaire')->name('add_partenaire');
    }
);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//projets routes
//edit route test
/* TODO this route is just for making interface design */

Route::get('/edit_project','ProjetController@edit_projet')->name('edit_projet');

