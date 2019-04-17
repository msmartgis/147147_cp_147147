var demandeAffecteTable;
$(document).ready(function () {
    demandeAffecteTable = $('#demandes_datatables_affectees').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            processing: "<img src='{{asset('loader.gif')}}'>",
        },
        ajax: {
            url: 'demandes/tab_is_affecter',
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

    demandeAffecteTable.on('draw', function () {
        $('#demandes_datatables_affectees :input[type="checkbox"]').change(function() {
            number_checked = $('#demandes_datatables_affectees :input[type="checkbox"]:checked').length;


            if(number_checked === 0)
            {
                $('.multiple-choice-affecte').attr('disabled', true);
            }

            if(number_checked === 1)
            {
                $('.multiple-choice-affecte').removeAttr("disabled");
            }

            if(number_checked > 1)
            {
                $('.multiple-choice-affecte').removeAttr('disabled');
            }
        });
    } );


    $('#communes_filter_affectees,#intervention_filter_affectees,#partenaires_filter_affectees,#localites_filter_affectees,#reservation_filter_affectees').on('change paste keyup', function (e) {
        demandeAffecteTable.draw();
        e.preventDefault();
    });

    //Affectation aux conventions
    $("#affecter_btn_accord_definitif").click(function () {
        datatbleId = "demandes_datatables_accord_definitif";
        nameCheckbox = "checkbox_accord_definitif";
        titleModal = "AFFECTER AUX CONVENTIONS";
        affectOrAccord = 1;
        accordAndAffectation_modal_data(titleModal,datatbleId ,nameCheckbox,affectOrAccord);
    });


    $("#restaurer_affecte_btn").click(function () {
        url = "demandes/restaurer_from_affectation";
        datatble_id = "demandes_datatables_affectees";
        name_chechbox = "checkbox_affectees";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });



});