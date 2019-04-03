
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



