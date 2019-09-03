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
            <div class=\"form-group\" style="margin-left: 15px;margin-top: 7px;">\
                <input type=\"file\" name="pieces_uploads[]"class=\"form-control\"  style="border : none;height: calc(1.5em + .75rem + 2px) !important;"/>\
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



