$(document).ready(function(){
    getUsers();
    var user_id;

   /* $( "#users_table tbody" ).on( "click", ".user-btn", function() {
        user_id = ($(this).data('id'));
        getuserData(user_id);
        $('.edit_modal_user').modal('show');
    });*/


    function getUsers()
    {
        $.ajax({
            url: '/profile/getUsersData',
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                console.log(data);
                //$('#result_users_data').append(data);
            }
        });
    }


    /*function getuserData(id)
    {
        $.ajax({
            url: 'profile/getUserData',
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}',
                id : id
            },
            dataType: 'JSON',
            success: function (data) {
                $('#modal_title_edit').text('Modifier : '+data['username']);
                $('#username_input').val(data['username']);
                $('#responsabilite_input').val(data['responsablite']);
                $('#departement_input').val(data['departement']);
            }
        });
    }*/

});