<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
    crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
@vite('resources/css/admin/create.css')
@vite('resources/js/admin/create.js')

<link href="{{ asset('build/assets/fileinput.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ asset('build/assets/fileinput.js') }}"></script>

<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('addPost') }}
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
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
        class="p-4 bg-white shadow-md rounded-lg">
        @csrf

        {{-- Titlu --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Titlu:</label>
            <input type="text" id="title" name="title"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" value={{ old('title') }}>
        </div>

        {{-- Categorie --}}
        <div class="mb-4">
            <label for="category" class="block text-gray-700 font-bold mb-2">Categorie:</label>
            <select id="category" name="category" id="category"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <option value=""></option>
                @foreach ($categoryes as $category)
                    {{-- <option value="{{ $category->type }}">{{ $category->type }}</option> --}}
                    @if (Request::old('category') === $category->type)
                        <option value="{{ $category->type }}" selected>{{ $category->type }}</option>
                    @else
                        <option value="{{ $category->type}}">{{ $category->type }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="mb-4 hidden w-fit" id="linkModal">
            <p class="text-blue-700 cursor-pointer hover:text-blue-900 underline ">Adaugă detaliile competiției</p>
        </div>

        @if (Request::old('category') != 'SPORT')
        {{-- <div class="mb-4 transition-[scale] duration-500 ease-in-out border border-2 m-7 p-7" id="modal"> --}}
            {{-- @else --}}
        <div class="mb-4 hidden transition-[scale] duration-500 ease-in-out border border-2 m-7 p-7" id="modal">
            @endif
            <label for="competition_name" class="block text-gray-700 font-bold mb-2">Numele Competitie</label>
            <input type="text" id="competition_name" name="competition_name"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value={{ old('competition_name') }}>

            <label for="competition_location" name="competition_location"
                class="block text-gray-700 font-bold mb-2">Locatia competitiei</label>
            <input type="text" id="competition_location" name="competition_location"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value={{ old('competition_location') }}>

            <label for="competition_date" name="competition_date" class="block text-gray-700 font-bold mb-2">Data
                competitiei</label>
            <input type="date" id="competition_date" name="competition_date"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value={{ old('competition_date') }}>

        </div>


        {{-- Text Editor --}}
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Conținutul Postării:</label>
            <textarea type="text" id="content" name="content"
                class="hidden w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                >{{ Request::old('content') ?? old('content') }}</textarea>
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
</script>
