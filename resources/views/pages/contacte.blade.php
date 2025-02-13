@extends('layouts.app')

@section('stylesheets')
@parent
@vite('resources/css/contacte.css')
@endsection

@section('content')
@include('layouts.navbar')
@include('layouts.page-photo')
<section>
    <div class="contact-container">
        <div class="contact-subcontainer">
            <div class="text-left">
                <h1>Cum ne poți contacta</h1>
                <hr>
            </div>
            <div class="info-right">
                <p> <b>Tel:</b> +373 0269 75 725</p>
                <p>Adresa:  sat.Fundul Galbenei, r-nul. Hincesti</p>
                <p>E-mail:  scoalasportfg@yahoo.com</p>

                <p>Scoala infiintata conform numarului de identificare: 1014601000089</p>
            </div>
        </div>
    </div>
</section>
@include('layouts.footer')

@endsection
