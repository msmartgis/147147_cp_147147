var checkedelements=[];
$(document).ready(function () {

    var conventionAOTable;
    var checked_convention = 0;

    conventionAOTable = $('#appel_offre_datatables').DataTable({
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
                width: '1%'
            },
            {
                data: 'moas',
                name: 'moas',
                orderable: true,
                searchable: true,
                width: '1%'
            },

            {
                data: 'date_publication',
                name: 'date_publication',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'adjiducataire',
                name: 'adjiducataire',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'montant_global',
                name: 'montant_global',
                orderable: true,
                searchable: true,
                width: '3%'
            },
            {
                data: 'etat',
                name: 'etat',
                orderable: true,
                searchable: true,
                width: '3%'
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


});
