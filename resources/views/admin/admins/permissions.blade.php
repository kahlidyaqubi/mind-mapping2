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
                        {!! Form::open(['method'=>'PUT','class'=>'form-horizontal form','files'=>true,'id'=>'formEdit']) !!}
                        <div class="card-body row">
                            <div class="col-md-12 mb-2 checkbox-lis">
                                <label class="checkbox">
                                    <input type="checkbox" id="#checkAll" onClick="toggle(this)"/>
                                    <span> </span>
                                    تحديد  الكل
                                </label>
                            </div>
                            <div class="col-md-12">

                                <div class="row ">
                                    @foreach($all_permissions as $link)

                                        <div class="col-md-3 mb-5 checkbox-list">
                                            <label class="checkbox mb-1">
                                                <input
                                                        {{$admin->hasPermissionTo($link->id)?'checked':''}} type="checkbox"
                                                        name="permissions[]" value="{{$link->id}}"/>
                                                <span></span>
                                                <b>{{$link->title}}</b></label>
                                            <div class="checkbox-list row the_parent  ml-2">
                                                <?php
                                                $sublinks = \Spatie\Permission\Models\Permission::where("parent_id", $link->id)->get();
                                                ?>
                                                @foreach($sublinks as $sublink)
                                                    <li class="list-unstyled mb-2">
                                                        <label class="checkbox ">
                                                            <input {{$admin->hasPermissionTo($sublink->id)?'checked':''}}
                                                                   type="checkbox" name="permissions[]"
                                                                   value="{{$sublink->id}}"/>
                                                            <span></span>
                                                            {{$sublink->title}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-footer col-md-12">
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
        $(function () {

            $(":checkbox").click(function () {
                $(this).parent().next().find(":checkbox").prop("checked", $(this).prop("checked"));
                $(this).parents(".the_parent").each(function () {
                    $(this).prev().children(":checkbox").prop("checked", $(this).find(":checked").length > 0);
                });

            });
//
            //
        });

        function toggle(source) {
            checkboxes = $(":checkbox");
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@stop
