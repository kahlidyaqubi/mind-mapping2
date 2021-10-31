$(function () {
    toastr.options.rtl = true;
    toastr.options = {
        "rtl": true,
        "positionClass": "toast-top-left",
        "closeButton": true,
    }
    $(".Confirm").click(function () {
        $("#kt_modal_1").modal("show");
        $("#kt_modal_1 .btn-danger").attr("href", $(this).attr("href"));
        return false;
    });

    $('form').submit(function () {
        $(this).find(':submit.btn-primary').attr('disabled', 'disabled');
        var wating = '<span id="wating" class="" >&nbsp;&nbsp;\n' +
            '                               <i class="fas fa-spinner fa-spin"></i>\n' +
            '                                </span>';
        $(this).find(':submit.btn-primary').append(wating);
    });
});
$(document).on('click', '.delete-img', function (event) {

    var _this = $(this);
    var action = _this.attr('href');
    event.preventDefault();
    bootbox.dialog({
        message: "Do you want for deleting? <span class=' label-danger'> can't return back</span>",
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

                                console.log(_this, _this.parent('.image-input'));
                                _this.parent('.image-input').remove();
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


var KTBootstrapSwitch = function () {

    // Private functions
    var demos = function () {
        // minimum setup
        $('[data-switch=true]').bootstrapSwitch();
    };

    return {
        // public functions
        init: function () {
            demos();
        },
    };
}();

function afterDatatable() {
    $("img").each(function () {
        if ($(this).attr('src') == '#')
            $(this).attr('src', 'https://mantenimientocode.xyz/images/not-found.jpg');
    });
    KTBootstrapSwitch.init();
    $('.select2').select2({});

};

function afterSubmit() {
    $(':submit').removeAttr('disabled');
    $('#wating').remove();
}

function numbersInput(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/^\+?\d*\.?\d*$/i);
    return pattern.test(value);
}

function integersInput(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/^\d+$/i);
    return pattern.test(value);
}

$(document).ready(function () {

    $('.select2').select2({});
    $(".numbers").bind('keypress', numbersInput);
    $(".integers").bind('keypress', integersInput);

    // Class definition

    KTBootstrapSwitch.init();


    $(".select2").select2();


});
