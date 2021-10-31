$(document).ready(function () {
    var the_url = baseURL + "/surahs/surah-data";

    if ($("#surah_tbl").length) {

        var surah_tbl = $("#surah_tbl");
        surah_tbl.on('preXhr.dt', function (e, surahs, data) {
            data.name = $('#name_filter').val();
            data.type = $('#type_filter').val();
            data.page_number = $('#page_number_filter').val();
            data.is_active = $('#is_active_filter').val();
        }).dataTable({
            responsive: true,
            processing: true,
            serverSide: true,

            "ajax": {

                url: the_url
                , "dataSrc": function (json) {
                    //Make your callback here.
                    if (json.status != undefined && !json.status) {
                        $('#surah_tbl_processing').hide();
                        location.reload();
                        //
                    } else
                        return json.data;
                }
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'another_name', name: 'another_name'},
                {data: 'page_number', name: 'page_number'},
                {data: 'is_active', name: 'is_active'},
                {data: 'action', name: 'action'}
            ],
            language: {
                "sProcessing": "<img src='" + baseAssets + "/img/preloader.svg'>",
                "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Arabic.json"
            },

            fnDrawCallback: function () {
                //Initialize checkbos for enable/disable surah
                KTBootstrapSwitch.init();
            },
            searching:
                false,
            ordering:
                false,

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
                [[2, "asc"]],
            "initComplete":

                function (surahs, json) {
                    afterDatatable();
                }


        });
        $('#surah_tbl').on('change', '.make-switch.active', function (event, state) {
            // ... skipped ...
            var surah_id = $(this).data('id');

            $.ajax({
                url: baseURL + '/surahs/' + surah_id + '/active',
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
        // $('#surah_tbl').on('change', '.make-switch.open', function (event, state) {
        $('#surah_tbl').on('change', '.make-switch.verify', function (event, state) {
            // ... skipped ...
            var surah_id = $(this).data('id');

            $.ajax({
                url: baseURL + '/surahs/' + surah_id + '/verify',
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
        surah_tbl.api().ajax.reload();
    });
    $(document).on('click', '.filter-cancel', function () {

        $(".select2").val('').trigger('change');
        $(this).closest('.the_form').find('input:not([type=hidden]),select').val('');
        // $('#is_surah_confirm,.status').val('').trigger('change');
        surah_tbl.api().ajax.reload();
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
        var surah_name = _this.closest('tr').find("td:eq(1)").text();
        bootbox.dialog({
            message: "Do you want for deleting (" + surah_name + ")? <span class=' label-danger'> can't return back</span>",
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
                                    surah_tbl.api().ajax.reload();
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

                    if (surah_tbl != null && surah_tbl != undefined)
                        surah_tbl.api().ajax.reload();
                    $('#add-new').modal('hide');
                    $('#edit-new').modal('hide');
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
