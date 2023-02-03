@unless ($breadcrumbs->isEmpty())
    @if(count($breadcrumbs)>3)
        <h4 class="mb-sm-0">{{$breadcrumbs[count($breadcrumbs)-2]->title}}</h4>
    @else
        <h4 class="mb-sm-0">{{$breadcrumbs[count($breadcrumbs)-1]->title}}</h4>
    @endif
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            @foreach ($breadcrumbs as $breadcrumb)

                @if ($breadcrumb->url && !$loop->last)
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @elseif($loop->last)
                    <li class="breadcrumb-item active" aria-current="page"><span class="fw-bold">{{ $breadcrumb->title }}</span></li>
                @else
                    <li class="breadcrumb-item" aria-current="page">{{ $breadcrumb->title }}</li>
                @endif

            @endforeach
        </ol>
    </div>
@endunless
