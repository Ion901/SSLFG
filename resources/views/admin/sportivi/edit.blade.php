<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@vite('resources/css/breadcrumb.css')
<link href="{{ asset('build/assets/yearpicker.css') }}" rel="stylesheet" />
<script src="{{ asset('build/assets/yearpicker.js') }}" async></script>

<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('editAthlet') }}
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
        <form action="{{ route('athlets.update',$athlet->id) }}" method="POST" class="p-4 bg-white shadow-md rounded-lg">
            @csrf
            @method('PATCH')
            <div class="mb-4 transition-[scale] duration-500 ease-in-out m-7 p-7" id="modal">
                <label for="athlet_fullName" class="block text-gray-700 font-bold mb-2">Numele complet al sportivului</label>
                <input type="text" id="athlet_fullName" name="athlet_fullName"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                    value="{{ $athlet->fullName}}">

                <label for="athlet_birthdate" name="athlet_birthdate" class="block text-gray-700 font-bold mb-2">Data
                    competitiei</label>
                    <input type="number" id="athlet_birthdate" name="athlet_birthdate"
                    class="yearpicker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                    placeholder="Anul nasterii">
            </div>
            <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Trimite
            </button>
            <a href="{{ url('/athlets') }}"
                class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
                Anuleaza
            </a>
        </form>
</x-dash-app-layout>
<script>
    $(document).ready(function() {
        $(function() {
            $('.yearpicker').yearpicker({
                year:{!! json_encode($athlet->age) !!}
            });
        });
    })
</script>
