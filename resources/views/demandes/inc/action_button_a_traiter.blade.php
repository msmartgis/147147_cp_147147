@if($is_mobile == 0)
    <div class="row" style="margin-top: 4px">
        <div class="col-lg-6">
            <button type="button" class="btn btn-secondary pull-left unique-choice-a-traiter" id="accord_definitif_btn_a_traiter" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;" disabled><i class="fa fa-thumbs-o-up" style="margin-right: 6px "></i>Accord definitif</button>
            <button type="button" class="btn btn-secondary pull-left multiple-choice-a-traiter" id="restaurer_a_traiter" style="margin-right : 6px" disabled><i class="fa fa-arrow-circle-left" style="margin-right: 6px"></i>Restaurer </button>
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
            <a href="#" class="btn btn-secondary pull-right" style="margin-right:4px;background-color: #ff8740;border-color: #ff8740;"><i class="fa fa-file" style="margin-right: 6px"></i>Fiche de demande</a>
        </div>
    </div>
@else

    <div class="col-12" style="margin-top: 4px;padding-left: 0;">
        <div class="col-lg-6">
            <button type="button" class="btn btn-secondary pull-left unique-choice-a-traiter" id="accord_definitif_btn_a_traiter" style="margin-right : 6px ;background-color: #F2922A !important;border-color: #F2922A !important;" disabled><i class="fa fa-thumbs-o-up" style="margin-right: 6px "></i>Accord definitif</button>
            <button type="button" class="btn btn-secondary pull-left multiple-choice-a-traiter" id="restaurer_a_traiter" style="margin-right : 6px" disabled><i class="fa fa-arrow-circle-left" style="margin-right: 6px"></i>Restaurer </button>
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
    </div>

@endif