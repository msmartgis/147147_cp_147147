

// MAPPING ********************

var osmUrl = 'https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map_projet_nombre = new L.Map('map_projet_nombre', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 15,zoomControl: false});


// or, add to an existing map:
map_projet_nombre.addControl(new L.Control.Fullscreen());

L.control.zoom({
    position:'topright'
}).addTo(map_projet_nombre);



// map layers changing
$("#hybrid_btn_projet").click(function () {
    $("#satellite_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#hybrid_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet active");
    $("#road_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#none_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_nombre);
});
$("#satellite_btn_projet").click(function () {
    $("#satellite_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet active");
    $("#hybrid_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet ");
    $("#road_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#none_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_nombre);
});
$("#road_btn_projet").click(function () {
    $("#satellite_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#hybrid_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet ");
    $("#road_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet active");
    $("#none_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_nombre);
});
$("#none_btn_projet").click(function () {
    $("#satellite_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#hybrid_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet ");
    $("#road_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet");
    $("#none_btn_projet")
        .removeClass()
        .addClass("baselayer_btn_projet active");
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
var Communes_projet_Layer = new L.GeoJSON.AJAX("/mapping/Communes.geojson",  {
    onEachFeature: function (feature, layer) {
        layer.bindTooltip(function (layer) {
                //console.log(feature);
                return layer.feature.properties.Nom; //merely sets the tooltip text
            }, {permanent: true, direction:"center",className : 'm-toolTip'}  //then add your options
        ).addTo(map_projet_nombre);
        layer.setStyle(communes_Style);
    }
});

Communes_projet_Layer.addTo(map_projet_nombre);


Communes_projet_Layer.on('data:loaded', function() {
    colorCommunesProjet();
});

$('#interventions_projet_filter,#annee_projet_filter,#moa_projet_filter,#programme_projet_filter').on('change', function (e) {


    var intervention = $("#interventions_projet_filter").val();
    var annee = $("#annee_projet_filter").val();
    var moa = $("#moa_projet_filter").val();
    var programme = $("#programme_projet_filter").val();
    colorCommunesProjet(intervention,annee,moa,programme);
});

function colorCommunesProjet(intervention,annee,moa,programme)
{
    $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: "/getProjetCommunesTaux",
        data : {
            intervention : intervention,
            moa : moa,
            programme : programme,
            annee : annee
        },
        success: function(res) {

            //Communes_Layer.clearLayers();
            var communesGeoJson = Communes_projet_Layer.toGeoJSON();


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
                    ).addTo(map_projet_nombre);
                },

                style: function(feature) {
                    //console.log('id commune geo : '+ feature.properties.id);
                    for(var i = 0; i < res.length; i++)
                    {
                        if(feature.properties.id == res[i].id)
                        {

                            return {color : "#000",fillColor: setColorProjet(parseFloat(res[i].taux)),opacity: 1,weight: 0.2} ;
                        }
                    }
                }
            }).addTo(map_projet_nombre);
        }
    });
}



//LONGEURS PROJET

var osmUrl = 'https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
    map_projet_lg = new L.Map('map_projet_lg', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 15,zoomControl: false});


// or, add to an existing map:
map_projet_lg.addControl(new L.Control.Fullscreen());

L.control.zoom({
    position:'topright'
}).addTo(map_projet_lg);



// map layers changing
$("#hybrid_btn_projet_lg").click(function () {
    $("#satellite_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#hybrid_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg active");
    $("#road_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#none_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_lg);
});
$("#satellite_btn_projet_lg").click(function () {
    $("#satellite_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg active");
    $("#hybrid_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg ");
    $("#road_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#none_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_lg);
});
$("#road_btn_projet_lg").click(function () {
    $("#satellite_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#hybrid_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg ");
    $("#road_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg active");
    $("#none_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    baselayer.remove();
    baselayer = L.tileLayer(
        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
            attribution: ""
        }
    ).addTo(map_projet_lg);
});
$("#none_btn_projet_lg").click(function () {
    $("#satellite_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#hybrid_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg ");
    $("#road_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg");
    $("#none_btn_projet_lg")
        .removeClass()
        .addClass("baselayer_btn_projet_lg active");
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
var Communes_projet_lg_Layer = new L.GeoJSON.AJAX("/mapping/Communes.geojson",  {
    onEachFeature: function (feature, layer) {
        layer.bindTooltip(function (layer) {
                //console.log(feature);
                return layer.feature.properties.Nom; //merely sets the tooltip text
            }, {permanent: true, direction:"center",className : 'm-toolTip'}  //then add your options
        ).addTo(map_projet_lg);
        layer.setStyle(communes_Style);
    }
});

Communes_projet_lg_Layer.addTo(map_projet_lg);


Communes_projet_lg_Layer.on('data:loaded', function() {
    colorCommunesProjet();
});

$('#interventions_projet_lg_filter,#annee_projet_lg_filter,#moa_projet_lg_filter,#programme_projet_lg_filter').on('change', function (e) {

    var intervention = $("#interventions_projet_lg_filter").val();
    var annee = $("#annee_projet_lg_filter").val();
    var moa = $("#moa_projet_lg_filter").val();
    var programme = $("#programme_projet_lg_filter").val();
    colorCommunesLGProjet(intervention,annee,moa,programme);
});

function colorCommunesLGProjet(intervention,annee,moa,programme)
{
    $.ajax({
        type: "GET",
        dataType: 'JSON',
        url: "/getProjetLGCommunesTaux",
        data : {
            intervention : intervention,
            moa : moa,
            programme : programme,
            annee : annee
        },
        success: function(res) {

            //Communes_Layer.clearLayers();
            var communesGeoJson = Communes_projet_lg_Layer.toGeoJSON();


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
                    ).addTo(map_projet_lg);
                },

                style: function(feature) {
                    //console.log('id commune geo : '+ feature.properties.id);
                    for(var i = 0; i < res.length; i++)
                    {
                        if(feature.properties.id == res[i].id)
                        {

                            return {color : "#000",fillColor: setColorProjet(parseFloat(res[i].taux)),opacity: 1,weight: 0.2} ;
                        }
                    }
                }
            }).addTo(map_projet_lg);
        }
    });
}

function setColorProjet(taux)
{

    if( taux <= 10)
    {
        return "#ffff00";
    }

    if(taux > 10 && taux <= 20)
    {
        return "#ebeb00";
    }

    if(taux > 20 && taux <= 30 )
    {
        return "#d8d800";
    }
    if(taux > 30 && taux <= 40 )
    {
        return "#c4c400";
    }
    if(taux > 40 && taux <= 50 )
    {
        return "#b1b100";
    }
    if(taux > 50 && taux <= 60 )
    {
        return "#9d9d00";
    }
    if(taux > 60 && taux <= 70 )
    {
        return "#898900";
    }
    if(taux > 70 && taux <= 80 )
    {
        return "#767600";
    }
    if(taux > 80 && taux <= 90)
    {
        return "#626200";
    }
    if(taux > 90 && taux <= 100 )
    {
        return "#4e4e00";
    }

}


$(document).ready(function() {
    // Tab initialization
    $( "#tabs_demande_projet" ).tabs({
        activate: function(event ,ui){
            map_projet_nombre.invalidateSize(true);
            map_projet_nombre.fitBounds(Communes_projet_Layer.getBounds());
        }
    });



    $( "#tabs_projet_lg" ).tabs({
        activate: function(event ,ui){
            map_projet_lg.invalidateSize(true);
            map_projet_lg.fitBounds(Communes_projet_lg_Layer.getBounds());
        }
    });
});