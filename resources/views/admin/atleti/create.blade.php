<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<link href="{{ asset('build/assets/yearpicker.css') }}" rel="stylesheet" />
<script src="{{ asset('build/assets/yearpicker.js') }}" async></script>

@vite(['resources/css/breadcrumb.css', 'resources/js/admin/addCrud.js'])


<x-dash-app-layout>
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
                {{-- <th>Virsta</th> --}}
                <th>Categorie de greutate</th>
                <th>Loc Ocupat</th>
                <th>Competitie</th>
                <th>Actiune</th>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="inputs[0][id_athlet]" class="id_athlet_fetched">
                    <select name="athlet_fullName" class="select-picker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500" id="athlet_name">
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

<script>

    //pass the entire collection to the script via directive json
    let competitions = @json($competitions);
    let athlets = @json($athlets);

    $(document).ready(function() {
    $(function() {
    $('.select-picker').select2();
    });
});
</script>
