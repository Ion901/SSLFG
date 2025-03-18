<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('premiants.create')" :add="true">
            Adauga premiantii
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Premianți</h1>
    </div>

<table class="m-0 m-auto table table-bordered table-hover">
    <tr>
        <th class="pr-5">Nume</th>
        <th class="pr-5">Virsta</th>
        <th class="pr-5">Categorie</th>
        <th class="pr-5">Loc ocupat</th>
        <th class="pr-5">Competitie</th>
    </tr>
    @foreach ($athlets as $athlet)
    <tr class="border-b-4 border-black mb-2">
            <td class="break-words text-left pr-3">{{$athlet->athlet->fullName}}</td>
            <td class="pr-3 text-center">{{$athlet->athlet->age}}</td>
            <td class="pr-3 text-center">{{$athlet->weight}}</td>
            <td class="pr-3 text-center">{{$athlet->place}}</td>
            <td class="pr-3">{{$athlet->competition->name}}</td>
            <td>
                <x-crud-button :href="route('premiants.edit',$athlet->id)" :edit="true">
                    Edit
                </x-crud-button>
            </td>
            <td>

                <form action="{{route('premiants.destroy', $athlet->id)}}" method="POST" id="delete">
                    @csrf
                    @method('DELETE')
                    <x-crud-button :delete="true"  onclick="return confirm('Esti sigur ca vrei sa stergi acest sportiv?')">
                        Delete
                    </x-crud-button>
                </form>

            </td>
    </tr>
    @endforeach
</table>
<div class="flex justify-center mt-3">
    {{ $athlets->links() }}
</div>
</x-dash-app-layout>
