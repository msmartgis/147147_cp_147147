var projetsCartoTable;
$(document).ready(function () {

    projetsCartoTable = $('#projets_carto_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 15,
        bInfo : false,
        info : false,
        bLengthChange : false,
        language: {
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="/images/loader/loader4.gif">'
        },

        ajax: {
            url: 'carto/projetsCarto',
            type: 'GET',
            data: function (d) {
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
                data: 'num_ordre',
                name: 'conventions.num_ordre',
                orderable: true,
                searchable: true
            },
            {
                data: 'objet_fr',
                name: 'conventions.objet_fr',
                orderable: true,
                searchable: true,
                width : '25%'
            },
            {
                data: 'communes',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true
            },

            {
                data: 'longueur',
                name: 'longueur',
                orderable: true,
                searchable: true
            },
            {
                data: 'programme',
                name: 'programme',
                width : '25%',
                orderable: true,
                searchable: true
            },

            {
                data: 'etat',
                name: 'etat',
                orderable: true,
                searchable: true
            },
            {
                data: 'annee',
                name: 'conventions.annee',
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

});
