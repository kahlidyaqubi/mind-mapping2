$(document).ready(function () {
    var the_url = baseURL + "/maps/" + surah_id + "/map-data";
    if ($("#part_tbl").length) {

        var part_tbl = $("#part_tbl");
        part_tbl.on('preXhr.dt', function (e, parts, data) {
            data.is_active = $('#is_active_filter').val();
            data.name = $('#name').val();
        }).dataTable({
            responsive: true,
            processing: true,
            serverSide: false,

            "ajax": {

                url: the_url
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#part_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'childes_count', name: 'childes_count'},
                {data: 'image', name: 'image'},
                {data: 'name', name: 'name'},
                {data: 'video', name: 'video'},
                {data: 'video2', name: 'video2'},
                {data: 'parent_id', name: 'parent_id'},
                {data: 'number', name: 'number'},
                {data: 'form_verse', name: 'form_verse'},
                {data: 'to_verse', name: 'to_verse'},
                {data: 'is_active', name: 'is_active'},
                {data: 'action', name: 'action'},
                {data: 'sub_map', name: 'sub_map'},
            ],
            language: {
                "sProcessing": "<img src='" + baseAssets + "/img/preloader.svg'>",
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            },

            fnDrawCallback: function () {
                //Initialize checkbos for enable/disable part
                KTBootstrapSwitch.init();
            },
            searching:
                false,
            ordering:
                true,

            bStateSave:
                !0,
            lengthMenu:
                [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"]],
            pageLength:
                10,
            // pagingType:
            //     "bootstrap_full_number",
            columnDefs:
                [{orderable: !1, targets: [0]}, {searchable: !1, targets: [0]}, {className: "dt-right"}],
            order:
                [[6, "asc"]],
            "initComplete":

                function (parts, json) {
                    afterDatatable();
                }


        });
        $('#part_tbl').on('change', '.make-switch.active', function (event, state) {
            // ... skipped ...
            var part_id = $(this).data('id');

            $.ajax({
                url: baseURL + '/maps/' + part_id + '/active',
                type: 'PUT',
                dataType: 'json',
                data: {'_token': csrf_token},
                success: function (data) {

                    if (data.status) {
                        toastr['success'](data.message, '');
                    } else {
                        toastr['error'](data.message);
                    }

                }
            });

        });
        // $('#part_tbl').on('change', '.make-switch.open', function (event, state) {
        $('#part_tbl').on('change', '.make-switch.verify', function (event, state) {
            // ... skipped ...
            var part_id = $(this).data('id');

            $.ajax({
                url: baseURL + '/maps/' + part_id + '/verify',
                type: 'PUT',
                dataType: 'json',
                data: {'_token': csrf_token},
                success: function (data) {

                    if (data.status) {
                        toastr['success'](data.message, '');
                    } else {
                        toastr['error'](data.message);
                    }

                }
            });

        });

    }


    $(document).on("click", ".filter-submit", function () {
        part_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('.the_form').find('input:not([type=hidden]),select').val('');
        // $('#is_part_confirm,.status').val('').trigger('change');
        part_tbl.api().ajax.reload();
    });

    $(document).on('click', '.add-new-mdl', function (e) {
        e.preventDefault();
        $("#wait_msg,#overlay").show();
        var action = $(this).attr('href');

        $.ajax({
            url: action,
            type: 'GET',
            //  dataType: 'json',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#results-modals .modal').modal('show', {backdrop: 'static', keyboard: false});
                if (data.message) {
                    toastr['error'](data.message);
                }
            }, error: function (xhr) {

            }, complete: function (data) {
                afterDatatable();
            }
        });
    });
    $(document).on('click', '.edit-new-mdl', function (e) {
        $("#wait_msg,#overlay").show();
        e.preventDefault();
        var action = $(this).attr('href');
        $.ajax({
            url: action,
            type: 'GET',
            //  dataType: 'json',
            success: function (data) {
                $("#wait_msg,#overlay").hide();

                $('#results-modals').html(data);
                $('#results-modals .modal').modal('show', {backdrop: 'static', keyboard: false});
                if (data.message) {
                    toastr['error'](data.message);
                }
            }, error: function (xhr) {

            }, complete: function (data) {
                afterDatatable();
            }
        });
    });
    $(document).on('click', '.delete', function (event) {

        var _this = $(this);
        var action = _this.attr('href');
        event.preventDefault();
        var part_name = _this.closest('tr').find("td:eq(3)").text();
        bootbox.dialog({
            message: "Do you want for deleting (" + part_name + ")? <span class=' label-danger'> can't return back</span>",
            title: "Deletion Confirm!",
            buttons: {

                main: {
                    label: 'Sure <i class="fa fa-check"></i> ',
                    className: "btn-primary",
                    callback: function () {
                        //do something else
                        $.ajax({
                            url: action,
                            type: 'POST',
                            dataType: 'json',
                            data: {'_method': 'delete', _token: csrf_token},
                            success: function (data) {

                                if (data.status) {
                                    toastr['success'](data.message, '');
                                    part_tbl.api().ajax.reload();
                                } else {
                                    toastr['error'](data.message);
                                }
                            },
                            error:
                                function (xhr, status, error) {
                                    var err = eval("(" + xhr.responseText + ")");
                                    toastr['error'](err.message);
                                }
                        });
                    }
                }, danger: {
                    label: 'Close <i class="fa fa-remove"></i>',
                    className: "btn-danger",
                    callback: function () {
                        //do something
                        bootbox.hideAll()
                    }
                }
            }
        });


    });
    $(document).on('submit', '#formAdd,#formEdit', function (event) {

        var _this = $(this);
        // var loader = '<i class="fa fa-spinner fa-spin"></i>';
        _this.find('.btn.save i').addClass('fa-spinner fa-spin');
        event.preventDefault(); // Totally stop stuff happening
        // START A LOADING SPINNER HERE
        // Create a formdata object and add the files

        var formData = new FormData($(this)[0]);

        var action = $(this).attr('action');
        var method = $(this).attr('method');

        $.ajax({
            url: action,
            type: method,
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {

                if (data.status) {

                    $('.alert').hide();
                    toastr['success'](data.message, '');

                    if (part_tbl != null && part_tbl != undefined)
                        part_tbl.api().ajax.reload();

                    $('#formAdd').parents('.modal').modal('hide');
                    $('#formEdit').parents('.modal').modal('hide');
                    // if (event.target.id == 'formAdd') {
                    //     empty_frm(event.target);
                    // }
                } else {
                    var $errors = '<strong>' + data.message + '</strong>';
                    $errors += '<ul>';
                    $.each(data.items, function (i, v) {
                        $errors += '<li>' + v.message + '</li>';
                    });
                    $errors += '</ul>';
                    $('.alert').show();
                    $('.alert').html($errors);
                    toastr['error']($errors);
                }
                _this.find('.btn.save i').removeClass('fa-spinner fa-spin');
                // _this.find('.fa-spin').hide();

            },
            error:
                function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    $('.alert').show();
                    $('.alert').html(err.message);
                    toastr['error'](err.message);
                },
            complete: function (data) {
                afterSubmit();
            },
        });
    });

});
