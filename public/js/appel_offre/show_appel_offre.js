var checkedelements=[];
$(document).ready(function () {

    var AOTable;
    var checked_convention = 0;

    AOTable = $('#appel_offre_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        bLengthChange : true,
        language: {
            processing: '<img src="/images/loader/loader_3.gif"  />',
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
        },

        ajax: {
            url: '/conventions/showAppelOffre',
            type: 'GET',
            data: function (d) {
                d.moas = $('select[name=moas]').val();
                d.interventions = $('select[name=interventions]').val();
                d.etat = $('select[name=etat]').val();
                d.nb_projet = $('select[name=nb_projet]').val();
                d.daterange_publication = $('input[name=daterange_publication]').val();
                d.daterange_ouverture_plis = $('input[name=daterange_ouverture_plis]').val();
            }
        },

        columns: [
            {
                data: 'numero',
                name: 'numero',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'nombre_projet',
                name: 'nombre_projet',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'objet_fr',
                name: 'objet_fr',
                orderable: true,
                searchable: true,
                width: '20%'
            },
            {
                data: 'moas',
                name: 'moas',
                orderable: true,
                searchable: true,
                width: '10%'
            },

            {
                data: 'date_publication',
                name: 'date_publication',
                orderable: true,
                searchable: true,
                width: '10%'
            },
            {
                data: 'adjiducataire',
                name: 'adjiducataire',
                orderable: true,
                searchable: true,
                width: '10%'
            },
            {
                data: 'montant_global',
                name: 'montant_global',
                orderable: true,
                searchable: true,
                width: '8%'
            },
            {
                data: 'etat',
                name: 'etat',
                orderable: true,
                searchable: true,
                width: '8%'
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

    $('#moas_filter,#intervention_filter,#etat_filter,#nb_projet_filter,#reservation,#ouverture_plis').on('change paste keyup', function (e) {
        AOTable.draw();
        e.preventDefault();
    });


});
