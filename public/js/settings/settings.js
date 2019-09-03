var usersTable;
var sessionTable;
var assocTable;
$(document).ready(function () {
    // USERS
    usersTable = $('#users_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        searching: false,
        bLengthChange : false,
        language: {
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="/images/loader/loader4.gif">'
        },

        ajax: {
            url: 'settings/users',
            type: 'GET',

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
            data: 'first_name',
            name: 'users.first_name',
            orderable: false,
            searchable: false,
            width : '2%'
            },
            {
                data: 'last_name',
                name: 'users.last_name',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'username',
                name: 'users.username',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'organisation',
                name: 'organisation',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                width : '2%'
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


    usersTable.on('draw', function () {
        $(".delete-user-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];
            var route = '/user/delete';
            deleteElement(route,id);
        });


        $(".edit-user-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];
            var route = '/settings/elementData/'+id;
            var model = 'user';
            var modalTitle = 'Modifier L\'utilisateur';
            getElementData(route,model,modalTitle);
        });


        $("#modal_submit_user").click(function()
        {
            $('.user-form').submit();
        });
    });



    // ASSOCIATION*************************

    assocTable = $('#associations_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        searching: false,
        bLengthChange : false,
        language: {
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="/images/loader/loader4.gif">'
        },

        ajax: {
            url: 'settings/associations',
            type: 'GET',

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
                data: 'nom_porteur_fr',
                name: 'assoc.nom_porteur_fr',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'nom_porteur_ar',
                name: 'assoc.nom_porteur_ar',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'adresse',
                name: 'assoc.adresse',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                width : '2%'
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

    assocTable.on('draw', function () {
        $(".delete-assoc-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];
            var route = '/porteur/delete_assoc';

            deleteElement(route,id);
        });


        $(".edit-assoc-btn").click(function()
        {

            var btn_id = this.id;
            var id = btn_id.split('_')[1];

            var route = '/settings/elementData/'+id;
            var model = 'assoc';
            var modalTitle = 'Modifier Les données de l\'association';
            getElementData(route,model,modalTitle);
        });
    });


    // SOURCE FINANCEMENT
    sourceTable = $('#sources_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        searching: false,
        bLengthChange : false,
        language: {
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="/images/loader/loader4.gif">'
        },

        ajax: {
            url: 'settings/sources',
            type: 'GET',

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
                data: 'source',
                name: 'sources.source',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'reference',
                name: 'sources.reference',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'montant_credit',
                name: 'sources.montant_credit',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'source',
                name: 'sources.source',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'source',
                name: 'sources.source',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                width : '2%'
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


    sourceTable.on('draw', function () {
        $(".delete-src-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];
            var route = '/source_financement/delete_src_setting';
            deleteElement(route,id);
        });


        $(".edit-src-btn").click(function()
        {

            var btn_id = this.id;
            var id = btn_id.split('_')[1];

            var route = '/settings/elementData/'+id;
            var model = 'src';
            var modalTitle = 'Modifier Les données de la source de financement';
            getElementData(route,model,modalTitle);
        });



    });


    // SESSIONS ****
    sessionTable = $('#sessions_datatables').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 10,
        bInfo : false,
        info : false,
        searching: false,
        bLengthChange : false,
        language: {
            url: 'http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json',
            processing: '<img src="/images/loader/loader4.gif">'
        },

        ajax: {
            url: 'settings/sessions',
            type: 'GET',

        },
        columnDefs: [{
            width: 20,
            targets: 1
        },
            {
                width: 30,
                targets: 2
            },
            {
                width: 300,
                targets: 3
            }
        ],
        columns: [
            {
                data: 'mois',
                name: 'sessions.mois',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'type',
                name: 'type',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'date',
                name: 'sessions.date',
                orderable: false,
                searchable: false,
                width : '2%'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                width : '2%'
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


    sessionTable.on('draw', function () {
        $(".delete-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];
            var route = '/session/delete';
            deleteElement(route,id);
        });

        $(".edit-session-btn").click(function()
        {
            var btn_id = this.id;
            var id = btn_id.split('_')[1];

            var route = '/settings/elementData/'+id;
            var model = 'session';
            var modalTitle = 'Modifier Les données de la session';
            getElementData(route,model,modalTitle);
        });
    });


});