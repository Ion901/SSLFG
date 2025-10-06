 @props(['post'])

 <section class="sectionjj" id="section">
        <a href="{{ url('/posts') }}"
            class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">Inapoi</a>
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
                @if ($post->image->isNotEmpty())
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
                                    <img loading="lazy" class="myImg" data-index="{{ $index }}"
                                        src="{{ asset($image) }}" alt="error">
                                </div>
                            @endforeach
                        </div>

                        <x-lightbox-modal />
                    @endif
                </div>
            </div>
        </div>
    </section>
