
var data;
var geometry;
$(document).ready(function () {


    //pieces Mngmnt ************
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

    var item = 1;
    $('#add_piece').click(function () {
        var markup = '<tr>\
        <td><div class="form-group">\
            <div class="checkbox">\
            <input type="checkbox" id="row_piece_"+item name="record">\
            <label for="row_piece_"+item></label>\
            </div>\
            </div></td>\
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
        item++;
        $(".table-piece tr:last").after(markup);
    });


    //item to make id checkbox unique
    var item_partenaire = 0;
    $("#add_partner_to_list").click(function () {
        var montant_g = $('#montant_g').val();
        var partenair_type_text = $("#partenaire_type :selected").text();
        var partenair_type_id = $("#partenaire_type").val();
        var montant_partnenaire = $("#montant_partnenaire").val();
        //console.log(montant_partnenaire);
        var pourcent = (parseFloat(montant_partnenaire.replace(/,/g, '')) / parseFloat(montant_g.replace(/,/g, '')) ) * 100;


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
            '<td style=\'text-align:center\'><input type="hidden" name="pourcentage[]" value="' + pourcent + '">' +  pourcent.toFixed(2) + '</td>'+
            '</tr>';

        $('#table_body_partner > tr:last').before(markup);
        $("#montant_partnenaire").val('');
        $("#partenaire_type :selected").remove();
        $("#m-add-partenaire").modal('toggle');
        item_partenaire++;
    });
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






var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map = new L.Map('map', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 14});




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



var style1 = {
    color: "#1e88e5",
    width: 3,
    opacity: 1,
    fillOpacity: 0.2,
    fillColor: "#1e88e5"
};
var style2 = {
    color: "#fc4b6c",
    width: 3,
    opacity: 1,
    fillOpacity: 0.2,
    fillColor: "#fc4b6c"
};


var style3 = {
    color: "#fc4129",
    width: 3,
    opacity: 1,
    fillOpacity: 0.2,
    fillColor: "#fc4129"
};

var selectedPiste = null;
var selectedItem = new L.FeatureGroup();

// Calculating the distance of the polyline
var tempLatLng = null;
var totalDistance = 0;

map.addLayer(selectedItem);



var drawControl = new L.Control.Draw({
    draw: {
        polyline: false,
        polygon: false,
        circle: false,
        marker: false,
        rectangle : false,
        circlemarker : false
    },
    edit: {
        featureGroup: selectedItem,
        draw: false,
        remove: false
    }
});
map.addControl(drawControl);
// or, add to an existing map:
map.addControl(new L.Control.Fullscreen());
var stateChangingButton = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:      'fa-edit',               // and define its properties
        title:     'Modifier piste',      // like its title
        onClick: function(btn, map) {

            if (selectedPiste != null) {
                selectedPiste.editing.enable();
            }      // and its callback

            btn.state('zoom-to-school');    // change state on click!
        }
    }, {
        stateName: 'zoom-to-school',
        icon:      'fa-save',
        title:     'Enregistrer les modifications',
        onClick: function(btn, map) {
            selectedPiste.editing.disable();
            selectedPiste.setStyle(style1);
            selectedPiste = null;
            btn.state('zoom-to-forest');
            btn.disable();

            //selectedItem.addLayer(e.layer);
            data = selectedItem.toGeoJSON();
            for(var i = 0 ; i < data.features.length;i++)
            {
                data.features[i].properties['id_piste'] = $('#piste_id_input').val();
            }

            geometry = JSON.stringify(data);
            $('#geometry_input').val(geometry);
            console.log(geometry);
            insertGeometryInput(geometry,'geometry_input');
        }
    }]
});
stateChangingButton.addTo(map);

var stateChangingButtonForAddingPiste = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:      'fa-pencil',               // and define its properties
        title:     'Modifier piste',      // like its title
        onClick: function(btn, map) {

            new L.Draw.Polyline(map, {shapeOptions: style2}).enable();
        }
    }]
});
stateChangingButtonForAddingPiste.addTo(map);



//delete polyline
var stateChangingButtonForDeletePiste = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:      'fa-close',               // and define its properties
        title:     'Supprimer piste',      // like its title
        onClick: function(btn, map) {
            if (selectedPiste != null) {
                swal({
                    title: "Vous êtes sûr?",
                    text: "La piste qua vous avez dessiné sera supprimer de la carte",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Oui, je confirme!",
                    cancelButtonText: "Non, annuler!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        selectedPiste.remove();
                        selectedItem.removeLayer(selectedPiste);

                        data = selectedItem.toGeoJSON();
                        if(data.features.length > 0)
                        {
                            for(var i = 0 ; i < data.features.length;i++)
                            {
                                data.features[i].properties['id_piste'] = $('#piste_id_input').val();
                            }
                            geometry = JSON.stringify(data);

                        }else{
                            geometry = '';
                        }

                        $('#geometry_input').val(geometry);
                        insertGeometryInput(geometry,'geometry_input');

                        swal("Réussi!", 'La piste a été supprimée avec succès', "success");
                    } else {
                        swal("L'operation est annulée", "Aucun changement a été éffectué", "error");
                    }
                });
            }
        }
    }]
});
stateChangingButtonForDeletePiste.addTo(map);


var txt = '';
var longueur_input = 0;
//on created draw
map.on('draw:created', function (e) {
    selectedItem.addLayer(e.layer);
    data = selectedItem.toGeoJSON();


    //calculate the distance
    $.each(e.layer._latlngs, function(i, latlng){
        if(tempLatLng == null){
            tempLatLng = latlng;
            return;
        }

        totalDistance += tempLatLng.distanceTo(latlng);
        tempLatLng = latlng;

    });
    if((totalDistance/1000) < 1)
    {
        longueur_input = (totalDistance/1000).toFixed(1);
    }else{
        longueur_input = Math.round((totalDistance/1000).toFixed(1));
    }


    $('#longueur_input').val(longueur_input);

    for(var i = 0 ; i < data.features.length;i++)
    {
        data.features[i].properties['id_piste'] = $('#piste_id_input').val();
        data.features[i].properties['type'] = 'demande';
    }

    data.features[0].properties['id_piste'] = $('#piste_id_input').val();
    geometry = JSON.stringify(data);
    $('#geometry_input').val(geometry);
    insertGeometryInput(geometry,'geometry_input');
});



function insertGeometryInput(geometry,input_id)
{
    $('#'+ input_id).val('');
    $('#'+input_id).val(geometry);
}

$(document).ready(function () {
    piste_id = $('#piste_id_input').val();
    getPiste();
    map.fitBounds(selectedItem.getBounds());
    stateChangingButton.disable();

    map.on('draw:created', function (e) {
        e.layer.on('click', function() {
            if (selectedPiste != null) {
                selectedPiste.setStyle(style1);
            }
            selectedPiste = e.layer;
            console.log(selectedPiste);
            e.layer.setStyle(style2);
            stateChangingButton.enable();
        });
        e.layer.setStyle(style1);
        selectedItem.addLayer(e.layer);
    });

    map.on('load', function(){
     //map.invalidateSize();
     console.log('<wx<wx');
    });

});


function getPiste() {
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: "/getPiste",
        data :  {
            'piste_id' : piste_id,
        },
        success: function(res) {
            var data = JSON.parse(res.geometry);
            console.log(data);
            L.geoJSON(data,{
                onEachFeature : (feature,layer) => {
                    layer.setStyle(style1);
                    selectedItem.addLayer(layer);

                    layer.on('click', function() {
                        if (selectedPiste != null) {
                            selectedPiste.setStyle(style1);
                        }
                        selectedPiste = layer;
                        console.log(selectedPiste);
                        layer.setStyle(style2);
                        stateChangingButton.enable();
                    });
                }
            });
            /*selectedItem = new L.FeatureGroup();
            selectedItem = data;
            //selectedItem.addTo(map);
            map.addLayer(selectedItem);*/
            //var featureGourpeFromDB  = res.geometry;
            //FeatureGroupeToGeojson = selectedItem.toGeoJSON();
            //FeatureGroupeToGeojson.features = data.features;
            //map.fitBounds(selectedItem.getBounds());
        }
    });
}

$(document).ready(function(){
    $(".localisation-tab").click(function() {


    });
});




