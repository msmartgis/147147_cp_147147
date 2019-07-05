@if($is_mobile == 0)
    <div class="row" style="margin-top: 4px">
        <div class="col-lg-6 col-xl-6 col-md-6 col-12">
            <button class="btn btn-secondary dropdown-toggle pull-left multiple-choice-en-cours" type="button" data-toggle="dropdown" style="margin-right: 6px" disabled><i class="fa fa-calendar" style="margin-right : 6px"></i>Session</button>
            <div class="dropdown-menu">
                @foreach ($sessions as $session)
                    <a class="dropdown-item " href="#">
                        <div ><i class="fa fa-calendar"></i> {{$session->date}}</div>
                    </a>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary pull-left multiple-choice-en-cours" id="a_traiter_btn" style="margin-right : 6px" disabled><i class="fa fa-clock-o" style="margin-right: 6px"></i>A traiter </button>
            <button type="button" class="btn btn-secondary pull-left unique-choice-en-cours" id="accord_definitif_btn" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;" disabled><i class="fa fa-thumbs-o-up" style="margin-right: 6px "></i>Accord definitif</button>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-12">
            <button class="btn btn-secondary dropdown-toggle pull-right" type="button" data-toggle="dropdown" style="background-color: #e83431 !important;border-color: #e83431 !important;" > <i class="fa fa-clock-o" style="margin-right : 6px"></i> Exporter</button>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="#">
                    <div ><i class="fa fa-edit"></i> PDF</div>
                </a>
                <a class="dropdown-item" href="#">
                    <div ><i class="fa fa-thumbs-up"></i> Excel </div>
                </a>
            </div>
            <a href="#" class="btn btn-secondary pull-right" style="margin-right:4px;background-color: #ff8740;border-color: #ff8740;"><i class="fa fa-file" style="margin-right: 6px"></i>Fiche de demande</a>

            <a href="{{ route('createDemande') }}" class="btn btn-secondary pull-right" style="margin-right:4px"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
                une demande</a>
        </div>
    </div>
@else

        <div class="col-12" style="margin-top: 4px">
            <button class="btn btn-secondary dropdown-toggle pull-left multiple-choice-en-cours" type="button" data-toggle="dropdown" style="margin-right: 6px" disabled><i class="fa fa-calendar" style="margin-right : 6px"></i>Session</button>
            <div class="dropdown-menu">
                @foreach ($sessions as $session)
                    <a class="dropdown-item " href="#">
                        <div ><i class="fa fa-calendar"></i> {{$session->date}}</div>
                    </a>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary pull-left multiple-choice-en-cours" id="a_traiter_btn" style="margin-right : 6px" disabled><i class="fa fa-clock-o" style="margin-right: 6px"></i>A traiter </button>
            <button type="button" class="btn btn-secondary pull-left unique-choice-en-cours" id="accord_definitif_btn" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;" disabled><i class="fa fa-thumbs-o-up" style="margin-right: 6px "></i>Accord definitif</button>
        </div>

        <br>
        <div class="col-12" style="margin-top: 15px">
            <button class="btn btn-secondary dropdown-toggle " type="button" data-toggle="dropdown" style="background-color: #e83431 !important;border-color: #e83431 !important;" > <i class="fa fa-clock-o" style="margin-right : 6px"></i> Exporter</button>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="#">
                    <div ><i class="fa fa-edit"></i> PDF</div>
                </a>
                <a class="dropdown-item" href="#">
                    <div ><i class="fa fa-thumbs-up"></i> Excel </div>
                </a>
            </div>
            <a href="#" class="btn btn-secondary " style="margin-right:4px;background-color: #ff8740;border-color: #ff8740;"><i class="fa fa-file" style="margin-right: 6px"></i>Fiche de demande</a>
        </div>
@endif

