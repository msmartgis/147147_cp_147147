var demandesEnCoursTable;
var checked_demande_en_cours = 0;
$(document).ready(function () {

    demandesEnCoursTable = $('#demandes_datatables').DataTable({
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
            url: 'demandes/en_cours',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes]').val();
                //d.session = $('select[name=session]').val();
                d.interventions = $('select[name=interventions]').val();
                d.partenaires = $('select[name=partenaires]').val();
                d.localites = $('select[name=localites]').val();
                d.daterange = $('input[name=daterange]').val();
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

    demandesEnCoursTable.on('draw', function () {
        $('#demandes_datatables :input[type="checkbox"]').change(function() {
            number_checked = $('#demandes_datatables :input[type="checkbox"]:checked').length;

            if(number_checked === 0)
            {
                $('.multiple-choice-en-cours,.unique-choice-en-cours').attr('disabled', true);
            }

            if(number_checked === 1)
            {
                $('.unique-choice-en-cours,.multiple-choice-en-cours').removeAttr("disabled");
            }

            if(number_checked > 1)
            {
                $('.multiple-choice-en-cours').removeAttr('disabled');
                $('.unique-choice-en-cours').attr('disabled', true);
            }

        });
    } );


    $('#communes_filter,#intervention_filter,#partenaires_filter,#localites_filter,#reservation').on('change paste keyup', function (e) {
        demandesEnCoursTable.draw();
        e.preventDefault();
    });



//effecter
    $("#accord_definitif_btn").click(function () {
        datatbleId = "demandes_datatables";
        nameCheckbox = "checkbox";
        titleModal = "ACCORD DEFINITIF";
        affectOrAccord = 0;
        accordAndAffectation_modal_data(titleModal,datatbleId ,nameCheckbox,affectOrAccord);
    });

//a traiter
    $("#a_traiter_btn").click(function () {
        url = "demandes/a_traiter";
        datatble_id = "demandes_datatables";
        name_chechbox = "checkbox";
        method = "POST";
        decision_function(datatble_id, name_chechbox, url, method);
    });


//delete record from add partenaire table
    $("#delete_partenaire").click(function () {
        removeRowFromTable("table_body_partner");
    });


//delete record from add source financement table
    $("#delete_source_financement").click(function () {
        removeRowFromTable("table_body_source");
    });



//add new parentaire
    $("#add_partner").click(function (event) {
        if ($('#montant_g').val() == "") {
            event.stopPropagation();
        } else {
            $('#m-add-partenaire').modal("show");
        }
    });


//add new source for cp financement
    $("#add_source").click(function (event) {
        if ($('#montant_cp').val() == "") {
            event.stopPropagation();
        } else {
            $('#m-add-source-financement').modal("show");
        }
    });

//item to make id checkbox unique
    var item_partenaire = 0;
    $("#add_partner_to_list").click(function () {
        var montant_g = $('#montant_g').val();
        var partenair_type_text = $("#partenaire_type :selected").text();
        var partenair_type_id = $("#partenaire_type").val();
        var montant_partnenaire = $("#montant_partnenaire").val();

        var markup = '<tr>'+
            '<td style=\'text-align:center\'>'+
            '<div class=\"form-group\">'+
            '<div class=\"checkbox\">'+
            '<input type=\"checkbox\" id=\"row_' + item_partenaire + '\" name=\"record\">'+
            '<label for="row_' + item_partenaire + '"></label>'+
            '</div>'+
            '</div>'+
            '</td>'+
            '<td style = \'text-align:center\'><input type="hidden" name="partnenaire_type_ids[]" value="' + partenair_type_id + '">' + partenair_type_text + '</td>'+
            '<td style=\'text-align:center\'><input type="hidden" name="montant[]" value="' + montant_partnenaire + '">' + montant_partnenaire + '</td>'+
            '<td style=\'text-align:center\'><input type="hidden" name="pourcentage[]" value="' + (montant_partnenaire / montant_g) * 100 + '">' + (montant_partnenaire / montant_g) * 100 + '</td>'+
            '</tr>';

        $('#table_body_partner > tr:last').before(markup);
        $("#montant_partnenaire").val('');
        $("#partenaire_type :selected").remove();
        $("#m-add-partenaire").modal('toggle');
        item_partenaire++;
    });


//add source to list
    var item_source = 0;
    $("#add_source_to_list").click(function () {
        var montant_cp = $('#montant_cp').val();
        var sourceFinancementText = $("#sourceFinancement :selected").text().split(":").shift();
        var ref =  $("#sourceFinancement :selected").text().split(":").pop();
        var source_id = $("#sourceFinancement").val();
        var montant_source = $("#montant_sourceFinancement").val();


        var markup_source = '<tr>'+
            '<td style="text-align:center">'+
            '<div class="form-group">'+
            '<div class="checkbox">'+
            '<input type="checkbox" id="row_' + item_source + '\" name="record">'+
            '<label for="row_' + item_source + '"></label>'+
            '</div>'+
            '</div>'+
            '</td>'+
            '<td style = "text-align:center"><input type="hidden" name="source_financement_ids[]" value="' + source_id + '">' + sourceFinancementText + '</td>'+
            '<td style="text-align:center"><input type="hidden" name="ref[]" value="' + ref + '">' + ref + '</td>'+
            '<td style="text-align:center"><input type="hidden" name="montant_source[]" value="' + montant_source + '">' + montant_source+ '</td>'+
            '</tr>';


        $('#table_body_source > tr:last').before(markup_source);
        $("#montant_sourceFinancement").val('');
        $("#sourceFinancement :selected").remove();
        $("#m-add-source-financement").modal('toggle');
        item_source++;
    });

});
