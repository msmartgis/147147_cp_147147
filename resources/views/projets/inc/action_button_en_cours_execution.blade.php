

<div class="row" style="margin-top: 4px">
    {{--<div class="col-lg-3" >
        <a href="/demandes/create" class="btn btn-secondary pull-right"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
            une demande</a>
        <a href="" class="btn btn-secondary pull-right" style="margin-right : 6px"><i class="fa fa-print" style="margin-right: 6px"></i>Imprimer
            la fiche</a>
    </div>

    <div class="col-lg-3" >
        <a href="" class="btn btn-success pull-right" ><i class="fa fa-file-pdf-o" style="margin-right: 6px;"></i>Exporter PDF</a>
        <button type="submit" class="btn btn-success pull-right" style="margin-right: 6px;" ><i class="fa fa-file-excel-o" style="margin-right: 6px;"></i>Exporter CSV</button>
    </div>--}}




    <div class="col-lg-6">

        <button class="btn btn-secondary dropdown-toggle pull-left" type="button" data-toggle="dropdown" style="margin-right: 6px"><i class="fa fa-clock-o" style="margin-right : 6px"></i>Session</button>
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

        <a href="" class="btn btn-secondary pull-left" style="margin-right : 6px"><i class="fa fa-print" style="margin-right: 6px"></i>A traiter </a>

        <a href="" class="btn btn-secondary pull-left" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;"><i class="fa fa-print" style="margin-right: 6px "></i>Accord definitif</a>

        <a href="" class="btn btn-secondary pull-left" style="margin-right : 6px ;background-color: #F27C3C !important;border-color: #F27C3C !important;"><i class="fa fa-print" style="margin-right: 6px"></i>Affecter aux conventions</a>

    </div>


    <div class="col-lg-6">

        <button class="btn btn-secondary dropdown-toggle pull-right" type="button" data-toggle="dropdown" style="background-color: #e83431 !important;border-color: #e83431 !important;" > <i class="fa fa-clock-o" style="margin-right : 6px"></i> Exporter</button>
        <div class="dropdown-menu">
            <a class="dropdown-item " href="#">
                <div id="modifier"><i class="fa fa-edit"></i> PDF</div>
            </a>
            <a class="dropdown-item" href="#">
                <div id="accord_definitif"><i class="fa fa-thumbs-up"></i> Excel </div>
            </a>
        </div>

        <a href="{{ route('createDemande') }}" class="btn btn-secondary pull-right" style="margin-right:4px"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
            une demande</a>

    </div>





</div>