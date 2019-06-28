//LOADER IMAGE WHILE WAITING FOR AJAX RESPONSE
//point desservi

$(document).ready(function(){



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


function loadingPopupData(id,div_response)
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



function modification_active(form_id,buttons_to_activate){
    $("#"+form_id+" :input").prop("disabled", false);
    $(buttons_to_activate).show();
    $("a").show();


    //notification
    $.toast({
        heading: 'Modification des données est activée',
        text: 'Il faut enregistrer chaque modification',
        position: 'top-right',
        loaderBg: '#ff0f0f',
        icon: 'info',
        hideAfter: 4000,
        stack: 6
    });
}






















