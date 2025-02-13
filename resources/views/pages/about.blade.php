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
                        <img src="{{ asset('/storage/images/IMG-20240626-WA0023.jpg') }}" alt="no image">
                        <div class="quotes-container">
                            <h2>Fii luptător și nu vei regeta!!</h2>
                            <p>Devino mai puternic cu fiecare luptă! Intră pe saltea și depășește-ți limitele!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inside">
                <div class="img-bckg">
                    <img src="{{ asset('/storage/images/rusu-3.jpg') }}" alt="no image">
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
                                    <option value="2024">2024</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2008">2008</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>
                                    <option value="1997">1997</option>
                                    <option value="1995">1995</option>
                                    <option value="1994">1994</option>
                                    <option value="1993">1993</option>
                                    <option value="1987">1987</option>
                                    <option value="1985">1985</option>
                                    <option value="1983">1983</option>
                                    <option value="1980">1980</option>
                                    <option value="1980">1980</option>
                                </select>

                            </form>

                        </div>
                @include('layouts.table')
                </div>
                </div>
            </div>

        </div>
    </main>
    @include('layouts.footer')
@endsection
