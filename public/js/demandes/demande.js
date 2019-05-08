

    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib}),
        map = new L.Map('map', {layers: [osm], center: new L.LatLng(29.504514364812469, -9.599814615107725), zoom: 10});



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
    var selectedPiste = null;
    var drawnItems = new L.FeatureGroup();
    var OldItems = new L.FeatureGroup();

    map.addLayer(drawnItems);
    map.addLayer(OldItems);


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
            featureGroup: drawnItems,
            draw: false,
            remove: false
        }
    });
    map.addControl(drawControl);

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

    var savePiste = L.easyButton({
        states: [{
            stateName: 'zoom-to-forest',        // name the state
            icon:      'fa-save',               // and define its properties
            title:     'Enregister piste',      // like its title
            onClick: function(btn, map) {
                storePistesDB();
                console.log(drawnItems.toGeoJSON());
            }
        }]
    });
    savePiste.addTo(map);

    $(document).ready(function () {
        getPistes();
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
            drawnItems.addLayer(e.layer);
        });
    });


    function getPistes() {
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/api/pistes",
            success: function(res) {
                console.log(res);
                /*
                for (i = 0; i < res.features.length; i++) {
                    res.features[i].geometry.coordinates = JSON.parse(res.features[i].geometry.coordinates);
                }

                L.geoJSON(res, {
                    onEachFeature: function(feature, layer) {
                        layer.setStyle(style1);
                        OldItems.addLayer(layer);
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
                map.fitBounds(OldItems.getBounds());
                */
            }
        });
    }

    function storePistesDB(){
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: "/api/pistes",
            success: function(res) {
                console.log(res);

            }
        });
    }

    /* // Set the title to show on the polygon button
     L.drawLocal.draw.toolbar.buttons.polygon = 'Draw a sexy polygon!';

     var drawControl = new L.Control.Draw({
     position: 'topright',
     draw: {
     polyline: false,
     polygon: false,
     circle: false,
     marker: true
     },
     edit: {
     featureGroup: drawnItems,
     remove: true
     }
     });
     map.addControl(drawControl);

     map.on(L.Draw.Event.CREATED, function (e) {
     var type = e.layerType,
     layer = e.layer;

     if (type === 'marker') {
     layer.bindPopup('A popup!');
     }

     drawnItems.addLayer(layer);
     }); */

    map.on(L.Draw.Event.EDITED, function (e) {
        var layers = e.layers;
        var countOfEditedLayers = 0;
        layers.eachLayer(function (layer) {
            countOfEditedLayers++;
        });
        console.log("Edited " + countOfEditedLayers + " layers");
    });

    /* L.DomUtil.get('changeColor').onclick = function () {
     drawControl.setDrawingOptions({rectangle: {shapeOptions: {color: '#004a80'}}});
     }; */

    L.DomUtil.get('saveChanges').onclick = function () {
        console.log(drawnItems.toGeoJSON());
    };



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
