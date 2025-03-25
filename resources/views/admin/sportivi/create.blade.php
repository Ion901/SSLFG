<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@vite(['resources/css/breadcrumb.css','resources/js/admin/addCrudAthlets.js'])

<link href="{{ asset('build/assets/yearpicker.css') }}" rel="stylesheet" />
<script src="{{ asset('build/assets/yearpicker.js') }}" async></script>

<x-dash-app-layout>
    <div class="page">
        {{ Breadcrumbs::render('addSportivi') }}
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
    <form action="{{ route('athlets.store') }}" method="POST" class="p-4 bg-white shadow-md rounded-lg">
        @csrf
        <table class="table table-bordered" id="table">
            <tr>
                <th>Numele, Prenumele Sportivului</th>
                <th>Virsta</th>
                <th>Actiune</th>
            </tr>
            <tr>
                <td>
                    <input type="text" id="athlet_fullName" name="inputs[0][athlet_fullName]"
                        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Nume, Prenume" >

                </td>
                <td>
                        <input type="number" id="athlet_birthdate" name="inputs[0][athlet_birthdate]"
                        class="yearpicker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="Anul nasterii" >
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
        <a href="{{ url('/athlets') }}"
            class="w-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
            Anuleaza
        </a>
    </form>
</x-dash-app-layout>
<script>
    $(document).ready(function() {
        $(function() {
            $('.yearpicker').yearpicker();
        });
    })
</script>
