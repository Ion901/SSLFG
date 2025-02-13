@yield('page-photo')
<div class="photo-container">
    <div class="fixed-container">
        @if (request()->path() == 'about')
            <img src="{{ asset('/storage/images/IMG-20240626-WA0008.jpg') }}" alt="no image">
        @elseif (request()->path() == 'contacte')
            <img src="{{asset('/storage/images/mihai_sava_2014.jpg')}}" alt="no image">
        @else
            <img src="{{ asset('/storage/images/dake-74.jpg') }}" alt="no image">
        @endif
    </div>
    <div class="gradient-overlay"></div>
    <div class="page">
        @if (request()->path() == 'noutati')
            <h1>{{ request()->path() }}</h1>
            <hr>
            {{ Breadcrumbs::render('noutati') }}
        @elseif(Str::contains((string) request()->path(), 'noutati/'))
            <h1>Noutăți</h1>
            <hr>
            {{ Breadcrumbs::render('post_title') }}
        @elseif(request()->path() !== 'noutati')
            <h1>{{ request()->path() }}</h1>
            <hr>
            {{ Breadcrumbs::render((string) request()->path()) }}
        @endif
    </div>
</div>
