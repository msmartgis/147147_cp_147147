$(document).ready(function () {

    //LES DEMANDES AFFECTEES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    var oTable_affectees = $('#demandes_datatables_affectees').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: "<img src='{{asset('loader.gif')}}'>",
        },
        ajax: {
            url: 'demande/is_affecter',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_filter_affectees]').val();
                d.session = $('select[name=session_filter_affectees]').val();
                d.interventions = $('select[name=interventions_filter_affectees]').val();
                d.partenaires = $('select[name=partenaires_filter_affectees]').val();
                d.localites = $('select[name=localites_filter_affectees]').val();
                d.daterange = $('input[name=daterange_filter_affectees]').val();
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
            },


            {
                data: 'session',
                name: 'session.nom',
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


    $('#communes_filter_affectees,#session_filter_affectees,#intervention_filter_affectees,#partenaires_filter_affectees,#localites_filter_affectees,#reservation_filter_affectees').on('change paste keyup', function (e) {
        oTable_affectees.draw();
        e.preventDefault();
    });


    //select item from datatable
    //edite
    $("#modifier_affectees").click(function () {
        var checked = false;
        $("#demandes_datatables_affectees > tbody").find('input[name="checkbox_affectees"]').each(function () {
            if ($(this).prop("checked") == true) {
                var id = $('input[name=checkbox_affectees]').val();
                checked = true;
                window.location.href = "conventions/" + id + "/edit";
                return false;
            }
        });
        if (!checked) {
            swal("Veuillez selectionner une demande");
            return false;
        }
    });

    //restaurer from affectation 
    $("#restaurer_affectees").click(function () {
        url = "demande/restaurer_from_affectation";
        datatble_id = "demandes_datatables_affectees";
        name_chechbox = "checkbox_affectees";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });


});
