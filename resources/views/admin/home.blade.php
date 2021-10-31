@extends(admin_layout_vw().'.index')
@section('css')
    <style>
        #chartdiv {
            width: 100%;
            height: 5000px;
        }

        g text {
            transform: matrix(1, 0, 0, 1, 24, 0);
        }
    </style>
@endsection
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div
                    class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">لوحة التحكم </h5>
                    <!--end::Page Title-->
                    <!--begin::Actions-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                    <span class="text-muted font-weight-bold mr-4">#XRS-45670</span>
                {{--<a href="#" class="btn btn-light-warning font-weight-bolder btn-sm">Add New</a>--}}
                <!--end::Actions-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->

                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Dashboard-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-4">
                        <!--begin::Stats Widget 11-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div
                                        class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
													<span class="symbol symbol-50 symbol-light-success mr-2">
														<span class="symbol-label">
															<span class="svg-icon svg-icon-xl svg-icon-success">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
																  <svg xmlns="http://www.w3.org/2000/svg"
                                                                       xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                       width="24px"
                                                                       height="24px"
                                                                       viewBox="0 0 24 24"
                                                                       version="1.1"><g
                                                                              stroke="none"
                                                                              stroke-width="1"
                                                                              fill="none"
                                                                              fill-rule="evenodd">
																		<polygon points="0 0 24 0 24 24 0 24"/>
																		<path
                                                                                d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                                fill="#000000" fill-rule="nonzero"
                                                                                opacity="0.3"/>
																		<path
                                                                                d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                                fill="#000000" fill-rule="nonzero"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
													</span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{\App\Models\User::whereNotNull('created_at')->count()}}</span>
                                        <span class="text-muted font-weight-bold mt-2">عدد المستخدمين</span>
                                    </div>
                                </div>
                                <div id="kt_users_chart" class="card-rounded-bottom"
                                     data-color="success" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 11-->
                    </div>
                    <div class="col-lg-4">
                        <!--begin::Stats Widget 12-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div
                                        class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
													<span class="symbol symbol-50 symbol-light-primary mr-2">
														<span class="symbol-label">
															<span class="svg-icon svg-icon-xl svg-icon-primary">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             width="24px" height="24px"
                                                                             viewBox="0 0 24 24"
                                                                             version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<rect fill="#000000" x="4" y="4" width="7"
                                                                              height="7" rx="1.5"/>
																		<path
                                                                                d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                                                fill="#000000" opacity="0.3"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
													</span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{\App\Models\Part::count()}}</span>
                                        <span class="text-muted font-weight-bold mt-2">العدد الكلي للخرائط</span>
                                    </div>
                                </div>
                                <div id="kt_maps_chart_2" class="card-rounded-bottom"
                                     data-color="primary" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 12-->
                    </div>
                    <div class="col-lg-4">
                        <!--begin::Stats Widget 12-->
                        <div class="card card-custom card-stretch card-stretch-half gutter-b">
                            <!--begin::Body-->
                            <div class="card-body p-0">
                                <div
                                        class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
													<span class="symbol symbol-50 symbol-light-primary mr-2">
														<span class="symbol-label">
															<span class="svg-icon svg-icon-xl svg-icon-primary">
																<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             width="24px" height="24px"
                                                                             viewBox="0 0 24 24"
                                                                             version="1.1">
																	<g stroke="none" stroke-width="1" fill="none"
                                                                       fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24"/>
																		<rect fill="#000000" x="4" y="4" width="7"
                                                                              height="7" rx="1.5"/>
																		<path
                                                                                d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                                                fill="#000000" opacity="0.3"/>
																	</g>
																</svg>
                                                                <!--end::Svg Icon-->
															</span>
														</span>
													</span>
                                    <div class="d-flex flex-column text-right">
                                        <span class="text-dark-75 font-weight-bolder font-size-h3">{{\App\Models\Part::whereNull('parent_id')->count()}}</span>
                                        <span class="text-muted font-weight-bold mt-2">عدد الخرائط الرئيسية</span>
                                    </div>
                                </div>
                                <div id="kt_maps_chart" class="card-rounded-bottom"
                                     data-color="primary" style="height: 150px"></div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Stats Widget 12-->
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chartdiv"></div>
                            </div>

                        </div>

                    </div>
                </div>
                <!--end::Row-->
                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

@stop
@php

    $months = ['January'=>0,'February'=>0,'March'=>0,'April'=>0,'May'=>0,'June'=>0,'July'=>0,'August'=>0,'September'=>0,'October'=>0,'November'=>0,'December'=>0];
       /**maps**/
        $last_year= \App\Models\Part::whereNull('parent_id')->orderByDesc('created_at')->first()->year;
        $last_maps = \App\Models\Part::whereNull('parent_id')->whereYear('created_at', '=', $last_year);
        $maps = $last_maps->selectRaw("count(*) as count,date_format(created_at, '%M') month")
        ->groupBy('month')->pluck('count','month')->toArray();
        $maps_charts =array_values(filterByFileKeyWithOutDelete($maps,$months));
        /*2*/
        $last_year_2= \App\Models\Part::orderByDesc('created_at')->first()->year;
         $last_maps_2 = \App\Models\Part::whereYear('created_at', '=', $last_year_2);
        $maps_2 = $last_maps_2->selectRaw("count(*) as count,date_format(created_at, '%M') month")
        ->groupBy('month')->pluck('count','month')->toArray();
        $maps_charts_2 =array_values(filterByFileKeyWithOutDelete($maps_2,$months));
/**users**/
        $last_year= \App\Models\User::orderByDesc('created_at')->first()->year;
        $last_users = \App\Models\User::whereYear('created_at', '=', $last_year);
        $users = $last_users->selectRaw("count(*) as count,date_format(created_at, '%M') month")
        ->groupBy('month')->pluck('count','month')->toArray();
        $users_charts =array_values(filterByFileKeyWithOutDelete($users,$months));
/*surah_maps*/
       $surah_maps_charts=  \App\Models\Surah::select('name as surha')->withcount('rootParts as maps_count')->get();

@endphp

@section('js')
    <script>

        function _initMaps() {
            var element = document.getElementById("kt_maps_chart");

            var height = parseInt(KTUtil.css(element, 'height'));
            var color = KTUtil.hasAttr(element, 'data-color') ? KTUtil.attr(element, 'data-color') : 'success';

            if (!element) {
                return;
            }
            var maps_charts = @json($maps_charts);
            var options = {
                series: [{
                    name: 'Map',
                    data: maps_charts,
                }],
                chart: {
                    type: 'area',
                    height: 150,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [KTApp.getSettings()['colors']['theme']['base'][color]]
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTApp.getSettings()['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 55,
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                markers: {
                    colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                    strokeColor: [KTApp.getSettings()['colors']['theme']['base'][color]],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        }

        function _initMaps2() {
            var element = document.getElementById("kt_maps_chart_2");

            var height = parseInt(KTUtil.css(element, 'height'));
            var color = KTUtil.hasAttr(element, 'data-color') ? KTUtil.attr(element, 'data-color') : 'success';

            if (!element) {
                return;
            }
            var maps_charts = @json($maps_charts_2);
            var options = {
                series: [{
                    name: 'Map',
                    data: maps_charts,
                }],
                chart: {
                    type: 'area',
                    height: 150,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [KTApp.getSettings()['colors']['theme']['base'][color]]
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTApp.getSettings()['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 55,
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                markers: {
                    colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                    strokeColor: [KTApp.getSettings()['colors']['theme']['base'][color]],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        }

        function _initUsers() {
            var element = document.getElementById("kt_users_chart");

            var height = parseInt(KTUtil.css(element, 'height'));
            var color = KTUtil.hasAttr(element, 'data-color') ? KTUtil.attr(element, 'data-color') : 'primary';

            if (!element) {
                return;
            }

            var options = {
                series: [{
                    name: 'User',
                    data:  @json($users_charts)
                }],
                chart: {
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [KTApp.getSettings()['colors']['theme']['base'][color]]
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTApp.getSettings()['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 55,
                    labels: {
                        show: false,
                        style: {
                            colors: KTApp.getSettings()['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTApp.getSettings()['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTApp.getSettings()['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                markers: {
                    colors: [KTApp.getSettings()['colors']['theme']['light'][color]],
                    strokeColor: [KTApp.getSettings()['colors']['theme']['base'][color]],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        }

        $(document).ready(function () {
            _initMaps();
            _initMaps2();
            _initUsers();
        });
    </script>
    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Chart code -->

    <script>
        am4core.ready(function () {

// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end

            // Create chart instance
            var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
            chart.data = {!! $surah_maps_charts !!};

// Create axes
            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "surha";
            categoryAxis.numberFormatter.numberFormat = "#";
            categoryAxis.renderer.inversed = true;
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.cellStartLocation = 0.1;
            categoryAxis.renderer.cellEndLocation = 0.9;

            var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.opposite = true;

// Create series
            function createSeries(field, name) {
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueX = field;
                series.dataFields.categoryY = "surha";
                series.name = name;
                series.columns.template.tooltipText = "{name}: [bold]{valueX}[/]";
                series.columns.template.height = am4core.percent(100);
                series.sequencedInterpolation = true;
                series.columns.template.events.on("beforedatavalidated", function (ev) {
                    alert(1);
                }, this);

                var valueLabel = series.bullets.push(new am4charts.LabelBullet());
                valueLabel.label.text = "{valueX}";
                valueLabel.label.horizontalCenter = "left";
                valueLabel.label.dx = 10;
                valueLabel.label.hideOversized = false;
                valueLabel.label.truncate = false;

                var categoryLabel = series.bullets.push(new am4charts.LabelBullet());
                categoryLabel.label.text = "{name}";
                categoryLabel.label.horizontalCenter = "right";
                categoryLabel.label.dx = -10;
                categoryLabel.label.fill = am4core.color("#fff");
                categoryLabel.label.hideOversized = false;
                categoryLabel.label.truncate = false;


            }

            createSeries("maps_count", "خريطة");


        })

    </script>

@endsection
