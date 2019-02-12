$(document).ready(function () {
    //LES DEMANDES accord_definitif ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    var oTable_accord_definitif = $('#demandes_datatables_accord_definitif').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: "<img src='{{asset('loader.gif')}}'>",
        },
        ajax: {
            url: 'demande/tab_accord_definitif',
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


    $('#communes_filter_accord_definitif,#session_filter_accord_definitif,#intervention_filter_accord_definitif,#partenaires_filter_accord_definitif,#localites_filter_accord_definitif,#reservation_filter_accord_definitif').on('change paste keyup', function (e) {
        oTable_accord_definitif.draw();
        e.preventDefault();
    });


    //select item from datatable
    //edite
    $("#modifier_accord_definitif").click(function () {
        var checked = false;
        $("#demandes_datatables_accord_definitif > tbody").find('input[name="checkbox_accord_definitif"]').each(function () {
            if ($(this).prop("checked") == true) {
                checked = true;
                var id = $('input[name=checkbox_accord_definitif]').val();
                window.location.href = "demandes/" + id + "/edit";
                return false;
            }
        });
        if (!checked) {
            swal("Veuillez selectionner une demande");
            return false;
        }
    });

    $("#restaurer_accord_definitif").click(function () {
        url = "demande/restaurer";
        datatble_id = "demandes_datatables_accord_definitif";
        name_chechbox = "checkbox_accord_definitif";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });


    //function for decision 
    function decision_function(datatble_id, name_chechbox, url, method) {
        //alert(datatble_id + ' ' + name_chechbox + ' ' + url);
        var message_sub_title = '';
        var message_reussi = '';
        if (url == "demandes/accord_definitif") {
            message_sub_title = "Ajouter a la liste des demandes avec accord définitif!";
            message_reussi = "Accord définitif réussi.";
        }
        if (url == "demandes/a_traiter") {
            message_sub_title = "Ajouter a la liste des demandes à traiter!";
            message_reussi = "A traiter réussi.";
        }

        if (url == "demandes/restaurer") {
            message_sub_title = "Restaurer la demande!";
            message_reussi = "Restauration de la demande ressuite.";
        }
        var demande_ids = [];
        var numero_ordres = [];
        var checked = false;
        $("#" + datatble_id + " > tbody ").find("input[name=" + name_chechbox + " ]").each(function () {
            if ($(this).is(":checked")) {
                checked = true;
                demande_ids.push($(this).val());
                numero_ordres.push($(this).data('numero'));
            }
        });
        if (!checked) {
            swal("Veuillez selectionner une demande");
            return false;
        }

        if (demande_ids.length > 0) {
            swal({
                title: "Vous êtes sûr?",
                text: message_sub_title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui, je confirme!",
                cancelButtonText: "Non, annuler!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    //send an ajax request to the server update decision column
                    $.ajax({
                        url: url,
                        type: method,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            demande_ids: demande_ids
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.length == 0) {
                                swal("Réussi!", message_reussi, "success");
                                setTimeout(location.reload.bind(location), 500);
                            }

                        }
                    });
                } else {
                    swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                }
            });
        }
    }

});
