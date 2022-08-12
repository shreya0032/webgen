$(document).ready(function () {

    $('#employeelist').DataTable({
        processing: true,
        serverSide: true,
        rowReorder: true,
        ajax: {
            'url': 'employee-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },
        // "order": [
        //     [0, "asc"]
        // ],
        "columns": [
            {
                data: "checkbox",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
            },
            {
                data: "email"
            },
            {
                data: "phone"
            },
            {
                data: "company_name"
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]

    }).on('draw', function () {
        $('input[name="single_checkboxUser"]').each(function () {
            this.checked = false;
        })
        $('input[name="all_checkboxUser"]').prop('checked', false)
        $('button#deleteAllUser').addClass('d-none')
    });




    $('#rolelist').DataTable({
        processing: true,
        serverSide: true,
        "order": [
            [0, "asc"]
        ],
        ajax: {
            'url': 'role-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },
        "columns": [{
            data: "checkbox",
            orderable: false,
            searchable: false
        },
        {
            data: "name",
        },
        {
            data: 'action',
            name: 'actions',
            orderable: false,
            searchable: false
        }
        ]

    }).on('draw', function () {
        $('input[name="single_checkbox"]').each(function () {
            this.checked = false;
        })
        $('input[name="all_checkbox"]').prop('checked', false)
        $('button#deleteAll').addClass('d-none')
    });



    $('#permissionList').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': 'permission-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },

        "columns": [{
            data: "name",
        },
            // {
            //     data: 'action',
            //     name: 'actions',
            //     orderable: false,
            //     searchable: false
            // }
        ]

    });

    $('#companyList').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': 'company-list-ajax',
            'type': 'get'
        },

        "columns": [
        {
            data: "name",
        },
        {
            data: "email",
        },
        {
            data: "logo",
            name: "logo",
            "render": function (data, type, full, meta) {
                return "<img src=\"" + data + "\" height=\"50\"/>";
            }
        },
        {
            data: "website",
        },
        {
            data: 'action',
            name: 'actions',
            orderable: false,
            searchable: false
        }
        ]
    })


})
