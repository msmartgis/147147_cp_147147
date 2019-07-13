@if($is_mobile == 0)
    <div class="row" style="margin-top: 4px">
        <div class="col-lg-6">
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
            <a href="#" class="btn btn-secondary pull-right" style="margin-right:4px;background-color: #ff8740;border-color: #ff8740;"><i class="fa fa-file" style="margin-right: 6px"></i>Fiche de convention</a>

            <a href="{{ route('createConvention') }}" class="btn btn-secondary pull-right" style="margin-right:4px"><i class="fa fa-plus" style="margin-right: 6px"></i>Ajouter
                une convention</a>
        </div>
    </div>
@else

    <div class="col-12" style="padding-left: 0;">
        <div class="col-12" >
            <button class="btn btn-secondary dropdown-toggle " type="button" data-toggle="dropdown" style="background-color: #e83431 !important;border-color: #e83431 !important;" > <i class="fa fa-clock-o" style="margin-right : 6px"></i> Exporter</button>
            <div class="dropdown-menu">
                <a class="dropdown-item " href="#">
                    <div ><i class="fa fa-edit"></i> PDF</div>
                </a>
                <a class="dropdown-item" href="#">
                    <div ><i class="fa fa-thumbs-up"></i> Excel </div>
                </a>
            </div>
            <a href="#" class="btn btn-secondary " style="margin-right:4px;background-color: #ff8740;border-color: #ff8740;"><i class="fa fa-file" style="margin-right: 6px"></i>Fiche de convention</a>

        </div>
    </div>
@endif

