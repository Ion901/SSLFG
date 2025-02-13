@extends('layouts.app')

@section('scripts')
    @parent
    @vite('resources/js/index.js')
@endsection

@section('stylesheets')
@parent
@vite('resources/css/index.css')
@endsection

@section('content')
    @include('layouts.navbar')
    <section class="page">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    @if ($post->images)
                        <div class="swiper-slide">
                            <div class="slide-ctn">
                                <div class="overlay-filter">
                                    <div class="info-ctn">
                                        <h2>{{ $post->post_title }}</h2>
                                        <a href="{{ route('NewsPost', ['slug' => $post->post_slug]) }}">
                                            <button>Citeste Acum</button>
                                        </a>
                                    </div>
                                    <div class="image-wrapper">
                                        <img src="{{ asset($post->images) }}" alt="Banner">
                                        <div class="gradient-overlay"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="swiper-button-next" id="first-button-next"></div>
            <div class="swiper-button-prev" id="second-button-next"></div>
            <div class="swiper-pagination"></div>
            <div class="autoplay-progress">
                <svg viewBox="0 0 48 48">
                    <circle cx="24" cy="24" r="20"></circle>
                </svg>
                <span></span>
            </div>
        </div>

        <div class="in-between mt-5">
            <h2>Ultimele <span>rezultate</span></h2>
        </div>
        <div class="info-card">
            <div class="swiper mySwiper1">
                <div class="swiper-wrapper">
                    @foreach ($athlets as $athlet)
                        <div class="swiper-slide">
                            <div class="cards">
                                <div class="card-head">
                                    <div class="location">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <h3>{{ $athlet->competition->location }}</h1>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <h1>{{ $athlet->fullName }}</h1>
                                    <div class="wrestler-details">
                                        <div class="date gap-4 mb-2">
                                            <i class="fa-solid fa-medal"></i>
                                            <p>Locul: {{ $athlet->place }}</p>
                                        </div>
                                        <div class="date gap-4 mb-2">
                                            <i class="fa-solid fa-weight-scale"></i>
                                            <p>Categoria: {{ $athlet->weight }} kg</p>
                                        </div>
                                        <div class="date gap-4 mt-2">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <p>Virsta: {{ $athlet->age }}</p>
                                        </div>
                                    </div>
                                    <div class="date gap-4 mt-4">
                                        <i class="fa-regular fa-clock"></i>
                                        <p class="mb-0">{{Str::replaceMatches('/:\d+\z/','',$athlet->competition->date)}}</p>
                                        {{-- <p>{{dd($athlets->postCompetion[0])}}</p> --}}
                                        <a href="{{ route('NewsPost', ['slug' => $athlets->postCompetition]) }}">
                                            <button><i class="fa-solid fa-arrow-right-long"></i></button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="gb-shapes">
                <div class="gb-shape gb-shape-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 360"
                        preserveAspectRatio="none">
                        <path d="M1200 360H0V0l1200 348z" fill="#bfdfff"></path>
                    </svg></div>
                <div class="gb-shape gb-shape-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 360"
                        preserveAspectRatio="none">
                        <path d="M1200 360H0V0l1200 348z" fill="#bfdfff"></path>
                    </svg></div>
            </div>
        </div>
        <div class="container-section">
            <h2>Postari recente</h2>
            <div class="container-subsection">
            <section class="left-section ">
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
                                        <p class="mt-4">{{ $post->post_content }}</p>
                                    </div>
                                    <button>Citeste mai
                                        mult</button>
                                </div>
                            </article>
                        </a>
                    @endif
                @endforeach
            </section>
            <section class="right-section">
                <div class="message-director-container">
                    <h2>Mesajul Directorului Școlii Sportive de lupte Fundul Galbenei</h2>
                    <span class="horizontal bar">
                        <hr>
                    </span>
                    <div class="message-ctn">
                        <div class="image-ctn-message">
                            <img src="{{asset('/storage/images/dmn-Vasile.jpg')}}" alt="no image">
                        </div>
                        <div class="message">
                            <p>Dragi vizitatori,<br>
                                <br>
                                Vă salut cu căldură și entuziasm în numele întregii noastre echipe! Școala noastră este un
                                loc unde pasiunea pentru lupte, disciplina și dorința de performanță se îmbină armonios
                                pentru a forma campionii de mâine. <br>
                                <br>
                                Aici, fiecare sportiv găsește sprijin, îndrumare și motivație pentru a-și atinge potențialul
                                maxim. Prin muncă, dedicare și respect pentru acest sport nobil, cultivăm nu doar campioni
                                pe saltea, ci și caractere puternice în viață. <br>
                                <br>
                                Vă invit să descoperiți realizările noastre, evenimentele și competițiile la care
                                participăm, dar și valorile care ne ghidează în fiecare zi. Fie că sunteți sportivi,
                                părinți, antrenori sau susținători ai acestui sport minunat, vă mulțumim pentru interesul
                                vostru și vă asigurăm că sunteți mereu bineveniți în familia noastră! <br>
                                <br>
                                Cu respect,<br>
                                Vasile Bodișteanu <br>
                                Director, Școala Sportivă de Lupte "Fundul Galbenei"
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="champions-container">
            <div class="inside-champions-container">
                <div class="title-champions-container">
                    <h1>Rezultatele noastre în numere</h1>
                    <p>Școala Sportivă Fundul Galbenei este una dintre cele mai eficiente școli din intreaga țară. <br> Nu o spunem noi, numerele vorbesc de la sine</p>
                </div>
                <div class="stats-container">
                    <div class="number-champions">
                        <div class="european-titles odometer plus">0</div>
                        <div class="type">Premianți Europeni</div>
                    </div>
                    <div class="number-champions">
                        <div class="national-titles odometer plus">0</div>
                        <div class="type">Campioni Naționali</div>
                    </div>
                    <div class="number-champions">
                        <div class="international-titles odometer plus">0</div>
                        <div class="type"> Campioni Turnee<br>  Internaționale</div>
                    </div>
                </div>
            </div>


        </div>
        @include('layouts.footer')
    </section>
@endsection
