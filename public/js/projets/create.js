
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


$(document).ready(function () {
    //pieces Mngmnt ************

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


});
