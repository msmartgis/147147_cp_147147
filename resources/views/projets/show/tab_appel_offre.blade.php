<div class="tab-pane " id="appels_offre_tab_panel" role="tabpanel">
    <div class="pad">
        @if($is_mobile == 1)
            <h4 style="text-align: center;text-decoration: underline">APPELS D'OFFRE</h4>
        @endif
        @include('projets.show.filters_projet_appel_offre')
        <div class="table-responsive">
            <table class="table table-hover table-striped datatables" id="projet_appel_offre_datatables" style="width:100% ;" >
                <thead>
                <th >N°</th>
                <th >A.O</th>
                <th >Liaison</th>
                <th >Communes</th>
                <th >Longueur(KM)</th>
                <th >Intervention</th>
                <th >MOA</th>
                <th >Partenaire</th>
                <th >Programme</th>
                <th >M.Global</th>
                <th >Année</th>
                </thead>
            </table>
        </div>
    </div>
</div>