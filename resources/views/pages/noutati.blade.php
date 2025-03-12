
@if(isset($admin) == 'true')

@section('scripts')
    @vite('resources/js/noutati.js')
@endsection

<section class="sectionjj" id="section">
    <a href="{{url('/posts')}}" class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Inapoi</a>
    <div class="page">
        {{ Breadcrumbs::render('viewPost') }}
    </div>
    <div class="noutatzi-container">
        <div class="title-date">
            <h3>{{ $post->post_title }}</h3>
            <p><i class="fa-regular fa-clock"></i> {{ Str::replaceMatches('/\s\d.*/', '', $post->post_date) }}
            </p>
        </div>
        <div class="image">
            {{-- {{dd($post->images)}} --}}
            @if($post->images->isNotEmpty())
            <img src="{{ asset($post->images[0]) }}" alt="no image">
            @else
            <div class="alert alert-danger d-flex justify-center">
            <p>You need to add photos</p>
            </div>
            @endif
        </div>

        <div class="content">
            <div class="actual-content">
                    {!! $post->post_content !!}
                @if ($post->athlets)
                    <div class="premianti-participanti">
                        <ol>
                            @foreach ($post->athlets as $athlets)
                                <li>{{ $athlets->athlet->fullName }} - Locul {{ $athlets->place }} la categoria
                                    {{ $athlets->weight }} kg</li>
                            @endforeach
                        </ol>
                    </div>
                    <div class="images-post">
                        @foreach ($post->images as $index => $image)
                        <div class="images-slider">
                            <img loading="lazy" class="myImg" data-index="{{ $index }}" src="{{ asset($image) }}" alt="error">
                        </div>
                        @endforeach
                    </div>

                    <!-- Lightbox Modal -->
                    <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01">
                        <div class="lightbox-nav">
                            <span class="prev">&#10094;</span>
                            <span class="next">&#10095;</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@else
@extends('layouts.app')

@section('scripts')
    @parent
    @vite('resources/js/noutati.js')
@endsection

@section('stylesheets')
    @parent
    @vite('resources/css/noutati.css')
@endsection

@section('content')
    @include('layouts.navbar')
    @include('layouts.page-photo')

    @if (request()->path() == 'noutati')
        <section class="left-section">
            @foreach ($posts as $post)
                @if ($post->images)
                    <a href="{{ route('NewsPost', ['slug' => $post->post_slug]) }}">
                        <article>
                            <div class="up-part">
                                <h3>{{ $post->post_title }}</h3>
                            </div>
                            <hr>
                            <div class="bottom-part">
                                <div class="article-image">
                                    <img src="{{ asset($post->images) }}" alt="no image">
                                </div>
                                <div class="article-caption">
                                    {!! $post->post_content !!}
                                </div>
                                <button>Citeste mai
                                    mult</button>
                            </div>
                        </article>
                    </a>
                @endif
            @endforeach

            <div class="d-flex justify-content-center mt-3">
                {{ $posts->links() }}
            </div>
        </section>
    @else
        @if (isset($error))
            <div class="alert alert-danger d-flex justify-center">
                {{ $error }}
            </div>
        @else
            <section class="sectionjj">
                <div class="noutatzi-container">
                    <div class="title-date">
                        <h3>{{ $post->post_title }}</h3>
                        <p><i class="fa-regular fa-clock"></i> {{ Str::replaceMatches('/\s\d.*/', '', $post->post_date) }}
                        </p>
                    </div>
                    <div class="image">
                        <img src="{{ asset($post->images[0]) }}" alt="no image">
                    </div>

                    <div class="content">
                        <div class="actual-content">
                                {!! $post->post_content !!}
                            @if ($post->athlets)
                                <div class="premianti-participanti">
                                    <ol>
                                        @foreach ($post->athlets as $athlets)
                                            <li>{{ $athlets->athlet->fullName }} - Locul {{ $athlets->place }} la categoria
                                                {{ $athlets->weight }} kg</li>
                                        @endforeach
                                    </ol>
                                </div>
                                <div class="images-post">
                                    @foreach ($post->images as $index => $image)
                                    <div class="images-slider">
                                        <img loading="lazy" class="myImg" data-index="{{ $index }}" src="{{ asset($image) }}" alt="error">
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Lightbox Modal -->
                                <div id="myModal" class="modal">
                                    <span class="close">&times;</span>
                                    <img class="modal-content" id="img01">
                                    <div class="lightbox-nav">
                                        <span class="prev">&#10094;</span>
                                        <span class="next">&#10095;</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @include('layouts.footer')

@endsection
@endif
