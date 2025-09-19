
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
                @if ($post->image)
                <article>
                            <a href="{{ route('NewsPost', ['post' => $post->post_slug]) }}">
                            <div class="up-part">
                                <h3>{{ $post->post_title }}</h3>
                            </div>
                            <p >{{date('Y-m-d', strtotime($post->post_date))}}</p>
                            <hr>
                            <div class="bottom-part">
                                <div class="article-image">
                                    <img src="{{ asset($post->image[0]->image_path) }}" alt="no image">
                                </div>
                                <div class="article-caption">
                                    {!! Str::limit($post->post_content, 200) !!}
                                </div>
                                <button>Citeste mai
                                    mult</button>
                            </div>
                        </a>
                        </article>
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
                        <img src="{{ asset($post->image[0]->image_path) }}" alt="no image">
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
                                @endif
                                <div class="images-post">
                                    @foreach ($post->image as $index => $image)
                                    <div class="images-slider">
                                        <img loading="lazy" class="myImg" data-index="{{ $index }}" src="{{ asset($image->image_path) }}" alt="error">
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

                        </div>
                    </div>
                    <div class="mt-[5rem] pb-[5rem]">
                        <h2 class="text-[2.8rem] mb-[2rem]">Postări Recente</h2>
                        <div class="articles">
                            @foreach ($posts as $post)
                            {{-- @if($post->image) --}}
                            <a id="slug" href="{{route('NewsPost', ['post' => $post->post_slug])}}">
                            <article id="article" class="mb-[1rem]" >
                                <div class="img-ctn"><img src="{{$post->image[0]->image_path}}" alt="no image"></div>
                                <div class="post_title"><h3>{{$post->post_title}}</h3></div>
                                <div class="point-read"><i class="fa-solid fa-square-up-right"></i></div>
                            </article>
                        </a>
                        {{-- @endif --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @include('layouts.footer')

@endsection
@endif
