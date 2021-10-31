
@foreach($maps as $map)
    @php($childes =$map->childes)

    <li  data-jstree='{ "opened" : true ,"icon" : "fab fa-font-awesome-alt"}'>
        {{$map->title}}

        @if($childes->count() > 0)
            <ul>
                @php($i++)
                @include('admin.parts.recursive', ['maps' => $childes])
            </ul>

        @endif
    </li>
    {{--@endif--}}
@endforeach
