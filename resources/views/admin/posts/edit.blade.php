<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
    crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"> </script>
@vite('resources/css/admin/create.css')
@vite(['resources/js/admin/create.js','resources/js/admin/editPost.js'])


<link href="{{ asset('build/assets/fileinput.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ asset('build/assets/fileinput.js') }}"></script>

<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('editPost') }}
    </div>
    @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @elseif(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        {{-- {{dd($post->post_slug)}} --}}
        <section class="p-4 bg-white shadow-sm rounded-lg">
    <form action="{{ route('posts.update', $post->post_slug) }}" method="POST" enctype="multipart/form-data"
        class="p-4 bg-white shadow-none rounded-lg">
        @csrf
        @method('PATCH')

        {{-- Titlu --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Titlu:</label>
            <input type="text" id="title" name="title"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" value="{{ htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8')}}">
        </div>

        {{-- Categorie --}}
        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-bold mb-2">Categorie:</label>
            <select id="category" name="category" id="category"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <option value=""></option>
                @foreach ($categoryes as $category)
                <option value="{{ $category->type }}"
                    {{ $post->categoryType ===  $category->type ? 'selected' : '' }}>
                    {{ $category->type }}
                </option>
            @endforeach
            </select>
        </div>

        <div class="mb-4 hidden w-fit" id="linkModal">
            <p class="text-blue-700 cursor-pointer hover:text-blue-900 underline ">Adaugă detaliile competiției</p>
        </div>

        @if ($post->categoryType === "SPORT")
        <div class="mb-4 transition-[scale] duration-500 ease-in-out  border-2 m-7 p-7" id="modal">
            @else
        <div class="mb-4 hidden transition-[scale] duration-500 ease-in-out  border-2 m-7 p-7" id="modal">
            @endif
            <div class="competition">
                <input type="hidden" name="id_competition_fetched" id="id_competition_fetched">
                <div class="combobox"><div>
                    <label for="competition_name" class="text-gray-700 font-bold mb-2">Numele Competitie</label>
                    <select id="competition_name" name="competition_name"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" onchange="document.getElementById('competition_input').value=this.value">
                    <option value=""></option>
                    @foreach ($competitions as $competition)
                    <option value="{{ $competition->name }}"
                        {{ $post->categoryType === "SPORT" && $post->competitionDetails->name == $competition->name ? 'selected' : '' }}>
                        {{ $competition->name }}
                    </option>
                @endforeach
                </select>
                <input type="text" id="competition_input"
                value="{{ $post->competitionDetails->name ?? '' }}" name="competition_name"
                onchange="document.getElementById('competition_name').value = this.value"
                 />
                </div></div>
            </div>
        <div class="competition">
            <div class="combobox2"><div>
                <label for="competition_location" class="block text-gray-700 font-bold mb-2">Locatia competitiei</label>
                <select id="competition_location" name="competition_location"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" onchange="document.getElementById('competition_location_input').value=this.value">
                <option value=""></option>
                @foreach ($competitions as $competition)
                <option value="{{ $competition->location }}"
                    {{ $post->categoryType === "SPORT" && $post->competitionDetails->location == $competition->location ? 'selected' : '' }}>
                    {{ $competition->location }}
                </option>
            @endforeach
            </select>
            <input type="text" id="competition_location_input"
            value="{{ $post->competitionDetails->location ?? '' }}" name="competition_location"
            onchange="document.getElementById('competition_location').value = this.value"
            onselect="document.getElementById('competition_location').value = this.value"/>
            </div></div>
        </div>

            <label for="competition_date" name="competition_date" class="block text-gray-700 font-bold mb-2">Data
                competitiei</label>
            <input type="date" id="competition_date" name="competition_date"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value="{{ $post->categoryType === 'SPORT' && $post->competitionDetails ? $post->competitionDetails->formatted_date : '' }}">
                {{-- {{dd($post->competitionDetails->date)}} --}}
        </div>


        {{-- Text Editor --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Conținutul Postării:</label>
            <textarea type="text" id="content" name="content"
                class="hidden w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                >{!! $post->post_content !!}</textarea>
            {{-- <div id="content" class="h-fit">{!! old('content') !!}</div> --}}
        </div>

        {{-- Selector de imagini --}}
        <div class="card p-4">
            <h2>Selectati imagini pentru galeria foto</h2>

            <div class="row">
                <div class="col">
                    <input id="photo1" name="photo[]" type="file" class="file" multiple data-show-upload="true"
                        data-show-remove="true" data-show-caption="true"
                        data-msg-placeholder="Select {files} pentru postare...">

                </div>
            </div>
        </div>

        {{-- Buton Submit --}}
        <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trimite
        </button>
        <a href="{{ url('/posts') }}" class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
            Anuleaza
        </a>
    </form>

        {{-- Editor Imagini --}}
        <div class="mt-4 flex flex-row w-100">
            <div class="images-post gap-[6px]">
                @foreach ($post->images as $index => $image)
                <div class="flex flex-col w-[300px]">
                    <div class="images-slider w-[300px]">
                        <img loading="lazy" class="myImg " data-index="{{ $index }}" src="{{ asset($image->image_path) }}" alt="error">
                    </div>
                    <div class="bg-gray-500 p-2 flex flex-wrap items-end">
                        <form action="{{route('posts.update',$post->post_slug)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="custom-file mb-1 ">
                                <input type="file" class="custom-file-input" accept="image/*" id="customFile" name="images">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                <input type="hidden" name="imageId" value="{{$image->id}}">
                            </div>
                                <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Actualizează
                                </button>
                                <button type="button" class="clear-file w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 ml-2.5 rounded">
                                    Anuleaza
                                </button>
                        </form>
                        <form action="{{route('posts.destroy', $post->post_slug)}}" method="POST" id="delete">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="imageId" value="{{$image->id}}">
                            <button type="submit"
                            class="clear-file w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                            onclick="return confirm('Esti sigur ca vrei sa stergi aceasta poza?')">
                                Sterge
                            </button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>

            <x-lightbox-modal />
        </div>

    </section>


</x-dash-app-layout>
{{-- Edit text and multiple image js --}}
<script>
    ClassicEditor.create(document.querySelector('#content'), {
            toolbar: ['heading', 'undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'blockquote',
                'link'
            ]
        })
        .catch(error => {
            console.error(error);
        });


    $(document).ready(function() {
        $("#photo1").fileinput({
            maxFileCount: 13
        });
    });


        $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $(".clear-file").on("click", function () {
        var fileInput = $(this).closest("form").find(".custom-file-input");
        var fileLabel = $(this).closest("form").find(".custom-file-label");

        fileInput.val(""); // Clear only this specific input
        fileLabel.removeClass("selected").html("Choose file"); // Reset label
    });




</script>

