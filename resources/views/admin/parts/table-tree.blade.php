<div class="portlet-body">
    <table class="table table-separate table-head-custom collapsed" id="admin_tbl">
        <thead>
        <tr>
            <th title="Field #1">عدد الأفرع</th>
            <th title="Field #3">الصورة</th>
            <th title="Field #3">الاسم</th>
            <th title="Field #3">الفيديو</th>
            <th title="Field #3">الفيديو الثاني</th>
            <th title="Field #3">الجذر</th>
            <th title="Field #3">الرقم</th>
            <th title="Field #3">من الآية</th>
            <th title="Field #3">إلى الآية</th>
            <th title="Field #5">الحالة</th>
            <th title="Field #7">العمليات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($childes as $key=>$childe)
            <tr>
                <td title="Field #1">{{$childe->childes->count()}}</td>
                <td title="Field #3"><img src="{{$childe->image}}" width="50px" height="50px"></td>
                <td title="Field #3">{{$childe->name}}</td>
                <td title="Field #3">
                    @if($childe->video)
                        <iframe width="122" height="100" src="{{$childe->video}}">
                        </iframe>
                    @else
                        -
                    @endif

                </td>
                <td title="Field #3">
                    @if($childe->video2)
                        <iframe width="122" height="100" src="{{$childe->video2}}">
                        </iframe>
                    @else
                        -
                    @endif
                </td>
                <td title="Field #3">
                    @if($childe->parent)
                        {{$childe->parent->title}}
                    @else
                        -
                    @endif
                </td>
                <td title="Field #3">{{$childe->number}}</td>
                <td title="Field #3">{{$childe->form_verse}}</td>
                <td title="Field #3">{{$childe->to_verse}}</td>
                <td title="Field #5">
                    <span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" @if($childe->is_active)checked="checked" @endif name="select" class="make-switch active"
            data-id="{{$childe->id }}"/>
     <span></span>
    </label>
   </span>
                </td>
                <td title="Field #7">
                    <div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon"
                                                             data-toggle="dropdown"> <i class="la la-cog"></i> </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <ul class="nav nav-hoverable flex-column">
                                <li class="nav-item"><a class="nav-link"
                                                        href="{{ url(admin_verse_url() . '/' . $childe->id) }}"><i
                                                class="nav-icon fas fa-quran"></i><span
                                                class="nav-text">الآيات</span></a></li>
                                <li class="nav-item"><a class="nav-link add-new-mdl"
                                                        href="{{ url(admin_part_url() . '/' . $childe->surah->id . '/create?parent_id=' . $childe->id) }}"><i
                                                class="nav-icon fas fa-book-open"></i><span
                                                class="nav-text">إضافة خريطة فرعية</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="{{url(admin_part_url() . '/' . $childe->id . '/edit') }}"
                       class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit"> <i class="la la-edit"></i> </a>
                    <a href="{{ url(admin_part_url() . '/' . $childe->id . '/delete') }}"
                       class="btn btn-sm btn-clean btn-icon delete" title="Delete"> <i class="la la-trash"></i> </a>
                </td>

            </tr>
            @if($childe->childes->first())
                <tr>
                    <td colspan="1">الخرائط الفرعية</td>
                    <td colspan="10">
                        @php
                            $his_childes = $childe->childes;
                        @endphp
                        @include('admin.parts.table-tree', ['childes' => $his_childes])
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>