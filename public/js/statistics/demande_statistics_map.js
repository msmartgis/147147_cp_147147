

// MAPPING ********************
    var osmUrl = 'https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}',
        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
        map_nombre = new L.Map('map_nombre', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 15,zoomControl: false});

        /*onMapReady(map_nombre: L.Map) {
            setTimeout(() => {
                map_nombre.invalidateSize();
            }, 0);
        }*/
// or, add to an existing map:
    map_nombre.addControl(new L.Control.Fullscreen());

    L.control.zoom({
        position:'topright'
    }).addTo(map_nombre);



// map layers changing
    $("#hybrid_btn_demande").click(function () {
        $("#satellite_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#hybrid_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande active");
        $("#road_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#none_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        baselayer.remove();
        baselayer = L.tileLayer(
            "https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}", {
                maxZoom: 19,
                attribution: ""
            }
        ).addTo(map_nombre);
    });
    $("#satellite_btn_demande").click(function () {
        $("#satellite_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande active");
        $("#hybrid_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande ");
        $("#road_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#none_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        baselayer.remove();
        baselayer = L.tileLayer(
            "https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
                maxZoom: 19,
                attribution: ""
            }
        ).addTo(map_nombre);
    });
    $("#road_btn_demande").click(function () {
        $("#satellite_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#hybrid_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande ");
        $("#road_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande active");
        $("#none_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        baselayer.remove();
        baselayer = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
                attribution: ""
            }
        ).addTo(map_nombre);
    });
    $("#none_btn_demande").click(function () {
        $("#satellite_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#hybrid_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande ");
        $("#road_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande");
        $("#none_btn_demande")
            .removeClass()
            .addClass("baselayer_btn_demande active");
        baselayer.remove();
    });

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
                }, {permanent: true, direction:"center",className : 'm-toolTip'}  //then add your options
            ).addTo(map_nombre);
            layer.setStyle(communes_Style);
        }
    });

    Communes_Layer.addTo(map_nombre);


    Communes_Layer.on('data:loaded', function() {
        colorCommunes();
        map_nombre.fitBounds(Communes_Layer.getBounds());
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

                //Communes_Layer.clearLayers();
                var communesGeoJson = Communes_Layer.toGeoJSON();


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
                         }, {permanent: true, direction:"bottom",className : 'm-toolTip'}  //then add your options
                         ).addTo(map_nombre);
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
                }).addTo(map_nombre);
            }
        });
    }





//LONGEUR DEMANDE***********

var osmUrl = 'https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map_lg = new L.Map('map_demande_lg', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 10,zoomControl: false});

//map_lg.on('load', console.log('dzdzdz'));
//setTimeout(map_lg.invalidateSize(), 10000);


$(window).on('load', function () {
    setTimeout(map_lg.invalidateSize(), 2000);
});


// or, add to an existing map:
map_lg.addControl(new L.Control.Fullscreen());

L.control.zoom({
    position:'topright'
}).addTo(map_lg);



// map layers changing
$("#hybrid_btn_demande_lg").click(function () {
    $("#satellite_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#hybrid_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg active");
    $("#road_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#none_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_lg);
});
$("#satellite_btn_demande_lg").click(function () {
    $("#satellite_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg active");
    $("#hybrid_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg ");
    $("#road_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#none_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_lg);
});
$("#road_btn_demande_lg").click(function () {
    $("#satellite_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#hybrid_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg ");
    $("#road_btn_demande")
        .removeClass()
        .addClass("baselayer_btn_demande_lg active");
    $("#none_btn_demande")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_lg);
});
$("#none_btn_demande_lg").click(function () {
    $("#satellite_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#hybrid_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg ");
    $("#road_btn_demande_lg")
        .removeClass()
        .addClass("baselayer_btn_demande_lg");
    $("#none_btn_demande")
        .removeClass()
        .addClass("baselayer_btn_demande_lg active");
    baselayer.remove();
});


var communes_demande_lg_Style = {
    color: "#898989",
    weight: 2,
    opacity: 1,
    fillOpacity: 0.75,
    fillColor: "#CDCDCD",
    zIndex : 1000000,
    weight: 0
};
var Communes_demande_lg_Layer = new L.GeoJSON.AJAX("/mapping/Communes.geojson",  {
    onEachFeature: function (feature, layer) {
        layer.bindTooltip(function (layer) {
                //console.log(feature);
                return layer.feature.properties.Nom; //merely sets the tooltip text
            }, {permanent: true, direction:"center",className : 'm-toolTip'}  //then add your options
        ).addTo(map_lg);
        layer.setStyle(communes_demande_lg_Style);

    }
});

Communes_demande_lg_Layer.addTo(map_lg);

/*
Communes_demande_lg_Layer.on('data:loaded', function() {
    colorCommunesLg();
    map_lg.fitBounds(Communes_demande_lg_Layer.getBounds());
});*/

$('#interventions_demande_lg_filter,#annee_demande_lg_filter').on('change', function (e) {
    var intervention = $("#interventions_demande_lg_filter").val();
    var annee = $("#annee_demande_lg_filter").val();
    colorCommunesLg(intervention,annee);
});

function colorCommunesLg(intervention,annee)
{
    $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: "/getCommunesTauxLg",
        data : {
            intervention : intervention,
            annee : annee
        },
        success: function(res) {
            var communesLGGeoJson = Communes_demande_lg_Layer.toGeoJSON();
            console.log(res);
            L.geoJSON(communesLGGeoJson, {
                onEachFeature: function (feature, layer) {
                    layer.bindTooltip(function (layer) {

                            for(var i = 0; i < res.length; i++)
                            {
                                if(feature.properties.id == res[i].id)
                                {
                                    return res[i].taux_lg+'%';
                                }
                            }
                            //merely sets the tooltip text
                        }, {permanent: true, direction:"bottom",className : 'm-toolTip'}  //then add your options
                    ).addTo(map_lg);
                },


                style: function(feature) {
                    //console.log('id commune geo : '+ feature.properties.id);
                    for(var i = 0; i < res.length; i++)
                    {
                        if(feature.properties.id == res[i].id)
                        {
                            return {color : "#000",fillColor: setColor(parseFloat(res[i].taux_lg)),opacity: 1,weight: 0.2} ;
                        }
                    }
                }
            }).addTo(map_lg);
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


$(document).ready(function() {
    // Tab initialization
    $( "#tabs_demande_lg" ).tabs({
        activate: function(event ,ui){
            map_lg.invalidateSize(true);
            map_lg.fitBounds(Communes_demande_lg_Layer.getBounds());

        }
    });
});