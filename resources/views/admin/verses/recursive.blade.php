@foreach($subs as $sub)
    @php($childes =$sub->childes)

    <li data-jstree='{ "opened" : true ,"icon" : "fab fa-font-awesome-alt"}'>
         {{$sub->number}}- ({{$sub->title}})

        @if($childes->count() > 0)
            <ul>
                @php($i++)
                @include('admin.verses.recursive', ['subs' => $childes])
            </ul>

        @endif
    </li>
    {{--@endif--}}
@endforeach
