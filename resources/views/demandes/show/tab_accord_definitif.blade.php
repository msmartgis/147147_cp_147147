<div class="tab-pane pad" id="accord_definitif_tab" role="tabpanel">
    @include('demandes.filter_demandes_accord_definitif')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 ">
            <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouters
                une demande</a>
            <a href="" class="btn btn-secondary pull-right" style="margin-right : 6px"><i class="fa fa-print" style="margin-right: 6px"></i>Imprimer
                la fiche</a>
        </div>
    </div>
    <div class="row" style="margin-top : 12px">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-pdf-o" style="margin-right: 6px"></i>PDF</a>
            <a href="" class="btn btn-success pull-right" style="margin-right : 6px"><i class="fa fa-file-excel-o"
                    style="margin-right: 6px"></i>CSV</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped datatables" id="demandes_datatables_accord_definitif" style="width:100%">
            <thead>
                <th>#</th>
                <th>N°ordre</th>
                <th>D.Réception</th>
                <th>Objet</th>
                <th>Communes</th>
                <th>porteur</th>
                <th>Interventions</th>
                <th>Partenaire</th>
                <th>M.Totol</th>
                <th>M.CP</th>
                <th>Session</th>
            </thead>
        </table>
    </div>
    <div class="row" style="margin-top : 8px">
        <div class="dropdown" style="margin-left : 8px">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">Décision</button>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="#">
                    <div id="modifier_accord_definitif"><i class="fa fa-edit"></i> Modifier</div>
                </a>
                <a class="dropdown-item" href="#">
                    <div id="restaurer_accord_definitif"><i class="fa fa-clock-o"></i>Restaurer</div>
                </a>
            </div>
        </div>
    </div>

</div>
