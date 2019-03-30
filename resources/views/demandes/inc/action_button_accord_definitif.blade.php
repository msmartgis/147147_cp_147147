

<div class="row" style="margin-top: 4px">

    <div class="col-lg-6">
        {{-- <button class="btn btn-secondary dropdown-toggle pull-left" type="button" data-toggle="dropdown" style="margin-right: 6px"><i class="fa fa-calendar" style="margin-right : 6px"></i>Session</button>
         <div class="dropdown-menu">
             @foreach ($sessions as $session)
                 <a class="dropdown-item " href="#">
                     <div ><i class="fa fa-calendar"></i> {{$session->date}}</div>
                 </a>
             @endforeach
         </div>--}}

        <button type="button" class="btn btn-secondary pull-left" id="affecter_aux_cnv" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;"><i class="fa fa-print" style="margin-right: 6px "></i>Affecter aux convention</button>
        <button type="button" class="btn btn-secondary pull-left" id="restaurer_accord_definitif" style="margin-right : 6px"><i class="fa fa-arrow-circle-left" style="margin-right: 6px"></i>Restaurer </button>

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