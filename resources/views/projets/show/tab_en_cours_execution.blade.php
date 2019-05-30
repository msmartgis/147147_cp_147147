<div class="tab-pane " id="en_cours_tab_panel" role="tabpanel">
    <div class="pad">
        @include('projets.show.filters_projet_en_cours_execution')
        <div class="table-responsive">
            <table class="table table-hover table-striped datatables" id="projet_en_cours_datatables" style="width:100% ;" >
                <thead>
                <th >N°</th>
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