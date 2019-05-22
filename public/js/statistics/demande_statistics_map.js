
// MAPPING ********************

var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map = new L.Map('map', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 15,zoomControl: false});


// or, add to an existing map:
map.addControl(new L.Control.Fullscreen());

L.control.zoom({
    position:'topright'
}).addTo(map);


var communes_Style = {
    color: "#898989",
    weight: 2,
    opacity: 1,
    fillOpacity: 0.75,
    fillColor: "#CDCDCD",
    zIndex : 1000000,
    weight: 0
};
var Communes_Layer = new L.GeoJSON.AJAX("/mapping/Communes.geojson",  {
    onEachFeature: function (feature, layer) {
        layer.bindTooltip(function (layer) {
                //console.log(feature);
                return layer.feature.properties.Nom; //merely sets the tooltip text
            }, {permanent: true, direction:"center"}  //then add your options
        ).addTo(map);
        layer.setStyle(communes_Style);
    }
});

Communes_Layer.addTo(map);


Communes_Layer.on('data:loaded', function() {
    colorCommunes();
    map.fitBounds(Communes_Layer.getBounds());
});

$('#interventions_demande_filter,#annee_demande_filter').on('change', function (e) {

    var intervention = $("#interventions_demande_filter").val();
    var annee = $("#annee_demande_filter").val();
    colorCommunes(intervention,annee);
});

function colorCommunes(intervention,annee)
{
    $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: "/getCommunesTaux",
        data : {
            intervention : intervention,
            annee : annee
        },
        success: function(res) {
            var communesGeoJson = Communes_Layer.toGeoJSON();
            console.log(res);
            L.geoJSON(communesGeoJson, {

                onEachFeature: function (feature, layer) {
                    layer.bindTooltip(function (layer) {

                            for(var i = 0; i < res.length; i++)
                            {
                                if(feature.properties.id == res[i].id)
                                {
                                    return res[i].taux+'%';
                                }
                            }
                            //merely sets the tooltip text
                        }, {permanent: true, direction:"bottom"}  //then add your options
                    ).addTo(map);
                },

                style: function(feature) {
                    //console.log('id commune geo : '+ feature.properties.id);
                    for(var i = 0; i < res.length; i++)
                    {
                        if(feature.properties.id == res[i].id)
                        {

                            return {color : "#000",fillColor: setColor(parseFloat(res[i].taux)),opacity: 1,weight: 0.2} ;
                        }
                    }
                }
            }).addTo(map);
        }
    });
}

function setColor(taux)
{


    if( taux <= 10)
    {
        return "#0000ff";
    }

    if(taux > 10 && taux <= 20)
    {
        return "#0000eb";
    }

    if(taux > 20 && taux <= 30 )
    {
        return "#0000d7";
    }
    if(taux > 30 && taux <= 40 )
    {
        return "#0000c4";
    }
    if(taux > 40 && taux <= 50 )
    {
        return "#0000b0";
    }
    if(taux > 50 && taux <= 60 )
    {
        return "#00009d";
    }
    if(taux > 60 && taux <= 70 )
    {
        return "#000089";
    }
    if(taux > 70 && taux <= 80 )
    {
        return "#000075";
    }
    if(taux > 80 && taux <= 90)
    {
        return "#000062";
    }
    if(taux > 90 && taux <= 100 )
    {
        return "#00004e";
    }

}


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

