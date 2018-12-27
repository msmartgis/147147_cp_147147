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

$.fn.changeMnt = function () {
    var element = $(this);
    var footer = element.find('tfoot tr');
    var dataRows = element.find('tbody tr');
    element.find('td').on('change', function (evt) {
        alert('sfsf');
        // var cell = $(this),
        //     column = cell.index(),
        //     total = 0;
        // if (column === 0) {
        //     return;
        // }
        // element.find('tbody tr').each(function () {
        //     var row = $(this);
        //     total += parseFloat(row.children().eq(column).text());
        // });
        // if (column === 1 && total > 5000000000000) {
        //     $('.alert').show();
        //     return false; // changes can be rejected
        // } else {
        //     $('.alert').hide();
        //     footer.children().eq(column).text(total);
        // }
    });

};

// var element = $(this),
//     footer = element.find('tfoot tr'),
//     dataRows = element.find('tbody tr'),


$(document).ready(function () {
    $("#add_partenaire").click(function () {
        $("#mainTable_body").append("<tr><td data-editable='true'><select class='form-control select2' style='width: 100%;'><option selected='selected'>Conseil provinciale</option><option>Commune</option><option>ANDZOA</option><option>Association</option><option>INDH</option><option>Région</option><option>Autre</option></select></td><td data-editable='true'>0</td><td data-editable='true'>0</td></tr>");
        $('#mainTable').editableTableWidget();
    });

});
