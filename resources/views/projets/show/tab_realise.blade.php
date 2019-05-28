div class="tab-pane " id="en_cours_tab" role="tabpanel">
<div class="pad">
    @include('projets.show.tab_realise')
    <div class="table-responsive">
        <table class="table table-hover table-striped datatables" id="projet_realise_datatables" style="width:100% ;" >
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