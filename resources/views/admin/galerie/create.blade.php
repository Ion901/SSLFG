<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.6/jquery.min.js"></script>

<!-- Bootstrap 5 (Make sure there is no Bootstrap 4) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
    crossorigin="anonymous">

<!-- FileInput CSS & JS -->
<link href="{{ asset('build/assets/fileinput.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('build/assets/fileinput.js') }}"></script>

@vite(['resources/js/admin/fileinput-custom.js','resources/css/breadcrumb.css'])
<x-dash-app-layout>
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
    <form action="{{ route('gallery.store') }}" method="POST" class="p-4 bg-white shadow-md rounded-lg" enctype="multipart/form-data">
        @csrf
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
    <a href="{{ url('/gallery') }}" class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
        Anuleaza
    </a>
    </form>
</x-dash-app-layout>

<script>
    $(document).ready(function() {
        $("#photo1").fileinput({
            maxFileCount: 13,
            showUpload: false,
            showRemove: true
        });
    });
</script>
