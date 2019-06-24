
<!--SIDEBAR--->
<div id="sidebar" style="padding: 0">
    <div class="col-lg-12" style="text-align: center">
        <button type="button" class="btn btn-success-table" id="search_carto_modal_show" data-toggle="modal" data-target="#search_carto_modal"  style="font-size: 16px;font-weight: 600;margin-top: 0"><i class="fa fa-search" style="margin-left: 8px"></i>
            Rechercher</button>
    </div>
    <div class="drawer-heading" style="padding: 0px 15px !important;">
        <h3 class="drawer-title" ><img src="{{asset('svg/data_filter.svg')}}" style="width : 30px;height: 30px;margin-right: 6px;    margin-bottom: 8px;">Filtres</h3>
    </div>
    <div class="drawer-body">
        <div class="row" style="margin-left: 12px;">
            <div class="col-lg-12">
                <label >Données :</label>
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="donnees" id="donnees_filter">
                        <option value="all" selected>Indifferent</option>
                        <option value="demande" >Demandes</option>
                        <option value="projet" >Projets</option>

                    </select>
                </div>
            </div>
        </div>


        <div class="row" style="margin-left: 12px;">
            <div class="col-lg-12">
                <label >Etat :</label>
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="etat" id="etat_filter">
                        <option value="all" selected>Indifferent</option>
                        <option value="programme">Programmé</option>
                        <option value="en_cours_execution">En cours d'execution</option>
                        <option value="a.o_pulie">A.O Publié</option>
                        <option value="plis_ouvert">Plis ouvert</option>
                        <option value="a.o_attribue">A.O Attribué</option>
                        <option value="a.o_reporte">A.O Reporté</option>
                        <option value="a.o_annule">A.O Annule</option>
                        <option value="en_retard">En retard</option>
                        <option value="en_etat_arret">En état d\'arrêt</option>
                        <option value="realise">Réalisé</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row" style="margin-left: 12px;">
            <div class="col-lg-12">
                <label >Programme :</label>
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="programme" id="programme_filter">
                        <option value="all" selected>Indifferent</option>
                        @foreach($programmes as $programme)
                            <option value="{{$programme->id}}">{{$programme->nom_fr}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="row" style="margin-left: 12px;">
            <div class="col-lg-12">
                <label >Intervention :</label>
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="intervention" id="intervention_filter">
                        <option value="all" selected>Indifferent</option>
                        @foreach($interventions as $intervention)
                            <option value="{{$intervention->id}}">{{$intervention->nom}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row" style="margin-left: 12px;">
            <div class="col-lg-12">
                <label >M.O :</label>
                <div class="form-group">
                    <select class="form-control select2" style="width: 100%;" name="moa" id="moa_filter">
                        <option value="all" selected>Indifferent</option>
                        @foreach($moas as $moa)
                            <option value="{{$moa->id}}">{{$moa->nom_fr}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="drawer-heading" style="padding: 5px 0px;">
            <h3 class="drawer-title"><img src="{{asset('svg/layers.svg')}}" style="width : 27px;height: 27px;margin-right: 6px;    margin-bottom: 8px;">Couches</h3>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Localités</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="localite_cbx" checked  />
                <label for="localite_cbx" class="label-cbx">Localités</label>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Pistes</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="pistes_cbx" checked />
                <label for="pistes_cbx" class="label-cbx">Pistes</label>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Réseau routier</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="rt_national_cbx" checked/>
                <label for="rt_national_cbx" class="label-cbx">Routes Nationales</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="rt_regional_cbx" checked/>
                <label for="rt_regional_cbx" class="label-cbx">Routes Régionales</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="rt_provincial_cbx" checked/>
                <label for="rt_provincial_cbx" class="label-cbx">Routes Provinciales</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="localite_cbx" checked/>
                <label for="rt_non_classes_cbx" class="label-cbx">Routes non classées</label>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Santé</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="e_sante_cbx" checked />
                <label for="e_sante_cbx" class="label-cbx">Etablisssement de santé</label>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Education</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="e_scolaire_cbx" checked />
                <label for="e_scolaire_cbx" class="label-cbx">Etablisssement scolaire</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="e_scolaire_cbx"  checked/>
                <label for="e_scolaire_cbx" class="label-cbx">Ecoles traditionnelles</label>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h5 class="couche-title">Autres données</h5>
                <input type="checkbox" class="couches_checkbox filled-in" id="oued_cbx" checked />
                <label for="oued_cbx" class="label-cbx">Oued</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="r_eau_cbx" checked />
                <label for="r_eau_cbx" class="label-cbx">Retenus d'eau / Barrage</label>
            </div>
            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="s_touristiques_cbx"  checked/>
                <label for="s_touristiques_cbx" class="label-cbx">Sites touristiques</label>
            </div>

            <div class="col-lg-12">
                <input type="checkbox" class="couches_checkbox filled-in" id="communes_cbx"  checked/>
                <label for="communes_cbx" class="label-cbx">Communes</label>
            </div>
        </div>
    </div>

</div>


