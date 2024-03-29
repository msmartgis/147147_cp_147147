var conventionsTable;
var checked_convention = 0;
$(document).ready(function () {

    conventionsTable = $('#projet_programmes_datatables').DataTable({
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
            url: 'projets/show',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes]').val();
                //d.session = $('select[name=session]').val();
                d.interventions = $('select[name=interventions]').val();
                d.partenaires = $('select[name=partenaires]').val();
                d.localites = $('select[name=localites]').val();
                d.moas = $('select[name=moas]').val();
                d.programmes = $('select[name=programmes]').val();
                d.annee = $('select[name=annee]').val();
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


    $('#communes_filter,#intervention_filter,#partenaires_filter,#localites_filter,#programmes_filter,#moas_filter,#annee_filter').on('change paste keyup', function (e) {
        conventionsTable.draw();
        e.preventDefault();
    });

});
