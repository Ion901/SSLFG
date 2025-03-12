<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
@vite(['resources/css/breadcrumb.css', 'resources/css/admin/combobox.css'])

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
    <form action="{{ route('athlets.update', $premiant->id) }}" method="POST" class="p-4 bg-white shadow-md rounded-lg">
        @csrf
        @method('PUT')
        <div class="mb-4 transition-[scale] duration-500 ease-in-out m-7 p-7" id="modal">

            {{-- <label for="athlet_name" class="text-gray-700 font-bold mb-2">Numele sportivului</label>
                    <select id="athlet_name" name="athlet_name"
                    class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                    <option value=""></option>
                    @foreach ($athlets as $athlet)
                    <option value="{{ $athlet->name }}"
                        {{ $premiant->athlet->fullName == $athlet->fullName ? 'selected' : '' }}>
                        {{ $athlet->fullName }}
                    </option>
                @endforeach
                </select> --}}
            <label for="athlet_name" class="text-gray-700 font-bold mb-2">Numele sportivului</label>

            <input type="hidden" name="athlet_name" id="id_athlet_fetched">
            <select name="athlet_name"
                class="select-picker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <option value="" disabled selected>Numele premiantului</option>
                @foreach ($athlets as $athlet)
                    <option value="{{ $athlet->fullName }}"
                        {{ $premiant->athlet->fullName == $athlet->fullName ? 'selected' : '' }}
                        data-athlet-id="{{ $athlet->id }}">
                        {{ $athlet->fullName }}
                    </option>
                @endforeach
            </select>

            <label for="athlet_weight" name="athlet_weight" class="block text-gray-700 font-bold mb-2">Categoria de
                greutate</label>
            <input type="number" id="athlet_weight" name="athlet_weight"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value={{ $premiant->weight }}>

            <label for="athlet_place" name="athlet_place" class="block text-gray-700 font-bold mb-2">Locul
                ocupat</label>
            <input type="number" id="athlet_place" name="athlet_place"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                value={{ $premiant->place }}>

            <label for="athlet_competition" class="text-gray-700 font-bold mb-2">Numele Competitie</label>
            <select id="athlet_competition" name="athlet_competition"
                class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <option value=""></option>
                @foreach ($competitions as $competition)
                    <option value="{{ $competition->name }}"
                        {{ $premiant->competition->name == $competition->name ? 'selected' : '' }}>
                        {{ $competition->name }}
                    </option>
                @endforeach
            </select>
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
    let selectAthlet = document.querySelector(".select-picker");
    let hiddenAthlet = document.querySelector("#id_athlet_fetched");
    $(selectAthlet).on('change',
        function() { //pentru select2[plugin] interactioneaza cu eventurile diferit, de asta utilizez jquery
            let selectedOption = this.options[this.selectedIndex];
            hiddenAthlet.value = selectedOption.getAttribute("data-athlet-id");
            console.log(selectedOption);

        });



    $(document).ready(function() {
        $(function() {
            $('.select-picker').select2();
        });
    });
</script>
