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
    console.log(col1);

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


//point desservis
$('.table-points tbody').on('change', '.type_point', function () {
    var currow = $(this).closest('tr');
    //var col1 = currow.find('td:eq(1)').text();


    currow.find('td .point-desservis').html('');

    switch (currow.find('td .type_point').val()) {
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

$(function () {

    $(".type_point").change(function () {
        //console.log($('.type_point').val())

    });
});

//keyup for montage fincanciere calcul de pourcentage automatique

$(document).ready(function () {
    $('#add_partenaire').click(function () {
        var table = $('#table');
        var body = $('#tableBody');
        var nextId = body.find('tr').length + 1;
        table.append($('<tr><td>' + nextId + '</td><td>Commune</td><td>0</td><td>0</td></tr>'));
        table.data('Tabledit').reload();
    });

});


$(document).ready(function () {
    $('#table').Tabledit({
        columns: {
            identifier: [0, 'id'],
            editable: [
                [1, 'partenaire',
                    '{"1": "Commune", "2": "INDH", "3": "ANDZOA","4": "Autre"}'
                ],
                [2, 'montant'],
                [3, 'pourcentage']
            ],
        },
        hideIdentifier: true,
        restoreButton: false
    });
});


$(document).ready(function () {
    $('#add_point').click(function () {
        var markup = '<tr>\
        <td style=\"width: 40%\">\
            <div class=\"form-group\">\
                <select class=\"form-control type_point\">\
                    <option value=\"localite\" selected=\"selected\">Localité</option>\
                    <option value=\"etablissement_scol\">Etablissement Scolaire</option>\
                    <option value=\"etablissemnt_sante\"><i class=\"fa fa-dollar\"></i>Etablissement de santé</option>\
                    <option value=\"autre\"><i class=\"fa fa-dollar\"></i>Autre</option>\
                </select>\
            </div>\
        </td>\
        <td style=\"width: 60%\">\
            <div class=\"form-group\">\
                <select class=\"form-control select2 point-desservis\" style=\"width: 100%;\">\
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
                <select class=\"form-control document\" style=\"width: 100%;\">\
                    <option value=\"etude\" selected=\"selected\">Etude </option>\
                    <option value=\"fiche_technique\"> Fiche technique</option>\
                </select>\
            </div>\
        </td>\
        <td>\
            <div class=\"form-group \">\
                <select class=\"form-control etat\" style=\"width: 100%;\">\
                    <option selected=\"selected\">Approuvée </option>\
                    <option>Disponible</option>\
                    <option>En cours d\'approbation</option>\
                </select>\
            </div>\
        </td>\
        <td>\
            <div class=\"form-group\">\
                <input type=\"file\" class=\"form-control\" />\
            </div>\
        </td>\
    </tr>';

        $(".table-piece tr:last").after(markup);
    });

});
