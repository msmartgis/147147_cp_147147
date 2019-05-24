var demandesTable;
var demandesTableLongueur;
var checked_demande_en_cours = 0;
$(document).ready(function () {

    demandesTable = $('#demandes_statistcs_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 30,
        bInfo : false,
        info : false,
        bPaginate: false,
        bLengthChange : false,
        language: {
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="images/loader/loader4.gif">'
        },

        ajax: {
            url: '/demandesStatistics',
            type: 'GET',
            data: function (d) {
                d.interventions = $('select[name=intervention_demande]').val();
                d.annee = $('select[name=annee_demande]').val();
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
                width : '30%'
            },
            {
                data: 'en_cours_nombre',
                name: 'en_cours_nombre',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'accord_definitif_nombre',
                name: 'accord_definitif_nombre',
                orderable: true,
                searchable: true,
                width : '25%'
            },
            {
                data: 'total_row',
                name: 'total_row',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'row_taux',
                name: 'row_taux',
                orderable: true,
                searchable: true

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



    $('#interventions_demande_filter,#annee_demande_filter').on('change paste keyup', function (e) {
        demandesTable.draw();
        e.preventDefault();
    });




    //demandes longueur*********
    /*
    get demandes statistics longeur
     */
    demandesTableLongueur = $('#demandes_longueur_statistcs_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 30,
        bPaginate: false,
        bInfo : false,
        info : false,
        bLengthChange : false,
        language: {
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="images/loader/loader4.gif">'
        },

        ajax: {
            url: '/demandesStatisticsLongueur',
            type: 'GET',
            data: function (d) {
                d.interventions = $('select[name=intervention_demande]').val();
                d.annee = $('select[name=annee_demande]').val();
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
                width : '30%'
            },
            {
                data: 'en_cours_longeur',
                name: 'en_cours_longeur',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'accord_definitif_longeur',
                name: 'accord_definitif_longeur',
                orderable: true,
                searchable: true,
                width : '25%'
            },
            {
                data: 'total_row_longeur',
                name: 'total_row_longeur',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'taux_row_longeur',
                name: 'taux_row_longeur',
                orderable: true,
                searchable: true

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



    $('#interventions_demande_filter,#annee_demande_filter').on('change paste keyup', function (e) {
        demandesTable.draw();
        e.preventDefault();
    });



});
