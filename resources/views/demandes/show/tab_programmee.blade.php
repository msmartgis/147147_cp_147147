<div class="tab-pane " id="programmee_tab" role="tabpanel">
    <div class="pad">
        @include('demandes.filter_demandes_programmee')
        <div class="table-responsive">
            <table class="table table-hover table-striped datatables" id="demandes_datatables_programmee" style="width:100%;" >
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
    </div>
</div>