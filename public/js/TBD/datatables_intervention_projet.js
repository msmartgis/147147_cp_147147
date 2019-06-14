var interventionProjetTable;
$(document).ready(function () {

    interventionProjetTable = $('#intervention_projet_datatables').DataTable({

        processing: true,
        serverSide: true,
        pageLength: 30,
        bInfo: false,
        info: false,
        bPaginate: false,
        bLengthChange: false,
        searching: false,
        language: {
            processing: '<img src="/images/loader/Preloader_2.gif" class="loader-datatable">'
        },

        ajax: {
            url: '/TBDIntervention',
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
                width: '20%'
            },
            {
                data: 'terrassement',
                name: 'terrassement',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'
            },
            {
                data: 'revetement',
                name: 'revetement',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'
            },
            {
                data: 'dallage',
                name: 'dallage',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'
            },
            {
                data: 'pave',
                name: 'pave',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'recallibrage',
                name: 'recallibrage',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'elargissement',
                name: 'elargissement',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'renforcement',
                name: 'renforcement',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'ouvrage',
                name: 'ouvrage',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'entretien',
                name: 'entretien',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '8%'

            },
            {
                data: 'etude',
                name: 'etude',
                orderable: false,
                searchable: false,
                className: "text-center",
                width: '10%'

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
            terrassement = api
                .column( 1, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            revetement = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            dallage = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            pave = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            recalibrage = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            elargissemnt = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            renforcement = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            ouvrage = api
                .column( 8, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            entretien = api
                .column( 9, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            etude = api
                .column( 10, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );



            // Update footer
            $( api.column( 1 ).footer() ).html(
                terrassement
            );

            $( api.column( 2 ).footer() ).html(
                revetement
            );

            $( api.column( 3 ).footer() ).html(
                dallage
            );

            $( api.column( 4 ).footer() ).html(
                pave.toFixed(2)
            );

            $( api.column( 5 ).footer() ).html(
                recalibrage
            );

            $( api.column( 6 ).footer() ).html(
                elargissemnt
            );

            $( api.column( 7 ).footer() ).html(
                renforcement
            );

            $( api.column( 8 ).footer() ).html(
                ouvrage
            );

            $( api.column( 9 ).footer() ).html(
                entretien
            );

            $( api.column( 10 ).footer() ).html(
                etude
            );

        }

    });

});


