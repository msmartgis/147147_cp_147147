var ny = [29.504514364812469, -9.599814615107725];
// création de la map
var map = L.map("map").setView(ny, 10);

// création du calque images
var baselayer = L.tileLayer(
    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 20
    }
).addTo(map);

// map layers changing

$("#hybrid_btn").click(function () {
    $("#satellite_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#hybrid_btn")
        .removeClass()
        .addClass("baselayer_btn active");
    $("#road_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#none_btn")
        .removeClass()
        .addClass("baselayer_btn");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map);
});
$("#satellite_btn").click(function () {
    $("#satellite_btn")
        .removeClass()
        .addClass("baselayer_btn active");
    $("#hybrid_btn")
        .removeClass()
        .addClass("baselayer_btn ");
    $("#road_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#none_btn")
        .removeClass()
        .addClass("baselayer_btn");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map);
});
$("#road_btn").click(function () {
    $("#satellite_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#hybrid_btn")
        .removeClass()
        .addClass("baselayer_btn ");
    $("#road_btn")
        .removeClass()
        .addClass("baselayer_btn active");
    $("#none_btn")
        .removeClass()
        .addClass("baselayer_btn");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map);
});
$("#none_btn").click(function () {
    $("#satellite_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#hybrid_btn")
        .removeClass()
        .addClass("baselayer_btn ");
    $("#road_btn")
        .removeClass()
        .addClass("baselayer_btn");
    $("#none_btn")
        .removeClass()
        .addClass("baselayer_btn active");
    baselayer.remove();
});

//show the right select box

//piece change
$('.table-piece tbody').on('change', '.document', function () {
    var currow = $(this).closest('tr');
    var col1 = currow.find('td:eq(1)').text();
    //console.log(col1);

    currow.find('td .etat').html('');

    switch (currow.find('td .document').val()) {
        case 'etude':
            currow.find('td .etat').append('<option selected="selected">Approuvée</option>');
            currow.find('td .etat').append('<option>Disponible</option>');
            currow.find('td .etat').append('<option>En cours d\'approbation </option>');

            break;
        case 'fiche_technique':
            currow.find('td .etat').append('<option selected="selected">Sce concérné</option>');
            currow.find('td .etat').append('<option>DE Province</option>');
            currow.find('td .etat').append('<option>Sce technique.com</option>');
            currow.find('td .etat').append('<option>BET</option>');
            break;

        default:
            currow.find('td .etat').append('<option selected="selected">Approuvée</option>');
            currow.find('td .etat').append('<option>Disponible</option>');
            currow.find('td .etat').append('<option>En cours d\'approbation < /option>');
    }
});

//add point
$(document).ready(function () {
    $('#add_point').click(function () {
        var type_point = "localite";
        $.ajax({
            type: 'get',
            url: "{{route('getlocalite')}}",
            dataType: 'html',
            data: {
                "_token": "{{ csrf_token() }}",
                "type": type_point
            },
            success: function (data) {
                console.log("success");
                //console.log(data);
            }
        });
        var markup = '<tr>\
        <td style=\"width: 40%\">\
            <div class=\"form-group\">\
                <select class=\"form-control type_point\" name="type_point[]" >\
                    <option value=\"localite\" selected=\"selected\">Localité</option>\
                    <option value=\"etablissement_scol\">Etablissement Scolaire</option>\
                    <option value=\"etablissemnt_sante\"><i class=\"fa fa-dollar\"></i>Etablissement de santé</option>\
                    <option value=\"autre\"><i class=\"fa fa-dollar\"></i>Autre</option>\
                </select>\
            </div>\
        </td>\
        <td style=\"width: 60%\">\
            <div class=\"form-group\">\
                <select class=\"form-control select2 point-desservis\" name="point_nom_fr[]" style=\"width: 100%;\">\
                    <option selected=\"selected\">Douar 1</option>\
                    <option>Douar 2</option>\
                    <option>Douar 3</option>\
                </select>\
            </div>\
        </td>\
    </tr>';

        $(".table-points tr:last").after(markup);
    });


    $('#add_piece').click(function () {
        var markup = '<tr>\
        <td>\
            <div class=\"form-group\">\
                <select class = \"form-control document\" name="pieces_types[]" style=\"width: 100%;\">\
                    <option value=\"etude\" selected=\"selected\">Etude </option>\
                    <option value=\"fiche_technique\"> Fiche technique</option>\
                </select>\
            </div>\
        </td>\
        <td>\
            <div class=\"form-group \">\
                <select class = \"form-control etat\" name="pieces_noms[]" style=\"width: 100%;\">\
                    <option selected=\"selected\">Approuvée </option>\
                    <option>Disponible</option>\
                    <option>En cours d\'approbation</option>\
                </select>\
            </div>\
        </td>\
        <td>\
            <div class=\"form-group\">\
                <input type=\"file\" name="pieces_uploads[]"class=\"form-control\" />\
            </div>\
        </td>\
    </tr>';
        $(".table-piece tr:last").after(markup);
    });
});


$(document).ready(function () {
    $('.table-points tbody').on('change', '.type_point', function () {
        var currow = $(this).closest('tr');
        var point_type = currow.find('td .type_point').val();
        //var col1 = currow.find('td:eq(1)').text();
        currow.find('td .point-desservis').html('');
        switch (point_type) {
            case 'localite':
                currow.find('td .point-desservis').append('<option selected="selected">Douar 1</option>');
                currow.find('td .point-desservis').append('<option>Douar 2</option>');
                currow.find('td .point-desservis').append('<option>Douar 3</option>');

                break;
            case 'etablissement_scol':
                currow.find('td .point-desservis').append('<option selected="selected">Etablissement Scol 1</option>');
                currow.find('td .point-desservis').append('<option>Etablissement Scol 2</option>');
                currow.find('td .point-desservis').append('<option>Etablissement Scol 3</option>');
                currow.find('td .point-desservis').append('<option>Etablissement Scol 4</option>');
                break;

            case 'etablissemnt_sante':
                currow.find('td .point-desservis').append('<option selected="selected">Etablissement sante 1</option>');
                currow.find('td .point-desservis').append('<option>Etablissement sante 2</option>');
                currow.find('td .point-desservis').append('<option>Etablissement sante 3</option>');
                currow.find('td .point-desservis').append('<option>Etablissement sante 4</option>');
                break;
            case 'autre':
                currow.find('td .point-desservis').append('<option selected="selected">autre</option>');

                break;
            default:
                currow.find('td .point-desservis').append('<option selected="selected">Douar 1</option>');
                currow.find('td .point-desservis').append('<option>Douar 2</option>');
                currow.find('td .point-desservis').append('<option>Douar 3</option>');
        }
    });
});

//add new parentaire
$(document).ready(function () {
    var item = 0;
    $("#add_partner").click(function (event) {
        if ($('#montant_g').val() == "") {
            event.stopPropagation();
        } else {
            $('#m-add-partenaire').modal("show");
        }
    });

    //item to make id checkbox unique

    $("#add_partner_to_list").click(function () {
        var montant_g = $('#montant_g').val();
        var partenair_type = $("#partenaire_type").val();
        var montant_partnenaire = $("#montant_partnenaire").val();
        //console.log(montant_partnenaire);
        var markup = '<tr>\
                        <td style=\'text-align:center\'>\
                        <div class=\"form-group\">\
                            <div class=\"checkbox\">\
                                <input type=\"checkbox\" id=\"row_' + item + '\" name=\"record\">\
                                <label for="row_' + item + '"></label>\
                            </div>\
                        </div>\
                        </td>\
                        <td style=\'text-align:center\'><input type="hidden" name="partnenaire_type[]" value="' + partenair_type + '">' + partenair_type + '</td>\
                        <td style=\'text-align:center\'><input type="hidden" name="montant[]" value="' + montant_partnenaire + '">' + montant_partnenaire + '</td>\
                        <td style=\'text-align:center\'><input type="hidden" name="pourcentage[]" value="' + (montant_partnenaire / montant_g) * 100 + '">' + (montant_partnenaire / montant_g) * 100 + '</td>\
                    </tr>';
        $("#table_body_partner").append(markup);
        $("#montant_partnenaire").val('');
        $("#m-add-partenaire").modal('toggle');
        item++;

    });

    $(".delete-row").click(function () {
        $("#table_body_partner").find('input[name="record"]').each(function () {
            if ($(this).is(":checked")) {
                $(this).parents("tr").remove();
            }
        });
    });

});
