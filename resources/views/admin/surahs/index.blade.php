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
                            <div class="col-md-9">
                                <div class="row align-items-center">
                                    <div class="col-md my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="الاسم..."
                                                   id="name_filter" name="name_filter"/>
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md my-2 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control numbers" placeholder="رقم الصفحة..."
                                                   id="page_number_filter" name="page_number_filter"/>
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md my-2 my-md-0">
                                        <div class="input-group">
                                            <select class="form-control select2" name="is_active_filter"
                                                    id="is_active_filter">
                                                <option value="" disabled="disabled" selected>الحالة</option>
                                                <option value="1">فعال</option>
                                                <option value="0">غير فعال</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md my-2 my-md-0">
                                        <div class="input-group">
                                            <select class="form-control select2" name="type_filter"
                                                    id="type_filter">
                                                <option value="" disabled="disabled" selected>النوع</option>
                                                <option value="مكية">مكية</option>
                                                <option value="مدنية">مدنية</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="btn btn-light-primary px-6 font-weight-bold filter-submit">بحث</a>
                                <a href="#" class="btn btn-light-danger px-6 font-weight-bold filter-cancel">إلغاء</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!--end::Search Form-->
                    <!--end: Search Form-->
                    <!--begin: Datatable-->
                    <div class="portlet-body">

                        <table class="table table-separate table-head-custom collapsed" id="surah_tbl">
                            <thead>
                            <tr>
                                <th title="Field #1">#</th>
                                <th title="Field #3">اسم السورة</th>
                                <th title="Field #3">النوع</th>
                                <th title="Field #3">أسماء أخرى</th>
                                <th title="Field #3">رقم الصفحة</th>
                                <th title="Field #5">الحالة</th>
                                <th title="Field #7">العمليات</th>
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
    <script src="{{assets_url('admin')}}/js/surahs.js" type="text/javascript"></script>

@endsection
