//LOADER IMAGE WHILE WAITING FOR AJAX RESPONSE
//point desservi
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




















