var projetsTable;
var projetsLGTable;
var projetsTableLongueur;
var checked_demande_en_cours = 0;
$(document).ready(function () {

    projetsTable = $('#projets_statistcs_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 30,
        bInfo : false,
        info : false,
        bPaginate: false,
        bLengthChange : false,
        searching: false,
        language: {
            processing: '<img src="/images/loader/Preloader_2.gif" class="loader-datatable">'
        },

        ajax: {
            url: '/projetsStatistics',
            type: 'GET',
            data: function (d) {
                d.interventions = $('select[name=intervention_projet]').val();
                d.annee = $('select[name=annee_projet]').val();
                d.moa = $('select[name=moa_projet]').val();
                d.programme = $('select[name=programme_projet]').val();
            }

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
                data: 'nom_fr',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true,
                width : '45%'
            },
            {
                data: 'programme',
                name: 'programme',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'appel_offre',
                name: 'appel_offre',
                orderable: true,
                searchable: true,
                width : '25%'
            },
            {
                data: 'en_cours',
                name: 'en_cours',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'realise',
                name: 'realise',
                orderable: true,
                searchable: true,
                width : '5%'
            },
            {
                data: 'total_row',
                name: 'total_row',
                orderable: true,
                searchable: true,
                width : '5%'
            },
            {
                data: 'taux_row',
                name: 'taux_row',
                orderable: true,
                searchable: true,
                width : '5%'

            }
        ],

        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });


    $('#interventions_projet_filter,#annee_projet_filter,#moa_projet_filter,#programme_projet_filter').on('change paste keyup', function (e) {
        projetsTable.draw();
        e.preventDefault();
    });


    //Projet longueur*********
    projetsLGTable = $('#projets_lg_statistcs_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 30,
        bInfo : false,
        info : false,
        bPaginate: false,
        bLengthChange : false,
        searching: false,
        language: {
            processing: '<img src="/images/loader/Preloader_2.gif" class="loader-datatable">'
        },

        ajax: {
            url: '/projetsLGStatistics',
            type: 'GET',
            data: function (d) {
                d.interventions = $('select[name=intervention_projet_lg]').val();
                d.annee = $('select[name=annee_projet_lg]').val();
                d.moa = $('select[name=moa_projet_lg]').val();
                d.programme = $('select[name=programme_projet_lg]').val();
            }

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
                data: 'nom_fr',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true,
                width : '45%'
            },
            {
                data: 'programme',
                name: 'programme',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'appel_offre',
                name: 'appel_offre',
                orderable: true,
                searchable: true,
                width : '25%'
            },
            {
                data: 'en_cours',
                name: 'en_cours',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'realise',
                name: 'realise',
                orderable: true,
                searchable: true,
                width : '5%'
            },
            {
                data: 'total_row',
                name: 'total_row',
                orderable: true,
                searchable: true,
                width : '5%'
            },
            {
                data: 'taux_row',
                name: 'taux_row',
                orderable: true,
                searchable: true,
                width : '5%'

            }
        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });

    $('#interventions_projet_lg_filter,#annee_projet_lg_filter,#moa_projet_lg_filter,#programme_projet_lg_filter').on('change paste keyup', function (e) {
        projetsLGTable.draw();
        e.preventDefault();
    });

});
