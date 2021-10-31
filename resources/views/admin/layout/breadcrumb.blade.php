<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">

    @if(isset($links))
        @foreach($links as $key => $link)
            <li class="breadcrumb-item text-muted">
                <a href="{{$key}}" class="text-muted">{{$link}}</a>
            </li>
        @endforeach
    @endif
</ul>
