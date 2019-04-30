//LOADER IMAGE WHILE WAITING FOR AJAX RESPONSE
//point desservi

$(document).ready(function(){

//add piece
    var item_document = 1;
    $('#add_piece').click(function(){
        var markup = '<tr>' +
            '<td>' +
            '<div class="form-group">'+
            '<div class="checkbox">'+
            '<input type="checkbox" id="row_' + item_document + '" name="record">'+
            '<label for="row_' + item_document + '"></label>'+
            '</div>'+
            '</div>'+
            '</td>' +

            '<td>' +
            '<select class="form-control select2" style="width: 100%;" name="pieces_types[]" id="etat_selector">' +
            '<option value="cps" selected>CPS</option>' +
            '<option value="rc" >RC</option>' +
            '<option value="cps+rc" >CPS+RC</option>' +
            '<option value="bordereau_prix" >BORDEREAU DES PRIX</option>' +
            '<option value="avis_publication_fr" >AVIS DE PUBLICATION FR</option>' +
            '<option value="avis_publication_ar" >AVIS DE PUBLICATION AR</option>' +
            '<option value="en_preparation" >En péparation</option>' +
            ' </select>' +
            '</td>' +

            '<td>' +
            '<div class="form-group" style="text-align: center">' +
            '<input type="file" name="pieces_uploads[]">' +
            '</div>'+
            '</td>' +
            '';
        $('.table-piece tr:last').after(markup);
        item_document++;
    });

//delete piece
    $('.delete-row').click(function () {
        removeRowFromTable("pieces_tbody");
    });

});
function loading_image(id,div_response)
{
   $(document).ajaxStart(function () {
       $('.'+div_response).hide();
        $('#'+id).show();
    }).ajaxStop(function () {
        $('#'+id).hide();
       $('.'+div_response).show();
    });
}

//delete row from table
function removeRowFromTable(tableBody)
{

    $('#'+tableBody).find('input[name="record"]').each(function () {
        if ($(this).is(":checked")) {
            $(this).parents("tr").remove();
        }
    });
}

//row click datatables
function onRowClick(idRow,page)
{
    window.location.href = page+'/' + idRow + "/edit";
}


$(document).ready(function(){
    //currency mask
    $('.currency-input').priceFormat({
        prefix : '',
        thousandsSeparator : ',',
        centsLimit : 0
    });
});






















