
var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map = new L.Map('map', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 14,zoomControl: false});




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
L.control.zoom({
    position:'topright'
}).addTo(map);

var stateChangingButton = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:    'fa fa-edit map-icon-edit',               // and define its properties
        title:     'Modifier piste',     // like its title

        onClick: function(btn, map) {

            if (selectedPiste != null) {
                selectedPiste.editing.enable();
            }      // and its callback

            btn.state('zoom-to-school');    // change state on click!
        }
    }, {
        stateName: 'zoom-to-school',
        icon:      'fa-save map-icon-save',
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
            insertGeometryInput(geometry,'geometry_input');
        }
    }]
});
stateChangingButton.addTo(map);

var stateChangingButtonForAddingPiste = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:      'fa fa-pencil map-icon-create',               // and define its properties
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
        icon:      'fa fa-trash map-icon-delete',               // and define its properties
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
        data.features[i].properties['type'] = 'projet';
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
           var bounds =  L.geoJSON(data,{
                onEachFeature : (feature,layer) => {
                    layer.setStyle(style1);
                    selectedItem.addLayer(layer);

                    layer.on('click', function() {
                        if (selectedPiste != null) {
                            selectedPiste.setStyle(style1);
                        }
                        selectedPiste = layer;
                        layer.setStyle(style2);
                        stateChangingButton.enable();
                    });
                }
            });

            map.fitBounds(bounds.getBounds());


        }
    });
}