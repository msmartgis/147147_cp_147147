
<div class="row" style="margin-top: 4px">
    <div class="col-lg-6">
        <button type="button" class="btn btn-secondary pull-left multiple-choice-affecte" id="restaurer_affecte_btn" style="margin-right : 6px" disabled><i class="fa fa-arrow-circle-left" style="margin-right: 6px"></i>Restaurer </button>
    </div>

    <div class="col-lg-6">
        <button class="btn btn-secondary dropdown-toggle pull-right" type="button" data-toggle="dropdown" style="background-color: #e83431 !important;border-color: #e83431 !important;" > <i class="fa fa-clock-o" style="margin-right : 6px"></i> Exporter</button>
        <div class="dropdown-menu">
            <a class="dropdown-item " href="#">
                <div ><i class="fa fa-edit"></i> PDF</div>
            </a>
            <a class="dropdown-item" href="#">
                <div ><i class="fa fa-thumbs-up"></i> Excel </div>
            </a>
        </div>

        <a href="{{ route('createDemande') }}" class="btn btn-secondary pull-right" style="margin-right:4px"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
            une demande</a>
    </div>
</div>