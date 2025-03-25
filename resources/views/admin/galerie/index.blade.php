@vite(['resources/js/galerie.js','resources/css/admin/galerie.css'])
<x-dash-app-layout>
    <section class="image-container">

        @foreach ($gallery as $image)
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
</x-dash-app-layout>
