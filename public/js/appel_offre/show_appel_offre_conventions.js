var checkedelements=[];
$(document).ready(function () {

    var conventionAOTable;
    var checked_convention = 0;

    conventionAOTable = $('#appel_offre_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        bLengthChange : true,
        language: {
            processing: '<img src="/images/loader/loader_3.gif"  />',
            search: '',
            searchPlaceholder: 'Recherche...',
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
        },

        ajax: {
            url: '/conventions/showCoventionsAppelOffre',
            type: 'GET',
            data: function (d) {
                d.communes = $('select[name=communes]').val();
                //d.session = $('select[name=session]').val();
                d.interventions = $('select[name=interventions]').val();
                d.partenaires = $('select[name=partenaires]').val();
                d.localites = $('select[name=localites]').val();
                d.moas = $('select[name=moas]').val();
                d.programmes = $('select[name=programmes]').val();
                d.etat_versement_from = $('select[name=etat_versement_from]').val();
                d.etat_versement_to = $('select[name=etat_versement_to]').val();
            }

        },

        columns: [
            {
                data: 'checkbox',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                width: '1%'
            },

            {
                data: 'num_ordre',
                name: 'conventions.num_ordre',
                orderable: true,
                searchable: true,
                width: '1%'
            },
            {
                data: 'point_desservis',
                name: 'point_desservis.nom_fr',
                orderable: true,
                searchable: true,
                width: '15%'
            },
            {
                data: 'communes',
                name: 'communes.nom_fr',
                orderable: true,
                searchable: true,
                width: '15%'
            },

            {
                data: 'moas',
                name: 'moas.nom_fr',
                orderable: true,
                searchable: true,
                width: '10%'
            },
            {
                data: 'interventions',
                name: 'interventions.nom',
                orderable: true,
                searchable: true,
                width: '15%'
            },
            {
                data: 'partenaires',
                name: 'partenaires.nom_fr',
                orderable: true,
                searchable: true,
                width: '10%'
            },
            {
                data: 'programme',
                name: 'programme.nom_fr',
                orderable: true,
                searchable: true,
                width: '5%'
            },
            {
                data: 'montant_global',
                name: 'montant_global',
                orderable: true,
                searchable: true,
                width: '3%'
            },
            {
                data: 'montantCP',
                name: 'montantCP',
                orderable: true,
                searchable: true,
                width: '3%'
            },
            {
                data: 'montant_verse',
                name: 'montant_verse',
                orderable: true,
                searchable: true,
                width: '3%'
            },
            {
                data: 'etat_versement',
                name: 'etat_versement',
                orderable: true,
                searchable: true,
                width: '6%'
            }

        ],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });

    var montant_total = 0;
    var montant_cv = 0;
    var markup = '';

    conventionAOTable.on('draw', function () {
        for(i=0;i<checkedelements.length;i++)
        {
            $("#conventionCb_"+checkedelements[i].data('id')).prop('checked', true);
        }

        $('#appel_offre_datatables :input[type="checkbox"]').change(function() {
            montant_total = 0;
            if(this.checked) {
                checkedelements.push($(this));
            }
            else {
                checkedelements.splice(checkedelements.indexOf(this),1);
            }
            for(i=0;i<checkedelements.length;i++)
            {
                montant_cv = checkedelements[i].data('montant');
                montant_total += montant_cv;
                markup = '<input type="hidden" value='+checkedelements[i].data('id')+' name="conventions_ids[]">';
            }

            $('#montant_global_ao').val(montant_total);
            $('#list_conventions').append(markup);

        });
    } );


    $('#communes_filter,#intervention_filter,#partenaires_filter,#localites_filter,#programmes_filter,#moas_filter,#etat_versement_from,#etat_versement_to').on('change paste keyup', function (e) {
        suiviVersmentTable.draw();
        e.preventDefault();
    });
});
