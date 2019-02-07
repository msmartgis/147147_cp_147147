//add new parentaire
var item = 0;
$("#add_partner").click(function (event) {
    if ($('#montant_g').val() == "") {
        event.stopPropagation();
    } else {
        $('#m-add-partenaire').modal("show");
    }
});

//item to make id checkbox unique
$("#add_partner_to_list").click(function () {
    var montant_g = $('#montant_g').val();
    var partenair_type_text = $("#partenaire_type :selected").text();
    var partenair_type_id = $("#partenaire_type").val();
    //alert('id : ' + partenair_type_id + 'text : ' + partenair_type_text);
    var montant_partnenaire = $("#montant_partnenaire").val();
    //console.log(montant_partnenaire);
    var markup = '<tr>\
                        <td style=\'text-align:center\'>\
                        <div class=\"form-group\">\
                            <div class=\"checkbox\">\
                                <input type=\"checkbox\" id=\"row_' + item + '\" name=\"record\">\
                                <label for="row_' + item + '"></label>\
                            </div>\
                        </div>\
                        </td>\
                        <td style = \'text-align:center\'><input type="hidden" name="partnenaire_type_ids[]" value="' + partenair_type_id + '">' + partenair_type_text + '</td>\
                        <td style=\'text-align:center\'><input type="hidden" name="montant[]" value="' + montant_partnenaire + '">' + montant_partnenaire + '</td>\
                        <td style=\'text-align:center\'><input type="hidden" name="pourcentage[]" value="' + (montant_partnenaire / montant_g) * 100 + '">' + (montant_partnenaire / montant_g) * 100 + '</td>\
                    </tr>';
    //$("#table_body_partner").append(markup);
    $('#table_body_partner > tr:first').before(markup);
    //markup.prependTo("#table_body_partner");
    $("#montant_partnenaire").val('');
    $("#m-add-partenaire").modal('toggle');
    item++;

});
$(".delete-row").click(function () {
    $("#table_body_partner").find('input[name="record"]').each(function () {
        if ($(this).is(":checked")) {
            $(this).parents("tr").remove();
        }
    });
});
