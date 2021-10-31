@extends(admin_layout_vw().'.index')
@section('css')
@endsection

@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">

                        <h3 class="card-label"><span class="{{$icon??""}}  m-1"></span> {{$title}}
                        </h3>
                    </div>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Search Form-->
                    {!! Form::open(['method'=>'POST','url'=>'#']) !!}
                    <div class="mb-7 the_form">
                        <div class="row align-items-center">
                            <div class="col-md-12 mb-4">
                                <div class="row align-items-center">
                                    <div class="col-mdmy-4 my-md-0">
                                        <div class="input-group">
                                            <select class="form-control select2" name="read_at"
                                                    id="read_at">
                                                <option value="" disabled="disabled" selected>الحالة</option>
                                                <option value="1">مقروء</option>
                                                <option value="0">غير مقروء</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="date"
                                                   placeholder="التاريخ" id="date">
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3  my-md-0">
                                        <a href="#" class="btn btn-light-primary px-6 font-weight-bold filter-submit">بحث</a>
                                        <a href="#" class="btn btn-light-danger px-6 font-weight-bold filter-cancel">إلغاء</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Search Form-->
                    <!--end: Search Form-->
                    <!--begin: Datatable-->
                    <div class="portlet-body">

                        <table class="table table-separate table-head-custom collapsed" id="notification_tbl">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="big-col"> التاريخ</th>
                                <th class="big-col"> الوقت</th>
                                <th class="big-col-400"> الحركة</th>
                                <th class="big-col"> الفئة</th>
                                <th class="big-col"> المدير</th>
                                <th class="big-col"> الجهاز</th>
                                <th class="big-col"> المتصفح</th>
                            </tr>
                            </thead>

                        </table>
                    </div>


                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@stop
@section('js')
    <script src="{{assets_url('admin')}}/js/notifications.js" type="text/javascript"></script>

@endsection
