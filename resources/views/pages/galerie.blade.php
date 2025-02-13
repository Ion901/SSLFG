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
        <!-- Lightbox Modal -->
        <div id="myModal" class="modal">
            <span class="close">&times;</span>
            <img class="modal-content" id="img01">
            <div class="lightbox-nav">
                <span class="prev">&#10094;</span>
                <span class="next">&#10095;</span>
            </div>
        </div>
    </ul>
            @endforeach
    </section>
    @include('layouts.footer')
@endsection


