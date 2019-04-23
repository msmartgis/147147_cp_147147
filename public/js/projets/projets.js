$(document).ready(function(){
    //image guallery
    const current = document.querySelector('#current');
    const imgs = document.querySelector('.imgs');
    const img = document.querySelectorAll('.imgs img');
    const opacity = 0.6;

// Set first img opacity
    img[0].style.opacity = opacity;

    imgs.addEventListener('click', imgClick);

    function imgClick(e) {
        // Reset the opacity
        img.forEach(img => (img.style.opacity = 1));

        // Change current image to src of clicked image
        //alert(e.target.src.replace('thumbnail/',''));

        current.src = e.target.src.replace('thumbnail/','');
        // Add fade in class
        current.classList.add('fade-in');
        // Remove fade-in class after .5 seconds
        setTimeout(() => current.classList.remove('fade-in'), 500);
        // Change the opacity to opacity var
        e.target.style.opacity = opacity;
    }


    //delete image from gallery
    $('.main-img-download').on('click',function(){
        var filenam = $('#current').attr('src').split('/');

        var path = filenam[filenam.length - 1];
        var conventionID = filenam[filenam.length - 2];
        var  link = '/files/download/galleries_part/'+conventionID+'/'+path;

         $('.main-img-download').attr('href',link);

    });


    //add piece
    $('.form-ulpoad-piece').on('submit', function (e) {
        $form = $(this);
        e.preventDefault();
        var markup = '';
        url = $form.attr('action');
        type = $form.attr('method');
        $.ajax({
            'type': type,
            'url': url,
            'data': new FormData(this),
            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                markup =
                    "<tr style='text-align: center'>\
                        <td>" + data.type + "</td>\
                        <td>" + data.path + "</td>\
                        <td style='text-align: center'>\
                            <button class='btn btn-secondary-table ' data-id='" + data.id + "'><i class='fa fa-download'></i> Telecharger</button>\
                        </td>\
                        <td style='text-align: center'>\
                            <button class='btn btn-warning delete-piece' data-id='" + data.id + "'><i class='fa fa-close'></i> Supprimer</button>\
                        </td>\
                        </tr>";
                $(markup).appendTo("#pieces_tbody");
                $('#add_modal_piece').modal('hide');
            }
        });
    });



    // add etat
    $('.form-add-etat').on('submit', function (e) {
        $form = $(this);
        e.preventDefault();
        var markup = '';
        url = $form.attr('action');
        type = $form.attr('method');
        $.ajax({
            'type': type,
            'url': url,
            'data': new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var nom = '';
                switch(data.nom) {
                    case 'programme':
                        nom= 'Programmé'
                        break;
                    case 'en_cours_execution':
                        nom= 'En cours d\'execution'
                        break;
                    case 'a.o_pulie':
                        nom= 'A.O Publi'
                        break;
                    case 'plis_ouvert':
                        nom= 'Plis ouvert'
                        break;
                    case 'a.o_attribue':
                        nom= 'A.O Attribué'
                        break;
                    case 'a.o_reporte':
                        nom= 'A.O Reporté'
                        break;
                    case 'a.o_annule':
                        nom= 'A.O Annule'
                        break;
                    case 'en_retard':
                        nom=  'En retard'
                        break;
                    case 'en_etat_arret':
                        nom= 'En état d\'arrêt'
                        break;
                    case 'realise':
                        nom= 'Réalisé'
                        break;
                }
                markup =
                    '<tr>' +
                    '<td style="text-align: center">' +
                    nom +
                    '</td>' +
                    '<td style="text-align: center">' +
                    data.date +
                    '</td>' +
                    '<td style="text-align: center">' +
                    '<button class="btn btn-danger-table delete-etat" data-id="etat_' + data.id + '"><i class="fa fa-close"></i> Supprimer</button>' +
                    '</tr>' +
                    '' +
                    '';


                $(markup).appendTo("#etat_tbody");
                $('#add_modal_etat').modal('hide');
            }
        });
    });


    //add partenaire
    $('.form-add-partenaire-edit').on('submit', function (e) {
        $form = $(this);
        e.preventDefault();
        var markup = '';
        url = $form.attr('action');
        type = $form.attr('method');
        $.ajax({
            'type': type,
            'url': url,
            'data': new FormData(this),
            // Tell jQuery not to process data or worry about content-type
            // You *must* include these options!
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                markup =
                    "<tr style='text-align: center'>\
                        <td>" + data.part.nom_fr + "</td>\
                        <td>" + data.montant + "</td>\
                        <td>" + data.pourcentage + "</td>\
                        <td style='text-align: center'>\
                            <button type='button' class='btn btn-warning-table delete-partenaire' data-demande'" + data.demande + "' data-partnaire='" + data.id + "'><i class='fa fa-close'></i> Supprimer</button>\
                        </td>\
                        </tr>";
                $(markup).prependTo("#partenaire_tbody");
                $('#m-add-partenaire-edit').modal('hide');
            }
        });
    });




});