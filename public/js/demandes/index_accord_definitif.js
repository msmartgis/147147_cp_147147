$(document).ready(function () {

    var oTable_accord_definitif = $('#demandes_datatables_accord_definitif').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: "<img src='{{asset('loader.gif')}}'>",
        },
        ajax: {
            url: 'demandes/tab_accord_definitif',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_filter_accord_definitif]').val();
                d.session = $('select[name=session_filter_accord_definitif]').val();
                d.interventions = $('select[name=interventions_filter_accord_definitif]').val();
                d.partenaires = $('select[name=partenaires_filter_accord_definitif]').val();
                d.localites = $('select[name=localites_filter_accord_definitif]').val();
                d.daterange = $('input[name=daterange_filter_accord_definitif]').val();
            }
        },
        columnDefs: [

            {
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
        columns: [{
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false
            },

            {
                data: 'num_ordre',
                name: 'demandes.num_ordre',
                orderable: true,
                searchable: true
            },
            {
                data: 'date_reception',
                name: 'demandes.date_reception',
                orderable: true,
                searchable: true
            },
            {
                data: 'objet_fr',
                name: 'demandes.objet_fr',
                orderable: true,
                searchable: true
            },
            {
                data: 'communes',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true
            },
            {
                data: 'porteur',
                name: 'porteur.nom_porteur_fr',
                orderable: true,
                searchable: true
            },
            {
                data: 'interventions',
                name: 'interventions.nom',
                orderable: true,
                searchable: true
            },
            {
                data: 'partenaires',
                name: 'partenaires.nom_fr',
                orderable: true,
                searchable: true
            },
            {
                data: 'montant_global',
                name: 'montant_global',
                orderable: true,
                searchable: true
            },
            {
                data: 'montantCP',
                name: 'montantCP',
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


    $('#communes_filter_accord_definitif,#intervention_filter_accord_definitif,#partenaires_filter_accord_definitif,#localites_filter_accord_definitif,#reservation_filter_accord_definitif').on('change paste keyup', function (e) {
        oTable_accord_definitif.draw();
        e.preventDefault();
    });




    $("#restaurer_accord_definitif").click(function () {
        url = "demandes/restaurer";
        datatble_id = "demandes_datatables_accord_definitif";
        name_chechbox = "checkbox_accord_definitif";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });



});
