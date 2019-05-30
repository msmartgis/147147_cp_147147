var appelOffreTable;
var checked_convention = 0;
$(document).ready(function () {

    appelOffreTable = $('#projet_appel_offre_datatables').DataTable({
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
            url: 'projetsAppelOffre/show',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_appel_offre]').val();
                //d.session = $('select[name=session]').val();
                d.interventions = $('select[name=interventions_appel_offre]').val();
                d.partenaires = $('select[name=partenaires_appel_offre]').val();
                d.localites = $('select[name=localites_appel_offre]').val();
                d.moas = $('select[name=moas_appel_offre]').val();
                d.programmes = $('select[name=programmes_appel_offre]').val();
                d.annee = $('select[name=annee_appel_offre]').val();
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
                data: 'num_appel_offre',
                name: 'num_appel_offre',
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


    $('#communes_appel_offre_filter,#intervention_appel_offre_filter,#partenaires_appel_offre_filter,#localites_appel_offre_filter,#programmes_appel_offre_filter,#moas_appel_offre_filter,#annee_appel_offre_filter').on('change paste keyup', function (e) {
        appelOffreTable.draw();
        e.preventDefault();
    });

});
