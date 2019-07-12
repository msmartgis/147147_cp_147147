var res_piste = [];

var piste_features = [];
var oldPistes = [];
var pistesbounds;
var sidebar;
var osmUrl = 'https://www.google.com/maps/vt?lyrs=y@189&gl=cn&x={x}&y={y}&z={z}',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    baselayer = L.tileLayer(osmUrl, {maxZoom: 18, attribution: ''}),
    hybrid   = L.tileLayer('https://www.google.com/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {maxZoom: 18, attribution: ''}),
    road   = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18, attribution: ''}),
    map = new L.Map('map', {layers: [baselayer], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 15,zoomControl: false});

// or, add to an existing map:
//map.addControl(new L.Control.Fullscreen());


var baseMaps = {
    '<img src="/images/hybrid.png" id="hybrid_btn" class="m-layer-image">' : baselayer,
    '<img src="/images/satellite.png" id="satellite_btn" class="m-layer-image ">' : hybrid,
    '<img src="/images/road.png" id="satellite_btn" class="m-layer-image ">' : road
};

L.control.layers(baseMaps).addTo(map);

//easy button
//sidebar

var sidebar = L.control.sidebar('sidebar', {
    closeButton: true,
    position: 'left'
});
map.addControl(sidebar);
setTimeout(function () {
    sidebar.show();
}, 500);


map.on('click', function () {
    sidebar.hide();
})
var stateChangingButton = L.easyButton({
    states: [{
        stateName: 'zoom-to-forest',        // name the state
        icon:      '<img src="/images/svg/left-arrow.svg">',               // and define its properties
        title:     'Montrer la barre d\'outils',      // like its title
        onClick: function(btn, map) {       // and its callback

            btn.state('zoom-to-school');    // change state on click!
            sidebar.toggle();
        }
    }, {
        stateName: 'zoom-to-school',
        icon:      '<img src="/images/svg/right-arrow.svg">',
        title:     'Reduir la barre d\'outils',
        onClick: function(btn, map) {

            btn.state('zoom-to-forest');
            sidebar.toggle();
        }
    }]
});

stateChangingButton.addTo(map);

//la couleur pour les pistes
var default_color = '#fff';
var selection_color = 'yellow';
var selected = null;


var Pistes_Style = {
    color: "#F9A825",
    weight: 2,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#FF0000",
    dashArray: '2,3',
    zIndex : 1000001
};
var Limit_Style = {
    color: "#FF0000",
    weight: 4,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#FF0000"
};

var communes_Style = {
    color: "#000",
    weight: 2,
    opacity: 1,
    fillOpacity: 0.75,
    fillColor: "#CDCDCD",
    dashArray: '4,7',
    zIndex : 1000000
};


var RR_Style = {
    color: "#2979FF",
    weight: 2,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#2979FF",
    dashArray: '4,4'
};

var RP_Style = {
    color: "#2979FF",
    weight: 2,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#2979FF",
    dashArray: '4,4'
};

var RN_Style = {
    color: "#2979FF",
    weight: 2,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#2979FF",
    dashArray: '4,4'
};

var CP_Style = {
    color: "#2979FF",
    weight: 2,
    opacity: 1,
    fillOpacity: 0,
    fillColor: "#2979FF",
    dashArray: '4,4'
};


var Limit_province_Layer = new L.GeoJSON.AJAX("/mapping/Limite de la province.geojson", { style: Limit_Style, interactive: false });


var Communes_Layer = new L.GeoJSON.AJAX("/mapping/Communes.geojson", { style: communes_Style, interactive: false }, {
    onEachFeature: function (feature, layer) {

        layer.bindTooltip(feature.properties['Nom']);

    }
});
Communes_Layer.addTo(map);


//put douars in clusters
var douars_markers = L.markerClusterGroup();
var DouarsLayer = new L.GeoJSON.AJAX("/mapping/BD douars.geojson", {
    onEachFeature: function (feature, layer) {

        layer.bindPopup(feature.properties['Nom']).openTooltip();
        douars_markers.addLayer(layer);
    }
});

var Route_Nationales_Layer = new L.GeoJSON.AJAX("/mapping/Route Nationales.geojson", { style: RN_Style, interactive: false });
var Route_Regionales_Layer = new L.GeoJSON.AJAX("/mapping/Route Régionales.geojson", { style: RR_Style, interactive: false });
var Routes_Provinciales_Layer = new L.GeoJSON.AJAX("/mapping/Routes Provinciales.geojson", { style: RP_Style, interactive: false });

var Convention_CP_METL_Layer = new L.GeoJSON.AJAX("/mapping/Convention CP_METL.geojson", { style: CP_Style, interactive: false });

Route_Nationales_Layer.addTo(map);
Route_Regionales_Layer.addTo(map);
Routes_Provinciales_Layer.addTo(map);

Convention_CP_METL_Layer.addTo(map);

DouarsLayer.addTo(map);
DouarsLayer.remove();
map.addLayer(douars_markers);



// fit bounds
Limit_province_Layer.addTo(map);

Limit_province_Layer.on('data:loaded', function() {
    map.fitBounds(Limit_province_Layer.getBounds());
});

map.on('layeradd', function() {

    Communes_Layer.bringToBack();

});






var limit_visible = true;
var pistes_visible = true;
var communes_visible = true;
var douars_visible = true;

var RR_visible = true;
var RN_visible = true;
var RP_visible = true;
var CP_visible = true;

$.ajax({
    url: "/getpistesCarto",
    type: 'get',
    dataType: 'json',
    success: function (res) {
        res_piste = res.pistes;
        var convention_programme = [];
        var piste_cnv_demande = {};
        var piste_cnv_demande_array  = [];
        for(var i = 0 ; i< res_piste.length ; i++)
        {
            piste_cnv_demande.piste_id = res.pistes[i].id;
            piste_cnv_demande.cnv_id = res.pistes[i].convention_id;
            piste_cnv_demande.demande_id = res.pistes[i].demande_id;
            piste_cnv_demande_array.push(piste_cnv_demande);
        }

        var conventions = res.conventions;
        var demandes = res.demandes;

        Pistes = res;
        for(i = 0 ; i < res.pistes.length ; i++)
        {
            piste_features.push(JSON.parse(res.pistes[i].geometry));
        }

        for(i = 0 ; i < piste_features.length ; i++)
        {
            oldPistes.push(piste_features[i].features[0]);
        }

        var style = {
            "color": "#ff7800",
            "weight": 5,
            "opacity": 0.65
        };

        pistesbounds =  L.geoJSON(oldPistes, {
            style: function(feature) {
                switch (feature.properties.type) {
                    case 'demande': return {color: "#4c9505"};
                    case 'convention':   return {color: "#ff6b10"};
                    case 'projet':   return {color: "#ffd80e"};
                }
            },
            onEachFeature: function(feature,layer){
                for(var i = 0 ; i < res_piste.length ; i++)
                {
                    if( res_piste[i].id == feature.properties.id_piste )
                    {
                        for(var j = 0; j < conventions.length ; j++)
                        {
                            var interventions = [];
                            if(conventions[j].id == res_piste[i].convention_id)
                            {
                                for(var z = 0; z < conventions[j].interventions.length ; z++)
                                {
                                    interventions.push(conventions[j].interventions[z].id);
                                }
                                layer.programme = conventions[j].programme.id;
                                layer.moa = conventions[j].moas.id;
                                layer.interventions = interventions;
                            }
                        }
                    }
                }

                //filters
                $('#donnees_filter,#etat_filter,#programme_filter,#intervention_filter,#moa_filter').change(function() {
                    var value = $(this).val();
                    var name = $(this).attr('name');
                    if(name == 'programme')
                    {
                        if(layer.programme != value)
                        {
                            layer.remove();
                        }else{
                            layer.addTo(map);
                        }
                    }

                    if(name == 'moa')
                    {
                        if(layer.moa != value)
                        {
                            layer.remove();
                        }else{
                            layer.addTo(map);
                        }
                    }

                    if(name == 'intervention')
                    {
                        var array_inter = [];
                        if(layer.interventions != null)
                        {
                            var array_inter = layer.interventions.slice();
                            if(array_inter.includes(value))
                            {
                                layer.addTo(map);

                            }else{
                                layer.remove();
                            }
                        }
                    }

                    if(name == 'donnees')
                    {
                        if(value == 'demande')
                        {
                            $('#etat_filter,#moa_filter,#programme_filter').prop('disabled', 'disabled');
                            if(layer.feature.properties.type == 'demande')
                            {
                                layer.addTo(map);
                            }else{

                                layer.remove();
                            }
                        }

                        if(value == 'projet')
                        {
                            $('#etat_filter,#moa_filter,#programme_filter').prop('disabled', false);
                            if(layer.feature.properties.type == 'convention' || layer.feature.properties.type == 'projet')
                            {
                                layer.addTo(map);
                            }else{

                                layer.remove();
                            }
                        }
                        if(value == 'all')
                        {
                            layer.addTo(map);
                        }
                    }
                });


                layer.on('click',function(){
                    var piste_id = feature.properties.id_piste;
                    $.ajax({
                        type: "GET",
                        dataType: 'html',
                        url: "/getPisteDataHtml",
                        data : {
                            piste_id : piste_id
                        },
                        success: function(res) {
                            layer.bindPopup(res);
                        }
                    });
                });
            }
        }).addTo(map);
    }
});


$('.couches_checkbox').change(function() {
    if($(this).is(":checked")) {
        var  id = $(this).attr('id');
        var checked = 1;

        if(id == 'pistes_cbx')
        {
            pistesbounds.addTo(map);
        }
        checkbox_couches(id,checked);
    }

    if(!$(this).is(":checked")) {
        var  id = $(this).attr('id');
        var checked = 0;

        if(id == 'pistes_cbx')
        {
            pistesbounds.remove();
        }
        checkbox_couches(id,checked);
    }
});


function checkbox_couches(id,checked)
{
    if(id == 'localite_cbx')
    {
        if(checked == 0)
        {
            douars_markers.remove();
        }else{
            douars_markers.addTo(map);
        }
    }


    if(id == 'rt_national_cbx')
    {
        if(checked == 0)
        {
            Route_Nationales_Layer.remove();
        }else{
            Route_Nationales_Layer.addTo(map);
        }
    }

    if(id == 'communes_cbx')
    {
        if(checked == 0)
        {
            Communes_Layer.remove();
        }else{
            Communes_Layer.addTo(map);
        }
    }

    if(id == 'rt_regional_cbx')
    {
        if(checked == 0)
        {
            Route_Regionales_Layer.remove();
        }else{
            Route_Regionales_Layer.addTo(map);
        }
    }

    if(id == 'rt_provincial_cbx')
    {
        if(checked == 0)
        {
            Routes_Provinciales_Layer.remove();
        }else{
            Routes_Provinciales_Layer.addTo(map);
        }
    }
}




