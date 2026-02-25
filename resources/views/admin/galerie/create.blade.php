<x-dash-app-layout>

    <x-slot name="styles">
        @vite('resources/css/breadcrumb.css')
    </x-slot>

    <div class="page">
        {{ Breadcrumbs::render('addPhoto') }}
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
    <form action="{{ route('gallery.store') }}" method="POST" class="p-4 bg-white shadow-md rounded-lg"
        enctype="multipart/form-data">
        @csrf
        <div class="card p-4">
            <h2>Selectati imagini pentru galeria foto</h2>

            <div class="row">
                <div class="col">
                    <input id="photo1" name="photo[]" type="file" class="file" multiple data-show-upload="true"
                        data-show-remove="true" data-show-caption="true"
                        data-fileinput-options='{"maxFileCount":13,"showUpload":false,"showRemove":true}'
                        data-msg-placeholder="Select {files} pentru postare...">

                </div>
            </div>
        </div>

        {{-- Buton Submit --}}
        <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trimite
        </button>
        <a href="{{ url('/gallery') }}"
            class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
            Anuleaza
        </a>
    </form>
</x-dash-app-layout>
