<div class="modal fade" id="{{$modal_id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header py-5">
                <h5 class="modal-title">{!! $modal_title !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            @if(isset($form))
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="portlet-body form">
                                {!! Form::open(['method'=>$form['method'],'id'=>$form['form_id'],'class'=>'form-horizontal form','url'=>$form['url'] ,'files'=>true]) !!}
                                <div class="alert alert-danger" role="alert" style="display: none"></div>

                                <div class="form-body row">

                                    @foreach($form['fields'] as $key=> $fields)
                                        @if($fields == 'image')
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <label>{{gettype($form['fields_ar'][$key])=='array'?$form['fields_ar'][$key][0]:$form['fields_ar'][$key]}}
                                                        <span class="dimensions">{{gettype($form['fields_ar'][$key])=='array'?$form['fields_ar'][$key][1]:""}}</span></label>
                                                    <div class="input-group">
                                                        <div class="image-input image-input-empty image-input-outline mb-5"
                                                             id="kt_image_5"
                                                             @if(isset($form['values'])&&isset($form['values'][$key]))
                                                             style="background-image: url({{$form['values'][$key]}})"
                                                             @else
                                                             style="background-image: url({{assets_url()}}/media/placeholder.png)"
                                                                @endif>

                                                            <div class="image-input-wrapper"></div>
                                                            @if(!((isset($form['attribute'])&&isset($form['attribute'][$key]))&&isset($form['attribute'][$key])&& $form['attribute'][$key]=='disabled'))
                                                                <label
                                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                        data-action="change"
                                                                        data-toggle="tooltip" title=""
                                                                        data-original-title="Change avatar">
                                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                                    <input type="file" name="{{$key}}"
                                                                           id="image"
                                                                           accept=".png, .jpg, .jpeg"/>
                                                                    <input type="hidden"
                                                                           name="profile_avatar_remove"/>
                                                                </label>
                                                            @endif
                                                            <span
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="cancel"
                                                                    data-toggle="tooltip"
                                                                    title="Cancel avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>

                                                            <span
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="remove"
                                                                    data-toggle="tooltip"
                                                                    title="Remove avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'text')
                                            <div class="col-md-6">
                                                <div class="form-group {{$key}}">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="{{$key}}" id="{{$key}}"
                                                               {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                               class="form-control"
                                                               placeholder="{{$form['fields_ar'][$key]}}"
                                                               @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'video_link')
                                            <div class="col-md-6">
                                                <div class="form-group {{$key}}">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <input type="url" name="{{$key}}" id="{{$key}}"
                                                               {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                               class="form-control"
                                                               placeholder="{{$form['fields_ar'][$key]}}"
                                                               @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                    </div>
                                                    @if(isset($form['values'][$key]))
                                                        <div class="col-md-12">
                                                            <iframe width="122" height="100"
                                                                    src="{{$form['values'][$key]}}">
                                                            </iframe>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        @if($fields == 'hidden')

                                            <input type="hidden" name="{{$key}}" id="{{$key}}"
                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                   class="form-control"
                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                        @endif
                                        @if($fields == 'number')
                                            <div class="col-md-6">
                                                <div class="form-group {{$key}}">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="{{$key}}" id="{{$key}}"
                                                               {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                               class="form-control"
                                                               placeholder="{{$form['fields_ar'][$key]}}"
                                                               @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'time')
                                            <div class="col-md-6">
                                                <div class="form-group {{$key}}">
                                                    <label class=" col-md-12">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <div class="input-icon">
                                                            <i class="fa fa-clock-o"></i>
                                                            <input type="text" name="{{$key}}" id="{{$key}}"
                                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                   class="form-control timepicker timepicker-24"
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'email')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <input type="email" name="{{$key}}" id="{{$key}}"
                                                               {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                               class="form-control"
                                                               placeholder="{{$form['fields_ar'][$key]}}"
                                                               @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'password')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <input type="password" name="{{$key}}" id="{{$key}}"
                                                               {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                               class="form-control"
                                                               placeholder="{{$form['fields_ar'][$key]}}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'date-time')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=" col-md-12">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">

                                                        <div class="input-group input-medium
                                                     {{--date date-picker--}}

                                                                "
                                                                {{--data-date-format="yyyy-mm-dd" data-date-start-date="+0d"--}}
                                                        >
                                                            <input type="text"
                                                                   class="form-control time_datepicker"
                                                                   readonly
                                                                   name="{{$key}}"
                                                                   id="{{$key}}"
                                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'date-timestamp')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=" col-md-12">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <div class="input-group
                                                    {{--date form_datetime--}}

                                                                input-large"
                                                                {{--data-date-format="yyyy-mm-dd H:i:s"--}}
                                                        >
                                                            <input type="text" size="16" readonly
                                                                   class="form-control timestamp_datepicker"
                                                                   name="{{$key}}" id="{{$key}}"
                                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'date-year')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=" col-md-12">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <div class="input-group
                                                    {{--date date-picker --}}

                                                                input-large"
                                                                {{--data-date-format="yyyy"--}}
                                                        >
                                                            <input type="text" size="16" readonly
                                                                   class="form-control  year_datepicker"
                                                                   name="{{$key}}" id="{{$key}}"
                                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'date')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class=" col-md-12">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">

                                                        <div class="input-group input-medium
                                                     {{--date date-picker--}}

                                                                "
                                                                {{--data-date-format="yyyy-mm-dd" data-date-start-date="+0d"--}}
                                                        >
                                                            <input type="text"
                                                                   class="form-control datepicker" readonly
                                                                   name="{{$key}}"
                                                                   id="{{$key}}"
                                                                   {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values'][$key]}}" @endif>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'date-range')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                        <div class="input-group input-large date-picker input-daterange"
                                                             data-date-format="yyyy-mm-dd">
                                                            <input type="text" class="form-control"
                                                                   name="start_date"
                                                                   autocomplete="off"
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values']['start_date']}}"
                                                                   @endif
                                                                   placeholder="start day">
                                                            <span class="input-group-addon"> from </span>
                                                            <input type="text" class="form-control"
                                                                   name="end_date"
                                                                   autocomplete="off"
                                                                   placeholder="end date"
                                                                   @if(isset($form['values'])&&isset($form['values'][$key])) value="{{$form['values']['end_date']}}" @endif >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                        @if($fields == 'textarea')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                <textarea name="{{$key}}" id="{{$key}}"
                                                          {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}} rows="5"
                                                          placeholder="{{$form['fields_ar'][$key]}}"
                                                          class="form-control">@if(isset($form['values'])&&isset($form['values'][$key])){{$form['values'][$key]}}@endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($fields == 'ckeditor')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="col-md-12">
                                                <textarea name="{{$key}}" id="{{$key}}"
                                                          {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}} rows="5"
                                                          placeholder="{{$form['fields_ar'][$key]}}"
                                                          class="form-control ckeditor">@if(isset($form['values'])&&isset($form['values'][$key])){{$form['values'][$key]}}@endif</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(is_array($fields))
                                            <div class="col-md-6">
                                                <div class="form-group {{$key}}">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2"
                                                                name="{{$key}}"
                                                                id="{{$key}}" {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}>
                                                            @foreach($fields as $k=> $field)
                                                                <option value="{{$k}}"
                                                                        @if(isset($form['values'])&&isset($form['values'][$key]) && $form['values'][$key] == $k) selected @endif>{{ucfirst($field)}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(is_object($fields) && strpos($key,'[]') !== false)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2 {{$key}}"
                                                                name="{{$key}}"
                                                                @if(strpos($key,'[]') !== false) multiple
                                                                @endif data-placeholder="select {{$form['fields_ar'][$key]}} ..."
                                                                id="{{$key}}"
                                                                {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}} style="padding: 0;">
                                                            <option></option>

                                                            @if(strpos($key,'[]') !== false && isset($form['values'][$key]))
                                                                @foreach($form['values'][$key] as $item)
                                                                    <option value="{{$item->id}}"
                                                                            @if(in_array($item->id,$roles_id)) selected @endif>{{isset($item->name)?$item->name:($item->translation()?($item->translation()->name??$item->translation()->title):"")}}

                                                                    </option>

                                                                @endforeach
                                                                @foreach($fields as  $k => $field)

                                                                    @if(in_array($field->id,$form['values']['role_res[]'])) @continue @endif
                                                                    <option
                                                                            value="{{$field->id}}">2
                                                                        {{(isset($field->name)&&!$field->title)?$field->name:($field->translation()?($field->translation()->name??$field->translation()->title):"")}}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                @foreach($fields as $field)
                                                                    <option value="{{$field->id}}"
                                                                            @if(isset($form['values'])&&isset($form['values'][$key]) && $form['values'][$key] == $field->id) selected @endif>
                                                                        {{ucfirst(
                                                                             isset($field->name)?$field->name:($field->translation()?($field->translation()->name??$field->translation()->title):""
                                                                             ))}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(is_object($fields)  && strpos($key,'[]') === false)

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-12 ">{{$form['fields_ar'][$key]}}</label>
                                                    <div class="input-group">
                                                        <select class="form-control select2 {{$key}}"
                                                                name="{{$key}}"
                                                                id="{{$key}}"
                                                                {{(isset($form['attribute'])&&isset($form['attribute'][$key]))?$form['attribute'][$key]:""}}
                                                                style="padding: 0;">
                                                            <option value="">{{$form['fields_ar'][$key]}}</option>

                                                            @foreach($fields as $field)
                                                                <option value="{{$field->id}}"
                                                                        @if(isset($form['values'])&&isset($form['values'][$key]) && $form['values'][$key] == $field->id) selected @endif>
                                                                    {{ucfirst(
                                                                   (isset($field->name)&&!$field->title)?$field->name:( isset($field->title)?$field->title:($field->translation()?($field->translation()->name??$field->translation()->title):""))
                                                                    )}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="form-actions" style="width: 100%">
                                        <div class="row" style="text-align: center">
                                            <div class="col-md-12 text-center">
                                                @if(isset($submit_btn))
                                                    <button type="submit"
                                                            class="btn btn-primary mr-2"> {{$submit_btn}}</button>
                                                @endif
                                                <button type="reset" data-dismiss="modal" aria-label="Close"
                                                        class="btn btn-secondary">{{$close_btn}}</button>

                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            @endif
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
{{--<script src="{{url(assets_url('admin'))}}/js/pages/crud/forms/editors/ckeditor-classic.js"></script>--}}
<script src="{{url(assets_url('admin'))}}/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{url(assets_url('admin'))}}/js/pages/crud/forms/editors/ckeditor-classic.js"></script>
<script src="{{assets_url()}}/js/pages/crud/forms/widgets/select2.js"></script>

<script>


    $(document).ready(function () {

        $(".numbers").bind('keypress', numbersInput);
        $(".integers").bind('keypress', integersInput);

        // Class definition

        KTBootstrapSwitch.init();


        $(".select2").select2();
        $('.modal').on('shown.bs.modal', function () {
            // basic
            $(".select2").select2();
        });

        $('#country_id').parent().parent().parent().hide()
        var value = $("#type").children(":selected").attr("value");
        if (value == 'admin') {
            $('#country_id').parent().parent().parent().show();
        } else if (value == 'super_admin') {
            $('#country_id').parent().parent().parent().hide();

        }

    });
    $("#type").change(function () {
        var value = $(this).children(":selected").attr("value");
        if (value == 'admin') {
            $('#country_id').parent().parent().parent().show();
        } else if (value == 'super_admin') {
            $('#country_id').parent().parent().parent().hide();
        }
        $(".select2").select2();
    });

    var avatar5 = new KTImageInput('kt_image_5');
    var baseURL = '{{url(admin_vw())}}';
    var baseAssets = '{{url('assets')}}/admin';
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
</script>
<script>
    $("textarea.ckeditor").each(function () {
        let id = $(this).attr('id');
        ClassicEditor
            .create(document.getElementById(id))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    });


    $(document).ready(function () {
        var editors_count = $('.ck-editor').length
        if (editors_count > 0)
            for (var i = 0; i < editors_count; i++) {
                $('.ck-editor')[i].style.width = '100%';
            }
    });
</script>
<script>
    $('form').submit(function () {

        $(this).find(':submit.btn-primary').attr('disabled', 'disabled');
        var wating = '<span id="wating" class="" >&nbsp;&nbsp;\n' +
            '                               <i class="fas fa-spinner fa-spin"></i>\n' +
            '                                </span>';
        $(this).find(':submit.btn-primary').append(wating);
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
