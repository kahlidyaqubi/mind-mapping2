
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{assets_url()}}/plugins/global/plugins.bundle.js"></script>
<script src="{{assets_url()}}/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="{{assets_url()}}/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{assets_url()}}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
{{--<script src="{{assets_url()}}/js/pages/widgets.js"></script>--}}
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };</script>
<script src="{{assets_url()}}/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="{{assets_url()}}/js/pages/crud/datatables/advanced/column-rendering.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/bootstrap-switch.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/select2.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/bootstrap-timepicker.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js"></script>
{{--<script src="{{assets_url()}}/js/pages/crud/file-upload/image-input.js"></script>--}}
{{--<script src="{{assets_url()}}/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>--}}


<script src="{{assets_url()}}/js/main.js" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/app-js/app.js')}}"></script>
<script>
    var baseURL = '{{url(admin_vw())}}';
    var baseAssets = '{{url('assets')}}';
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
</script>
<script>

    $(document).ready(function () {
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        var userId = $('meta[name="userId"]').attr('content');

        Echo.private('App.Models.Admin.' + userId).notification((notification) => {
            var log = notification.data.log;
            var link = notification.data.link;
            var the_id = notification.id;
            var div = document.createElement("div");
            div.innerHTML = " <div class=\"d-flex align-items-center bg-light-warning rounded p-5 gutter-b\">\n" +
                "\t\t\t\t\t\t<span class=\"svg-icon svg-icon-warning mr-5\">\n" +
                "\t\t\t\t\t\t\t<span class=\"svg-icon svg-icon-lg\">\n" +
                "                                <i class=" + log['permission']['icon'] + "></i>\n" +
                "                                <!--end::Svg Icon-->\n" +
                "\t\t\t\t\t\t\t</span>\n" +
                "\t\t\t\t\t\t</span>\n" +
                "                                    <div class=\"d-flex flex-column flex-grow-1 mr-2\">\n" +
                "                                        <a onclick=\"javascript:pop(this);\"\n" +
                "                                            href=" + link + " " +
                "                                           the_id=" + the_id + "\n" +
                "                                           class=\"font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1\">" + log['permission']['title'] + "</a>\n" +
                "                                        <span class=\"text-muted font-size-sm\">" + formatDate(log['created_at']) + "</span>\n" +
                "                                    </div>\n" +
                "                                    <span class=\"font-weight-bolder text-warning py-1 font-size-lg\">" + log['logable']['name'] + "</span>\n" +
                "                                </div>\n" +
                "                               ";
            console.log(div);
            document.getElementById("notif").prepend(div);
            var num_notif = document.querySelectorAll(".count-noti");
            var num_notif_count = 1 + parseInt(document.querySelector(".count-noti").innerText);
            for (i = 0; i < num_notif.length; i++) {
                num_notif[i].innerHTML = "<span>" + num_notif_count + "</span>";
            }
        });


    });

    function pop(e) {
        event.preventDefault();
        var the_id = e.getAttribute('the_id');
        var the_href = e.href;
        $.get('/admin/notifications/' + the_id + '/read', function (data, status) {
        });
        location.href = the_href;
    };
</script>

<!--end::Page Scripts-->
@yield('js')
