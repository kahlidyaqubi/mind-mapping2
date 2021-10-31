@extends(admin_layout_vw().'.index')
@section('css')
    <style>
        #aya_text {
            overflow: hidden;
            padding: 5px;
            font-size: large;
            font-weight: bold;
        }

        #aya_index {
            overflow: hidden;
            padding: 5px;
            font-size: large;
            font-weight: bold;
        }
    </style>
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
                                <a href="{{url(admin_verse_url().'/'.$verse->id."/tree")}}"
                                   class="btn btn-primary font-weight-bolder">
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
											</span>عرض شجرة أقسام السورة</a>
                            </div>
                        </div>
                        <!--begin::Form-->

                        {!! Form::open(['method'=>'PUT','class'=>'form-horizontal form','files'=>true,'id'=>'formEdit']) !!}
                        <div class="card-body row">
                            <div class="col-md-12 text-center">
                                <div class="row">

                                    <textarea id="aya_text" dir="rtl" class="col-md-11"
                                              data-readonly="readonly">{{$verse->text}}</textarea>
                                    <input type="text" class="col-md-1" id="aya_index" readonly>
                                </div>


                            </div>

                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="content_reciter_ids">
                                    <label>الصوتيات</label>
                                    <div class="row m-1 row1">
                                        <div class="input-group col-md-4 pl-5">
                                            القارئ
                                        </div>
                                        <div class="input-group col-md-4 ">
                                           ملف الصوت
                                        </div>
                                        <div class="input-group col-md-1">
                                            العمليات
                                        </div>
                                    </div>
                                    @if(isset($verse)&& $verse->sounds->first())
                                        @php  $i = 1 @endphp
                                        @foreach($verse->sounds as $sound)
                                            <div class="row m-1 row1">
                                                <div class="input-group col-md">
                                                    <select class="form-control select2" name="reciter_ids[{{$i}}]"
                                                            id="reciter_ids[{{$i}}]">
                                                        <option value="" disabled="disabled" selected>القارئ</option>
                                                        @foreach($reciters as $reciter)
                                                            <option value="{{$reciter->id}}"
                                                                    @if($reciter->id == $sound->reciter_id)selected @endif>{{$reciter->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group col-md">
                                                    <div class="row" style="width: 100%;">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <input class="col-md form-control" id="sounds[{{$i}}]"
                                                                       name="sounds[{{$i}}]"
                                                                       readonly
                                                                       placeholder="اختر صوت" type="file"
                                                                       accept="audio/*"/>
                                                                @if($sound->sound)
                                                                    <audio class="col-md form-control" controls
                                                                           src="{{$sound->sound}}"
                                                                    ></audio>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group col-md">
                                                    <a class="btn btn-info  mr-1"
                                                       onclick="addRow('content_reciter_ids')"><span
                                                                class="fa fa-plus "
                                                        ></span></a>
                                                    <a class="btn btn-danger  ml-1"
                                                       onclick="removeRowReal(this,'content_reciter_ids','{{url(admin_verse_url()."/".$sound->id."/remove-sound")}}')"><span
                                                                class="fa fa-minus"
                                                        ></span></a>
                                                </div>
                                            </div>
                                            <?php $i++ ?>
                                        @endforeach
                                    @else
                                        <div class="row m-1 row1">
                                            <div class="input-group col-md">
                                                <select class="form-control select2" name="reciter_ids[1]"
                                                        id="reciter_ids[1]">
                                                    <option value="" disabled="disabled" selected>القارئ</option>
                                                    @foreach($reciters as $reciter)
                                                        <option value="{{$reciter->id}}"
                                                        >{{$reciter->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group col-md">
                                                <div class="col-md-12">
                                                    <div class="input-group input-medium">
                                                        <input class="form-control sound" id="sounds[1]"
                                                               name="sounds[1]"
                                                               readonly
                                                               placeholder="اختر صوت" type="file" accept="audio/*"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group col-md">
                                                <a onclick="addRow('content_reciter_ids')"
                                                   class="btn btn-info  mr-1"><span
                                                            class="fa fa-plus "
                                                    ></span></a>
                                                <a onclick="removeRow(this,'content_reciter_ids')"
                                                   class="btn btn-danger  ml-1"><span class="fa fa-minus"></span></a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" id="content_verse_subs_ids">
                                    <label>أقسام الآية</label>
                                    <div class="row m-1 row2">
                                        <div class="input-group  col-md-3 ">
                                            الجذر
                                        </div>
                                        <div class="input-group col-md-1 ">
                                            الصورة
                                        </div>
                                        <div class="input-group  col-md">
                                            من الحرف
                                        </div>
                                        <div class="input-group col-md">
                                            إلى الحرف
                                        </div>
                                        <div class="input-group  col-md">
                                            النص
                                        </div>
                                        <div class="input-group col-md-1">
                                            العمليات
                                        </div>
                                    </div>
                                    @if(isset($verse)&& $verse->verse_subs->first())
                                        @php  $i = 1 @endphp
                                        @foreach($verse->verse_subs as $sub)
                                            <input type="hidden" name="his_ids[{{$i}}]" value="{{$sub->id}}">
                                            <input type="hidden" name="parent_ids[{{$i}}]" value="">
                                            <div class="row m-1 row2">
                                                <div class="input-group col-md" style="max-height: 50px">
                                                    <select class="form-control select2" name="parent_ids[{{$i}}]"
                                                            id="parent_ids[{{$i}}]" his_id="{{$sub->id}}">
                                                        <option value="" selected>الجذر</option>
                                                        @foreach($parents as $parent)
                                                            @if($parent->id != $sub->id)
                                                                <option value="{{$parent->id}}"
                                                                        @if($parent->id == $sub->parent_id)selected @endif>
                                                                    {{$parent->title }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group col-md">
                                                    <div class="col-md-12">
                                                        <div class="input-group input-medium">
                                                            <div class="image-input image-input-empty image-input-outline mb-5"
                                                                 id="kt_image_5[{{$i}}]"
                                                                 @if($sub->image)
                                                                 style="background-image: url({{$sub->image}});width: 100%;
                                                                         height: 104px;"
                                                                 @else
                                                                 style="background-image: url({{assets_url()}}/media/placeholder.png);width: 100%;
                                                                         height: 104px;"
                                                                    @endif
                                                            >
                                                                <div class="image-input-wrapper"></div>

                                                                <label
                                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                        data-action="change" data-toggle="tooltip"
                                                                        title=""
                                                                        data-original-title="Change avatar">
                                                                    <i class="fa fa-pen icon-sm text-muted"></i>
                                                                    <input type="file" name="images[{{$i}}]"
                                                                           id="images[{{$i}}]"
                                                                           accept=".png, .jpg, .jpeg"/>
                                                                    <input type="hidden" name="profile_avatar_remove"/>
                                                                </label>

                                                                <span
                                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                        data-action="cancel" data-toggle="tooltip"
                                                                        title="Cancel avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>

                                                                <span
                                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                        data-action="remove" data-toggle="tooltip"
                                                                        title="Remove avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="input-group col-md">
                                                    <div class="col-md-12">
                                                        <div class="input-group input-medium">
                                                            <div class="row">
                                                                <input class="col-md-12 form-control numbers"
                                                                       id="from_chars[{{$i}}]"
                                                                       his_id="{{$i}}"
                                                                       name="from_chars[{{$i}}]" placeholder="من الحرف"

                                                                       value="{{$sub->from_char}}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group col-md">
                                                    <div class="col-md-12">
                                                        <div class="input-group input-medium">
                                                            <div class="row">
                                                                <input class="col-md-12 form-control numbers"
                                                                       id="to_chars[{{$i}}]"
                                                                       his_id="{{$i}}"
                                                                       name="to_chars[{{$i}}]" placeholder="إلى الحرف"

                                                                       value="{{$sub->to_char}}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group col-md">
                                                    <div class="col-md-12">
                                                        <div class="input-group input-medium">
                                                            <div class="row">
                                                                <input class="col-md-12 form-control" id="texts[{{$i}}]"
                                                                       name="texts[{{$i}}]" his_id="{{$i}}" readonly
                                                                       value="{{$sub->text}}"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group col-md">
                                                    <a class="btn btn-info form-control mr-1"
                                                       onclick="addRow2('content_verse_subs_ids')"><span
                                                                class="fa fa-plus "
                                                        ></span></a>
                                                    <a class="btn btn-danger form-control ml-1"
                                                       onclick="removeRowReal2(this,'content_verse_subs_ids','{{url(admin_verse_url()."/".$sub->id."/remove-sub")}}')"><span
                                                                class="fa fa-minus "
                                                        ></span></a>
                                                </div>
                                            </div>
                                            <?php $i++ ?>
                                        @endforeach
                                    @else
                                        <div class="row m-1 row2">
                                            <input type="hidden" name="his_ids[1]" value="">
                                            <input type="hidden" name="parent_ids[1]" value="">
                                            <div class="input-group col-md" style="max-height: 50px">
                                                <select class="form-control select2" name="parent_ids[1]"
                                                        id="parent_ids[1]">
                                                    <option value="" selected>الجذر</option>
                                                    @foreach($parents as $parent)
                                                        <option value="{{$parent->id}}"
                                                        >{{$parent->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-group col-md">
                                                <div class="col-md-12">
                                                    <div class="input-group input-medium">
                                                        <div class="image-input image-input-empty image-input-outline mb-5"
                                                             id="kt_image_5[1]"

                                                             style="background-image: url({{assets_url()}}/media/placeholder.png);width: 100%;
                                                                     height: 104px;"

                                                        >
                                                            <div class="image-input-wrapper"></div>

                                                            <label
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="change" data-toggle="tooltip" title=""
                                                                    data-original-title="Change avatar">
                                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                                <input type="file" name="images[1]"
                                                                       id="images[1]" accept=".png, .jpg, .jpeg"/>
                                                                <input type="hidden" name="profile_avatar_remove"/>
                                                            </label>

                                                            <span
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="cancel" data-toggle="tooltip"
                                                                    title="Cancel avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>

                                                            <span
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="remove" data-toggle="tooltip"
                                                                    title="Remove avatar">
<i class="ki ki-bold-close icon-xs text-muted"></i>
</span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="input-group col-md">
                                                <div class="col-md-12">
                                                    <div class="input-group input-medium">
                                                        <div class="row">
                                                            <input class="col-md-12 form-control numbers"
                                                                   id="from_chars[1]"
                                                                   his_id="1"
                                                                   name="from_chars[1]" placeholder="من الحرف"


                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group col-md">
                                                <div class="col-md-12">
                                                    <div class="input-group input-medium">
                                                        <div class="row">
                                                            <input class="col-md-12 form-control numbers"
                                                                   id="to_chars[1]"
                                                                   his_id="1"
                                                                   name="to_chars[1]" placeholder="إلى الحرف"


                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group col-md">
                                                <div class="col-md-12">
                                                    <div class="input-group input-medium">
                                                        <div class="row">
                                                            <input class="col-md-12 form-control" id="texts[1]"
                                                                   name="texts[1]" his_id="1" readonly

                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group col-md">
                                                <a onclick="addRow2('content_verse_subs_ids')"
                                                   class="btn btn-info  mr-1 form-control"><span
                                                            class="fa fa-plus "
                                                    ></span></a>
                                                <a onclick="removeRow2(this,'content_verse_subs_ids')"
                                                   class="btn btn-danger  ml-1 form-control"><span
                                                            class="fa fa-minus"></span></a>
                                            </div>
                                        </div>
                                    @endif

                                </div>
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

    <script src="{{url(assets_url('verse'))}}/js/verses.js" type="text/javascript"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        function AllKTImageInput() {
            $("[id^='kt_image_5']").each(function () {
                let id = $(this).attr('id');
                if (typeof (id) != 'undefined') {
                    new KTImageInput(id);
                }
            });
            $(".numbers").bind('keypress', numbersInput);
            $(".integers").bind('keypress', integersInput);
        }

        AllKTImageInput();

        var part_id = '{{$part_id??null}}';
        var is_surah = '{{$is_surah??null}}';
    </script>
    <script>
        var i = document.querySelectorAll('.row.m-1.row1').length;

        function addRow(key) {
            i++;
            document.getElementById(key).insertAdjacentHTML(
                'beforeend',
                ' <div class="row m-1 row1">\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <select class="form-control select2" name="reciter_ids[' + i + ']"\n' +
                '                                                        id="reciter_ids[' + i + ']">\n' +
                '                                                    <option value="" disabled="disabled" selected>القارئ</option>\n' +
                '                                                    @foreach($reciters as $reciter)\n' +
                '                                                        <option value="{{$reciter->id}}"\n' +
                '                                                                >{{$reciter->name}}</option>\n' +
                '                                                    @endforeach\n' +
                '                                                </select>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <div class="col-md-12">\n' +
                '                                                    <div class="input-group input-medium">\n' +
                '                                                        <input class="form-control sound" id="sounds[' + i + ']"\n' +
                '                                                               name="sounds[' + i + ']"\n' +
                '                                                               readonly\n' +
                '                                                               placeholder="اختر صوت"type="file" accept="audio/*"/>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                           <div class="input-group col-md">\n' +
                '                                                <a  onclick="addRow(\'content_reciter_ids\')" class="btn btn-info  mr-1"><span\n' +
                '                                                            class="fa fa-plus "\n' +
                '                                                            ></span></a>\n' +
                '                                                <a  onclick="removeRow(this,\'content_reciter_ids\')" class="btn btn-danger  ml-1"><span\n' +
                '                                                            class="fa fa-minus"\n' +
                '                                                            ></span></a>\n' +
                '                                            </div>\n' +
                '                                        </div>'
            );
            $('.select2').select2({});
            $('.sound').soundpicker();
            KTBootstrapSwitch.init();
        };

        function removeRowReal(button, key, href) {
            var action = href;
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

                                        document.getElementById(key).removeChild(button.parentNode.parentNode);
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


        };

        function removeRow(button, key) {
            document.getElementById(key).removeChild(button.parentNode.parentNode);
        };
    </script>
    <script>
        var i = document.querySelectorAll('.row.m-1.row2').length;

        function addRow2(key) {
            i++;
            document.getElementById(key).insertAdjacentHTML(
                'beforeend',
                '<div class="row m-1 row2">\n' +
                '\n' +
                '                                            <input type="hidden" name="his_ids[' + i + ']" value="">' +
                ' <input type="hidden" name="parent_ids[' + i + ']" value="">' +
                '<div class="input-group col-md"  style="max-height: 50px">\n' +
                '                                                <select class="form-control select2" name="parent_ids[' + i + ']"\n' +
                '                                                        id="parent_ids[' + i + ']">\n' +
                '                                                    <option value=""  selected>الجذر</option>\n' +
                '                                                    @foreach($parents as $parent)\n' +
                '                                                        <option value="{{$parent->id}}"\n' +
                '                                                        >{{$parent->title }}</option>\n' +
                '                                                    @endforeach\n' +
                '                                                </select>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <div class="col-md-12">\n' +
                '                                                    <div class="input-group input-medium">\n' +
                '                                                        <div class="image-input image-input-empty image-input-outline mb-5" id="kt_image_5[' + i + ']"\n' +
                '\n' +
                '                                                             style="background-image: url({{assets_url()}}/media/placeholder.png);width: 100%;\n' +
                '    height: 104px;"\n' +
                '                                                               \n' +
                '                                                        >\n' +
                '                                                            <div class="image-input-wrapper"></div>\n' +
                '\n' +
                '                                                            <label\n' +
                '                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"\n' +
                '                                                                    data-action="change" data-toggle="tooltip" title=""\n' +
                '                                                                    data-original-title="Change avatar">\n' +
                '                                                                <i class="fa fa-pen icon-sm text-muted"></i>\n' +
                '                                                                <input type="file" name="images[' + i + ']" id="images[' + i + ']" accept=".png, .jpg, .jpeg"/>\n' +
                '                                                                <input type="hidden" name="profile_avatar_remove"/>\n' +
                '                                                            </label>\n' +
                '\n' +
                '                                                            <span\n' +
                '                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"\n' +
                '                                                                    data-action="cancel" data-toggle="tooltip" title="Cancel avatar">\n' +
                '<i class="ki ki-bold-close icon-xs text-muted"></i>\n' +
                '</span>\n' +
                '\n' +
                '                                                            <span\n' +
                '                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"\n' +
                '                                                                    data-action="remove" data-toggle="tooltip" title="Remove avatar">\n' +
                '<i class="ki ki-bold-close icon-xs text-muted"></i>\n' +
                '</span>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <div class="col-md-12">\n' +
                '                                                    <div class="input-group input-medium">\n' +
                '                                                        <div class="row">\n' +
                '                                                            <input class="col-md-12 form-control numbers" id="from_chars[' + i + ']"\n' +
                '                                                                   name="from_chars[' + i + ']" his_id="' + i + '" placeholder="من الحرف" \n' +
                '\n' +
                '                                                            />\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <div class="col-md-12">\n' +
                '                                                    <div class="input-group input-medium">\n' +
                '                                                        <div class="row">\n' +
                '                                                            <input class="col-md-12 form-control numbers" id="to_chars[' + i + ']"\n' +
                '                                                                   name="to_chars[' + i + ']  his_id="' + i + '" "placeholder="إلى الحرف" \n' +
                '\n' +
                '                                                            />\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <div class="col-md-12">\n' +
                '                                                    <div class="input-group input-medium">\n' +
                '                                                        <div class="row">\n' +
                '                                                            <input class="col-md-12 form-control" id="texts[' + i + ']"\n' +
                '                                                                   name="texts[' + i + ']"  his_id="' + i + '" readonly\n' +
                '\n' +
                '                                                            />\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '\n' +
                '                                            <div class="input-group col-md">\n' +
                '                                                <a onclick="addRow2(\'content_verse_subs_ids\')"\n' +
                '                                                   class="btn btn-info form-control mr-1"><span\n' +
                '                                                            class="fa fa-plus "\n' +
                '                                                    ></span></a>\n' +
                '                                                <a onclick="removeRow2(this,\'content_verse_subs_ids\')"\n' +
                '                                                   class="btn btn-danger  ml-1 form-control"><span class="fa fa-minus"></span></a>\n' +
                '                                            </div>\n' +
                '                                        </div>'
            );
            $('.select2').select2({});
            AllKTImageInput();
            KTBootstrapSwitch.init();
            addData();
        };

        function removeRowReal2(button, key, href) {
            var action = href;
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

                                        document.getElementById(key).removeChild(button.parentNode.parentNode);
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


        };

        function removeRow2(button, key) {
            document.getElementById(key).removeChild(button.parentNode.parentNode);
        };
    </script>
    <script>
        $(document).ready(function () {
            var allowedKeys = {
                "37": "arrow-left",
                "38": "arrow-up",
                "39": "arrow-right",
                "40": "arrow-down",
                "9": "tab",
                "27": "esc"
            }

            $("#aya_text").keydown(function (e) {

                if (!allowedKeys[e.which]) {
                    e.preventDefault();
                }
            });

            document.getElementById('aya_text').addEventListener('click', e => {
                $('#aya_index').val(e.target.selectionStart);
                console.log('Caret at: ', e.target.selectionStart)
            })

            element = document.getElementById("aya_text");
            element.style.height = "1px";
            element.style.height = (25 + element.scrollHeight) + "px";


        });


    </script>
    <script>
        var verse_id = '{{$verse->id}}';
        var verse_text = '{{$verse->text}}';

        function addData() {
            var url = "/admin/verses/" + verse_id + "/verse-subs";

            $.get(url, function (data, status) {
                the_data = data.data;
                if (typeof the_data == 'object') {


                    for (j = 0; j < $(":input[id^='parent_ids']").length; j++) {
                        var elemnt_id = document.querySelectorAll("[id^='parent_ids']")[j].getAttribute('id');


                        the_data.forEach(function (parent) {

                            if (!($(":input[id='" + elemnt_id + "'] option[value='" + parent.id + "']").length > 0))
                                $(":input[id='" + elemnt_id + "']").append($("<option class='parents'></option>")
                                    .attr("value", parent.id)
                                    .text(parent.text.slice(0, 170)));
                            $('.parents[value="' + parent.id + '"]');

                        });
                    }


                }
            });

            function checkParent(id, selected) {
                if (selected == id) {
                    return true
                } else
                    return false
            }

            $(":input[id^='from_chars']").keyup(function () {
                to_element_id = $(this).attr('his_id');
                to_element = $(":input[id='to_chars[" + to_element_id + "]']");
                text_element = $(":input[id='texts[" + to_element_id + "]']");
                var from = $(this).val();
                var to = to_element.val();
                console.log(from, to);
                if (isNumeric(from) && isNumeric(to)) {
                    text_element.val(verse_text.slice(from, to));
                }


            });
            $(":input[id^='to_chars']").keyup(function () {
                from_element_id = $(this).attr('his_id');
                from_element = $(":input[id='from_chars[" + to_element_id + "]']");
                text_element = $(":input[id='texts[" + to_element_id + "]']");
                var to = $(this).val();
                var from = from_element.val();
                if (isNumeric(from) && isNumeric(to)) {
                    text_element.val(verse_text.slice(from, to));
                }


            });
        }

        $(":input[id^='from_chars']").keyup(function () {
            to_element_id = $(this).attr('his_id');
            to_element = $(":input[id='to_chars[" + to_element_id + "]']");
            text_element = $(":input[id='texts[" + to_element_id + "]']");
            var from = $(this).val();
            var to = to_element.val();
            console.log(from, to);
            if (isNumeric(from) && isNumeric(to)) {
                text_element.val(verse_text.slice(from, to));
            }


        });
        $(":input[id^='to_chars']").keyup(function () {
            from_element_id = $(this).attr('his_id');
            from_element = $(":input[id='from_chars[" + to_element_id + "]']");
            text_element = $(":input[id='texts[" + to_element_id + "]']");
            var to = $(this).val();
            var from = from_element.val();
            if (isNumeric(from) && isNumeric(to)) {
                text_element.val(verse_text.slice(from, to));
            }


        });
    </script>
@stop
