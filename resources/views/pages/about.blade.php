@extends('layouts.app')

@section('stylesheets')
    @parent
    @vite('resources/css/about.css')
@endsection

@section('scripts')
    @parent
    @vite('resources/js/about.js')
@endsection

@section('content')
    @include('layouts.navbar')
    @include('layouts.page-photo')
    <main>
        <div class="under-section-container">
            <div class="first-row-column">
                <div class="left-first-row">
                    <span><small>CINE SUNTEM NOI?</small></span>
                    <h2>DINCOLO DE LIMITE: ȘCOALA SPORTIVĂ DE LUPTE FUNDUL GALBENEI - POARTA SPRE CAMPIONI</h2>
                    <div class="content-row">
                        <div class="declaration">
                            <p>Lupta nu este doar un stil de sport, este un stil de viață</p>
                        </div>
                        <p>Școala Sportivă de Lupte Fundul Galbenei
                            a activat anterior ca Secție de lupte libere din anul 1977. Prin urmare aceasta a livrat de-a
                            lungul anilor o mulțime de speranțe luptelor moldovenesti. In cadrul localității, aceasta era la
                            nivelul gimnaziului ceea ce privește prezența copiilor zi de zi</p>
                        <hr>
                        <div class="numbers">
                            <div class="stats">
                                <div class="activs-athlets odometer plus">0</div>
                                <div class="type">Sportivi Activi</div>
                            </div>
                            <div class="stats">
                                <div class="emerit-coach odometer plus">0</div>
                                <div class="type">Maeștri in Sport</div>
                            </div>
                            <div class="stats">
                                <div class="activity-years odometer plus">0</div>
                                <div class="type"> Ani De<br> Activitate</div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="right-first-row">
                    <div class="image-presentation-container">
                        <img src="{{ asset('/storage/images/IMG-20240626-WA0023.jpg') }}" alt="no image" loading="lazy">
                        <div class="quotes-container">
                            <h2>Fii luptător și nu vei regeta!!</h2>
                            <p>Devino mai puternic cu fiecare luptă! Intră pe saltea și depășește-ți limitele!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inside">
                <div class="img-bckg">
                    <img src="{{ asset('/storage/images/rusu-3.jpg') }}" alt="no image" loading="lazy">
                    <div class="text-over">
                        <h1>FONDAT IN 1977</h1>
                    </div>
                </div>
                <div class="table-content">
                    <div class="some-content">
                        <h2>🏆Forjeria Campionilor🏆</h2>
                        <hr>
                        <p>Dintr-un sat mic, spre marile podiumuri ale lumii! Școala Sportivă de Lupte din Fundul Galbenei a
                            fost rampa de lansare pentru peste 60 de campioni naționali, europeni și mondiali. Ambiția,
                            disciplina și pasiunea pentru lupte au transformat sportivii noștri în adevărați învingători.
                        </p>
                        <div class="search-bar">
                            <form action="" name="submit">
                               <span class="searchInput"> <input type="text" placeholder="Cauta" id="text-search"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <select name="year" id="year-search" aria-placeholder="Years">
                                    <option value="0" default>An</option>
                                    @foreach($dateRange as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>

                            </form>

                        </div>
                        <div class="hscroll">
                            @include('layouts.table')
                        </div>
                </div>
                </div>
            </div>

        </div>
    </main>
    @include('layouts.footer')
@endsection
