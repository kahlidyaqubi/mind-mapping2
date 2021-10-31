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
                                    <div class="col-md-3 my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control"
                                                   name="agent"
                                                   placeholder="المتصفح" id="agent">
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 my-4 my-md-0">
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="date"
                                                   placeholder=" التاريخ" id="date">
                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 my-3 my-md-0">
                                        <div class="input-group">
                                            <select class="form-control select2" name="permission_id"
                                                    id="permission_id">
                                                <option value="">الصلاحية</option>
                                                @foreach($permissions as $permission)
                                                    <option value="{{$permission->id}}">{{$permission->title}}</option>
                                                @endforeach
                                            </select>
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

                        <table class="table table-separate table-head-custom collapsed" id="log_tbl">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="big-col"> Date</th>
                                <th class="big-col"> Time</th>
                                <th class="big-col-400"> Action</th>
                                <th class="big-col"> Admin</th>
                                <th class="big-col"> Type</th>
                                <th class="big-col"> Device</th>
                                <th class="big-col"> Browser</th>
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
    <script src="{{assets_url('admin')}}/js/logs.js" type="text/javascript"></script>
    <script>
        var admin_id = '{{$admin->id}}'
    </script>
@endsection
