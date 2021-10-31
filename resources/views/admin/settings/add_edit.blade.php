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
                        @if(!isset($setting))
                            {!! Form::open(['method'=>'POST','class'=>'form-horizontal form','files'=>true,'id'=>'kt_form']) !!}
                        @else
                            {!! Form::open(['method'=>'PUT','class'=>'form-horizontal form','files'=>true,'id'=>'kt_form']) !!}

                        @endif
                        <div class="card-body row">
                            <div class="col-md-6">
                                <label>الصورة</label>
                                <div class="input-group">
                                    <div class="image-input image-input-empty image-input-outline mb-5" id="kt_image_5"
                                         @if(isset($setting) && $setting->photo)
                                         style="background-image: url({{$setting->photo}});"
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
                                    <label>المفتاح</label>
                                    <div class="input-group">
                                        <input type="text" name="key" id="key" class="form-control" placeholder="المفتاح"
                                               value="{{isset($setting)?$setting->key:''}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>القيمة</label>
                                    <div class="input-group">
                                        <input type="text" name="value" id="value" class="form-control"
                                               placeholder="القيمة"
                                               value="{{ isset($setting)?$setting->value:''}}"/>
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
    <script src="{{url(assets_url('setting'))}}/js/settings.js" type="text/javascript"></script>


    <script>
        var avatar5 = new KTImageInput('kt_image_5');
        $('.time').timepicker();
    </script>
@stop
