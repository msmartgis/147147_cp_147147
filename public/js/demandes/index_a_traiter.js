var demandeATaiterTable;
var checkedelementsDemandesAT=[];
$(document).ready(function () {
    var checked_demande_a_t = 0;
     demandeATaiterTable = $('#demandes_datatables_a_traiter').DataTable({
        processing: true,
        serverSide: true,
         pageLength: 15,
        language: {
            search: '', searchPlaceholder: 'Recherche...',
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: '<img src="{{asset("images/logo.png")}}">',
        },
        ajax: {
            url: 'demandes/tab_a_traiter',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes_a_traiter]').val();
                d.session_id = $('select[name=session_id]').val();
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

    demandeATaiterTable.on('draw', function () {
        for(i=0;i<checkedelementsDemandesAT.length;i++)
        {
            $("#demandeATraiterCb_"+checkedelementsDemandesAT[i].data('id')).prop('checked', true);
        }

        $('#demandes_datatables_a_traiter :input[type="checkbox"]').change(function() {
            if(this.checked) {
                checkedelementsDemandesAT.push($(this));
            }
            else {
                checkedelementsDemandesAT.splice(checkedelementsDemandesAT.indexOf(this),1);
            }


            //get the right button activated
            number_checked = checkedelementsDemandesAT.length;


            if(number_checked === 0)
            {
                $('.multiple-choice-a-traiter,.unique-choice-a-traiter').attr('disabled', true);
            }

            if(number_checked === 1)
            {
                $('.multiple-choice-a-traiter,.unique-choice-a-traiter').removeAttr("disabled");
            }

            if(number_checked > 1)
            {
                $('.multiple-choice-a-traiter').removeAttr('disabled');
                $('.unique-choice-a-traiter').attr('disabled', true);
            }

        });

    });


    $('#communes_filter_a_traiter,#intervention_filter_a_traiter,#partenaires_filter_a_traiter,#localites_filter_a_traiter,#session_filter_a_traiter,#reservation_a_traiter').on('change paste keyup', function (e) {
        demandeATaiterTable.draw();
        e.preventDefault();
    });


    //effecter
    $("#accord_definitif_btn_a_traiter").click(function () {
        datatbleId = "demandes_datatables_a_traiter";
        nameCheckbox = "checkbox_a_traiter";
        titleModal = "ACCORD DEFINITIF";
        affectOrAccord = 0;
        accordAndAffectation_modal_data(titleModal,datatbleId ,nameCheckbox,affectOrAccord);
    });


    $("#restaurer_a_traiter").click(function () {
        url = "demandes/restaurer";
        datatble_id = "demandes_datatables_a_traiter";
        name_chechbox = "checkbox_a_traiter";
        method = "POST";
        decision_function(datatble_id, checkedelementsDemandesAT, url, method);
    });


});
