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
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//index
Route::get('/', 'PagesController@index');
Route::group(
        ['middleware' => 'auth'],
        function () {
                Route::resources([
                        'convention' => 'ConventionController',
                        'projet' => 'ProjetController',
                        'pointDesservi' => 'PointDesserviController',
                        'pDesserviCateg' => 'PointDesserviCategorieController',
                        'commune' => 'CommunesController',
                        'demande' => 'DemandesController',
                        'piece' => 'PieceController',
                        'cartographie' => 'CartographieController',
                        'suivi_versement' => 'SuiviVersementController',
                        'appelOffre' => 'AppelOffreController'
                ]);

                Route::get('/demande/create', 'DemandesController@create')->name('createDemande');
                Route::get('/demande', 'DemandesController@index')->name('indexDemande');

                Route::get('/projet', 'ProjetController@index')->name('indexProjet');

                Route::get('/convention', 'ConventionController@index')->name('indexConvention');
                Route::get('/suiviVersement', 'SuiviVersementController@index')->name('indexSuiviVersement');

                Route::get('/appelOffre', 'AppelOffreController@index')->name('indexAppelOffre');

                //demandes
                Route::get('/demandes/getDemandeData', 'DemandesController@getDemandeData');
                Route::get('/demandes/en_cours', 'DemandesController@getDemandes');
                Route::get('/demandes/tab_a_traiter', 'DemandesController@getDemandesATraiter');
                Route::get('/demandes/tab_accord_definitif', 'DemandesController@getDemandesAccordDefinitif')->name('get.demandes.accord_definitif');
                Route::get('/demandes/tab_is_affecter', 'DemandesController@getDemandesAffectees')->name('get.demandes.affectees');
                Route::get('/demandes/tab_programmee', 'DemandesController@getDemandesProgrammee')->name('get.demandes.programmee');
                Route::get('/demandes/tab_realisee', 'DemandesController@getDemandesRealisee');


                //conventions
                Route::get('/conventions/show', 'ConventionController@getConventions');
                Route::get('/convention/create', 'ConventionController@create')->name('createConvention');

                //appel offre
                Route::get('/conventions/showCoventionsAppelOffre', 'ConventionController@getConventionsAppelOffre')->name('appelOffre.showCoventions');
                Route::get('/conventions/showAppelOffreEdit', 'ConventionController@showAppelOffreEdit')->name('appelOffre.showCoventionsEdit');
                Route::get('/conventions/showAppelOffre', 'ConventionController@getAppelOffre')->name('appelOffre.show');
                //suivi des versment
                Route::get('/conventions/showVersement', 'ConventionController@getVersements')->name('versement.show');
                Route::get('/convention/{convention}/editVersement', 'ConventionController@editVersement');
                Route::get('/convention/{id}/fiche', 'ConventionController@fiche')->name('convention.fiche');

                Route::post('/versement/getVersementData', 'SuiviVersementController@getVersementData')->name('versement.getData');
                Route::post('/versement/addVersement', 'SuiviVersementController@addVersement')->name('versement.add');
                Route::get('/versement/downloadFile', 'SuiviVersementController@downloadFile')->name('versement.download');



                //SPREADSHEET
                Route::post('/demandes/demandeSpreadSheetEnCours', 'SpreadSheetController@demandeSpread_en_cours')->name('spread_demande_en_cours');
                Route::post('/demandes/demandeSpreadSheetATraiter', 'SpreadSheetController@demandeSpread_a_traiter')->name('spread_demande_a_traiter');
                Route::post('/demandes/demandeSpreadSheetAccordDefinitif', 'SpreadSheetController@demandeSpread_accord_definitif')->name('spread_demande_accord_definitif');
                Route::post('/demandes/demandeSpreadSheetAffecter', 'SpreadSheetController@demandeSpread_affecter')->name('spread_demande_affecter');
                Route::post('/demandes/demandeSpreadSheetPogrammee', 'SpreadSheetController@demandeSpread_programmee')->name('spread_demande_programmee');
                Route::post('/demandes/demandeSpreadSheetRealisee', 'SpreadSheetController@demandeSpread_realisee')->name('spread_demande_realisee');
                Route::post('/conventions/conventionSpreadSheet', 'SpreadSheetController@conventionSpread')->name('spread_convention');

                Route::post('/demandes/affecter_or_accord', 'DemandesController@accordOrAffectation')->name('affecterOrAccord');
                Route::post('/demandes/a_traiter', 'DemandesController@aTraiter')->name('a_traiter');
                Route::post('/demandes/restaurer', 'DemandesController@restaurerDemande')->name('restaurer_demande');
                Route::post('/demandes/restaurer_from_affectation', 'DemandesController@restaurerDemandeFromAffectation')->name('restaurer_demande_from_affectation');


                //Routes for conventions
                Route::get('/conventions', 'ConventionController@index');
                Route::post('/conventions/conventionSpreadSheet', 'SpreadSheetController@conventionsSpreadSheet')->name('spreadSheetConvention');


                //routes for projets
                Route::post('/conventions/projetsSpreadSheet', 'SpreadSheetController@projetsSpreadSheet')->name('spreadSheetProjet');


                //pieces
                Route::post('/pieces/add_piece', 'PieceController@addPiece')->name('add_piece');
                Route::post('/pieces/delete_piece', 'PieceController@deletePiece')->name('delete_piece');
                Route::post('/partenaire/delete_partenaire', 'PartenaireTypeController@deletePartenaire')->name('delete_partenaire');
                Route::post('/partenaire/delete_partenaire_covention', 'PartenaireTypeController@deletePartenaireConvention')->name('delete_partenaire_convention');
                Route::post('/partenaire/add_partenaire', 'PartenaireTypeController@addPartenaire')->name('add_partenaire');

                Route::post('/pieces/add_piece_dossier_adjiducataire', 'DossierAdjiducataireController@addPiece')->name('dossier_adjiducataire.add_piece');
                Route::post('/pieces/delete_piece_dossier_adjiducataire', 'DossierAdjiducataireController@deletePiece')->name('dossier_adjiducataire.delete_piece');
                //files
                Route::get('/files/download/{directory}/{id}/{file_name}', 'FilesController@fileDownload')->name('files.download');
                //point desservis
                Route::post('/pointDesservi/loadPoint', 'PointDesserviController@loadPoint');
        }
);








//projets routes
//edit route test
/* TODO this route is just for making interface design */

Route::get('/edit_project', 'ProjetController@edit_projet')->name('edit_projet');
