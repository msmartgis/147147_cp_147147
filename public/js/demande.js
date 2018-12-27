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

$(function () {
    $("#document").change(function () {
        $(".etat").hide();
        $("#" + $(this).val()).show();
    });
});

$(function () {
    $("#type_point").change(function () {
        $(".point-desservis").hide();
        $("#" + $(this).val()).show();
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
