@extends('layouts.app')

@section('scripts')
    @parent
    @vite('resources/js/noutati.js')
@endsection

@section('stylesheets')
    @parent
    @vite('resources/css/noutati.css')
    @vite('resources/css/admin/filterNavbar.css')
@endsection

@section('content')
    @include('layouts.navbar')
    @include('layouts.page-photo')

    @if (request()->path() == 'noutati')
        <section class="left-section">
        <x-filter-data
        :tableName="'noutati'"
        :filters="[
            'post_title' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele postării'],
            'category' => [
                'type' => 'select',
                'options' => $category->pluck('type', 'id')->toArray(),
            ],
            'from_date' => ['type' => 'date', 'label' => 'Începând cu:'],
            'to_date' => ['type' => 'date', 'label' => 'Pînă pe:'],
        ]" />
        <div class="grid-container">

            @foreach ($posts as $post)
                @if ($post->image->isNotEmpty())
                    <article>
                        <a href="{{ route('NewsPost', ['post' => $post->post_slug]) }}">
                            <div class="inline-block p-2 m-2 rounded-lg"
                                style="background-color: {{ $post->category->color }}">
                                <p>{{ $post->category['type'] }}</p>
                            </div>
                            <div class="up-part">
                                <h3>{{ $post->post_title }}</h3>
                            </div>
                            <p>{{ date('Y-m-d', strtotime($post->post_date)) }}</p>
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
        </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $posts->links() }}
            </div>
            @if($posts->isEmpty())
                <p class="text-center text-[20px]" >Nu exista asemenea postari</p>
            @endif
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
                        <p><i class="fa-regular fa-clock"></i> {{ date('Y-m-d', strtotime($post->post_date)) }}</p>
                        <div class="inline-block p-2 mt-0.5 rounded-lg"
                            style="background-color: {{ $post->category->color }}">
                            <p class="text-center mb-0 text-sm p-2">{{ $post->category['type'] }}</p>
                        </div>
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
                                            <li>{{ $athlets->athlet->fullName }} - Locul {{ $athlets->place }} la
                                                categoria
                                                {{ $athlets->weight }} kg</li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                            <div class="images-post">
                                @foreach ($post->image as $index => $image)
                                    <div class="images-slider">
                                        <img loading="lazy" class="myImg" data-index="{{ $index }}"
                                            src="{{ asset($image->image_path) }}" alt="error">
                                    </div>
                                @endforeach
                            </div>

                            <x-lightbox-modal />

                        </div>
                    </div>
                    <div class="mt-[5rem] pb-[5rem]">
                        <h2 class="text-[2.8rem] mb-[2rem]">Postări Recente</h2>
                        <div class="articles">
                            @foreach ($posts as $post)
                                @if ($post->image->isNotEmpty())
                                    <a id="slug" href="{{ route('NewsPost', ['post' => $post->post_slug]) }}">
                                        <article id="article" class="mb-[1rem]">
                                            <div class="img-ctn"><img src="{{ asset($post->image[0]->image_path) }}"
                                                    alt="no image"></div>
                                            <div class="post_title">
                                                <h3>{{ $post->post_title }}</h3>
                                            </div>
                                            <div class="point-read"><i class="fa-solid fa-square-up-right"></i></div>
                                        </article>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    @include('layouts.footer')

@endsection
