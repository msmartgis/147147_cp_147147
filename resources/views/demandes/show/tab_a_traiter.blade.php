<div class="tab-pane " id="a_traiter_tab" role="tabpanel">
    <div class="pad">
        @include('demandes.filter_demandes_a_traiter')


        <div class="table-responsive">
            <table class="table table-hover table-striped datatables" id="demandes_datatables_a_traiter" style="width:100% ;" >
                <thead>
                <th style="width: 1% !important"></th>
                <th style="width: 1% !important">N°ordre</th>
                <th style="width: 1% !important">D.Réception</th>
                <th >Objet</th>
                <th>Communes</th>
                <th>porteur</th>
                <th>Interventions</th>
                <th>Partenaire</th>
                <th style="width: 1% !important">M.Totol</th>
                <th style="width: 1% !important">M.CP</th>
                </thead>
            </table>
        </div>
        {{--<div class="row" style="margin-top : 8px">
            <div class="dropdown" style="margin-left : 8px">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Décision</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item " href="#">
                        <div id="modifier"><i class="fa fa-edit"></i> Modifier</div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <div id="accord_definitif"><i class="fa fa-thumbs-up"></i> Accord défintif</div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <div id="a_traiter"><i class="fa fa-clock-o"></i> A traiter</div>
                    </a>
                </div>
            </div>

            <button type="button" id="affecter_aux_cnv" class="btn btn-secondary" style="margin-left : 8px;visibility : hidden">Affecter
                aux conventions</button>
        </div>--}}

    </div>
</div>
