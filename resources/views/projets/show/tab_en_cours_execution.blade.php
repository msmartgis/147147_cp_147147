<div class="tab-pane " id="en_cours_execution" role="tabpanel">
    <div class="pad">
        @include('projets.show.filters_projet_programmes')
        <div class="table-responsive">
            <table class="table table-hover table-striped datatables" id="projet_en_cours_datatables" style="width:100% ;" >
                <thead>
                <th ></th>
                <th >N°</th>
                <th >Liaison</th>
                <th >Communes</th>
                <th >Longueur(KM)</th>
                <th >MOA</th>
                <th >Partenaire</th>
                <th >Programme</th>
                <th >Etat</th>
                </thead>
            </table>
        </div>
    </div>
</div>