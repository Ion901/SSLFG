<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
@vite('resources/css/breadcrumb.css')

<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('addCompetition') }}
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
    <form action="{{ route('competitions.store') }}" method="POST" class="p-4 bg-white shadow-md rounded-lg">
        @csrf
        <div class="mb-4 transition-[scale] duration-500 ease-in-out m-7 p-7" id="modal">
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
        <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trimite
        </button>
        <a href="{{ url('/competitions') }}"
            class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
            Anuleaza
        </a>
    </form>
</x-dash-app-layout>
