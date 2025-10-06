@extends('layouts.app')

@section('stylesheets')
@parent
@vite('resources/css/gallery.css')
@endsection

@section('scripts')
@parent
@vite('resources/js/galerie.js')
@endsection


@section('content')
    @include('layouts.navbar')
    @include('layouts.page-photo')
    <section class="image-container">

        @foreach ($images as $image)
        <ul>
        <div class="images-post">
            <div class="images-slider">
                <li> <img loading="lazy" class="myImg" data-lazy="{{ asset($image->gallery_path) }}" alt="error"></li>
            </div>
        </div>
        <x-lightbox-modal />
    </ul>
            @endforeach
    </section>
    @include('layouts.footer')
@endsection


