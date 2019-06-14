var nombreProjetTable;
$(document).ready(function () {

    nombreProjetTable = $('#nombre_projet_datatables').DataTable({
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
            url: '/TBD',
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
                data: 'nom_fr',
                name: 'programmes.nom_fr',
                orderable: false,
                searchable: false,
                className : 'text-styling',
                width : '20%'
            },
            {
                data: 'nbr_projet',
                name: 'nbr_projet',
                className: "text-center",
                orderable: false,
                searchable: false,
                width : '10%'
            },
            {
                data: 'cout',
                name: 'cout',
                orderable: false,
                searchable: false,
                className: "text-center",
                width : '10%'
            },
            {
                data: 'realise',
                name: 'realise',
                orderable: false,
                searchable: false,
                className: "text-center",
                width : '10%'
            },
            {
                data: 'en_cours',
                name: 'en_cours',
                orderable: false,
                searchable: false,
                className: "text-center",
                width : '10%'

            },
            {
                data: 'programmes',
                name: 'programmes',
                orderable: false,
                className: "text-center",
                searchable: false,
                width : '10%'

            },
            {
                data: 'total',
                name: 'total',
                orderable: false,
                searchable: false,
                className: "text-center",
                width : '10%'

            }
        ],

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            /*total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );*/

            // Total over this page
            nombre_projet = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            cout = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            realise = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            en_cours = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            programme = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            total = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 1 ).footer() ).html(
                nombre_projet
            );

            $( api.column( 2 ).footer() ).html(
                cout.toFixed(2)
            );

            $( api.column( 3 ).footer() ).html(
                realise
            );

            $( api.column( 4 ).footer() ).html(
                en_cours.toFixed(2)
            );

            $( api.column( 5 ).footer() ).html(
                programme.toFixed(2)
            );

            $( api.column( 6 ).footer() ).html(
                total.toFixed(1)
            );


        }

    });

});


