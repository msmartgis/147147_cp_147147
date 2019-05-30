var en_coursTable;
var checked_convention = 0;
$(document).ready(function () {

    en_coursTable = $('#projet_en_cours_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        bInfo : false,
        info : false,
        bLengthChange : true,
        language: {
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
        },

        ajax: {
            url: 'projetsEnCours/show',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_en_cours]').val();
                //d.session = $('select[name=session]').val();
                d.interventions = $('select[name=interventions_en_cours]').val();
                d.partenaires = $('select[name=partenaires_en_cours]').val();
                d.localites = $('select[name=localites_en_cours]').val();
                d.moas = $('select[name=moas_en_cours]').val();
                d.programmes = $('select[name=programmes_en_cours]').val();
                d.annee = $('select[name=annee_en_cours]').val();
            }

        },
        columnDefs: [

        ],
        columns: [


            {
                data: 'num_ordre',
                name: 'conventions.num_ordre',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'point_desservis',
                name: 'point_desservis.nom_fr',
                orderable: true,
                searchable: true,
                width: '20%'
            },
            {
                data: 'communes',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true,
                width: '10%'
            },
            {
                data: 'longueur',
                name: 'piste.longueur',
                orderable: true,
                searchable: true,
                width: '5%'
            },

            {
                data: 'interventions',
                name: 'interventions',
                orderable: true,
                searchable: true,
                width: '10%'
            },

            {
                data: 'moas',
                name: 'moas.nom_fr',
                orderable: true,
                searchable: true,
                width: '6%'
            },
            {
                data: 'partenaires',
                name: 'partenaires.nom_fr',
                orderable: true,
                searchable: true,
                width : '15%'
            },
            {
                data: 'programme',
                name: 'programme.nom_fr',
                orderable: true,
                searchable: true,
                width : '4%'
            },
            {
                data: 'montant_global',
                name: 'conventions.montant_global',
                orderable: true,
                searchable: true,
                width : '4%'
            },
            {
                data: 'annee',
                name: 'conventions.annee',
                orderable: true,
                searchable: true,
                width : '4%'
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


    $('#communes_en_cours_filter,#intervention_en_cours_filter,#partenaires_en_cours_filter,#localites_en_cours_filter,#programmes_en_cours_filter,#moas_en_cours_filter,#annee_en_cours_filter').on('change paste keyup', function (e) {
        en_coursTable.draw();
        e.preventDefault();
    });

});
