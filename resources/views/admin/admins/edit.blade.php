@extends(admin_layout_vw().'.index')
@section('css')
@endsection

@section('content')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">

                            <h3 class="card-title"><span class="{{$icon??""}}  m-1"></span>{{$title}}</h3>
                            <div class="card-toolbar">

                            </div>
                        </div>
                        <!--begin::Form-->
                        {!! Form::open(['method'=>'PUT','url'=>'/admin/admins/'.$admin->id.'/edit','class'=>'form-horizontal form','files'=>true,'id'=>'formEdit']) !!}
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label>الصورة</label>
                                <div class="input-group">
                                    <div class="image-input image-input-empty image-input-outline mb-5" id="kt_image_5"
                                         @if(isset($admin) && $admin->photo)
                                         style="background-image: url({{$admin->photo}});"
                                         @else
                                         style="background-image: url({{assets_url()}}/media/placeholder.png)"
                                            @endif
                                    >
                                        <div class="image-input-wrapper"></div>

                                        <label
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="change" data-toggle="tooltip" title=""
                                                data-original-title="Change avatar">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="file" name="photo" id="image" accept=".png, .jpg, .jpeg"/>
                                            <input type="hidden" name="profile_avatar_remove"/>
                                        </label>

                                        <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>

                                        <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="remove" data-toggle="tooltip" title="Remove avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الإسم</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="الاسم"
                                               value="{{isset($admin)?$admin->name:''}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الهاتف</label>
                                    <div class="input-group">
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               placeholder="الهاتف"
                                               value="{{ old('phone')??(isset($admin)?$admin->phone:'')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>البريد الإلكتروني</label>
                                    <div class="input-group">
                                        <input type="email" name="email" id="email" class="form-control"
                                               placeholder="البريد الإلكتروني"
                                               value="{{ isset($admin)?$admin->email:''}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                                <button type="reset" class="btn btn-secondary">إلغاء</button>
                            </div>
                        {!! Form::close() !!}
                        <!--end::Form-->
                        </div>
                        <!--end::Card-->

                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection
@section('js')
    <script src="{{url(assets_url('admin'))}}/js/admins.js" type="text/javascript"></script>


    <script>
        var avatar5 = new KTImageInput('kt_image_5');
        $('.time').timepicker();
    </script>
@stop
