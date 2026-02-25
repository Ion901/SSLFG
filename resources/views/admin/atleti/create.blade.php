<x-dash-app-layout>

    <x-slot name="styles">
        @vite('resources/css/breadcrumb.css')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </x-slot>

    <x-slot name="scripts">
        @vite('resources/js/admin/addCrudFetched.js')
        <script>
            let competitions = @json($competitions);
            let athlets = @json($athlets);
        </script>
    </x-slot>

    <div class="page">
        {{ Breadcrumbs::render('addAthlets') }}
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->getMessages() as $field => $messages)
                    <li>{{ $messages[0] }}</li>
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

    <form action="{{ route('premiants.store') }}" method="POST" class="p-4 bg-white shadow-md rounded-lg">
        @csrf
        <table class="table table-bordered" id="table">
            <tr>
                <th>Numele, Prenumele Sportivului</th>
                <th>Categorie de greutate</th>
                <th>Loc Ocupat</th>
                <th>Competitie</th>
                <th>Actiune</th>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="inputs[0][id_athlet]" class="id_athlet_fetched">
                    <select name="athlet_fullName"
                        class="select-picker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        id="athlet_name">
                        <option value="" disabled selected>Numele premiantului</option>
                        @foreach ($athlets as $athlet)
                            <option value="{{ $athlet->fullName }}" data-athlet-id="{{ $athlet->id }}">
                                {{ $athlet->fullName }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="inputs[0][weight]" placeholder="Greutateta sportivului"
                        class="form-control">
                </td>
                <td>
                    <input type="number" name="inputs[0][place]" placeholder="Loc ocupat" class="form-control">
                </td>
                <td>
                    <input type="hidden" name="inputs[0][id_competition]" class="id_competition_fetched">
                    <select id="competition_name" name="competition_name"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Numele competitiei</option>
                        @foreach ($competitions as $competition)
                            <option value="{{ $competition->name }}" data-competition-id="{{ $competition->id }}">
                                {{ $competition->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button type="button" name="add" id="add" class="btn btn-success">Adaugă
                        sportivi</button>
                </td>
            </tr>
        </table>
        <button type="submit" class="w-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Trimite
        </button>
        <a href="{{ url('/premiants') }}"
            class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
            Anuleaza
        </a>
    </form>

</x-dash-app-layout>
