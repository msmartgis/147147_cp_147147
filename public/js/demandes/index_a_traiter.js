$(document).ready(function () {
    var oTable = $('#demandes_datatables_a_traiter').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: "<img src='{{asset('images/logo.png')}}'>",
        },
        ajax: {
            url: 'demandes/tab_a_traiter',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_a_traiter]').val();
                d.session = $('select[name=session_a_traiter]').val();
                d.interventions = $('select[name=interventions_a_traiter]').val();
                d.partenaires = $('select[name=partenaires_a_traiter]').val();
                d.localites = $('select[name=localites_a_traiter]').val();
                d.daterange = $('input[name=daterange_a_traiter]').val();
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


    $('#communes_filter_a_traiter,#intervention_filter_a_traiter,#partenaires_filter_a_traiter,#localites_filter_a_traiter,#reservation_a_traiter').on('change paste keyup', function (e) {
        oTable.draw();
        e.preventDefault();
    });


    //effecter
    $("#accord_definitif_btn_a_traiter_tab").click(function () {

        url = "demandes/accord_definitif";
        datatble_id = "demandes_datatables_a_traiter";
        name_chechbox = "checkbox_a_traiter";
        method = "POST";

        decision_function(datatble_id, name_chechbox, url, method);
    });


    $("#restaurer_a_traiter").click(function () {
        url = "demandes/restaurer";
        datatble_id = "demandes_datatables_a_traiter";
        name_chechbox = "checkbox_a_traiter";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });


});
