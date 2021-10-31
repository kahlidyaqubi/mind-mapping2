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
                        <!--begin::Button-->
                        <a href="{{url(admin_admin_url().'/create')}}"
                           class="btn btn-primary font-weight-bolder add-new-mdl">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<circle fill="#000000" cx="9" cy="15" r="6"/>
														<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                              fill="#000000" opacity="0.3"/>
													</g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>إضافة جديد</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin::Search Form-->
                    {!! Form::open(['method'=>'POST','url'=>'#']) !!}
                    <div class="mb-7 the_form">
                        <div class="row align-items-center">
                            <div class="col-md-12 mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="الاسم..."
                                                   id="name" name="name"/>
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="البريد الإلكتروني..."
                                                   id="email" name="email"/>
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" placeholder="الهاتف..."
                                                   id="phone" name="phone"/>
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>

                                <div class="col-md my-4 my-md-0">
                                        <div class="input-group">
                                            <select class="form-control select2" name="is_active"
                                                    id="is_active">
                                                <option value="" disabled="disabled" selected>الحالة</option>
                                                <option value="1">فعال</option>
                                                <option value="0">غير فعال</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md  my-md-0">
                                        <a href="#" class="btn btn-light-primary font-weight-bold filter-submit">بحث</a>
                                        <a href="#" class="btn btn-light-danger font-weight-bold filter-cancel">إلغاء</a>
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
                        <table class="table table-separate table-head-custom collapsed" id="admin_tbl">
                            <thead>
                            <tr>
                                <th title="Field #1">#</th>
                                <th title="Field #2">الصورة</th>
                                <th title="Field #3">الاسم</th>
                                <th title="Field #6">البريد الإلكتروني</th>
                                <th title="Field #3">الهاتف</th>
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
    <script src="{{assets_url('admin')}}/js/admins.js" type="text/javascript"></script>

@endsection
