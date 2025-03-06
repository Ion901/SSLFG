<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('competitions.create')" :add="true">
            Adauga o competiție
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Competiții</h1>
    </div>

<table class="m-0 m-auto table table-bordered table-hover">
    <tr>
        <th>Titlu</th>
        <th>Category</th>
        <th>Date</th>
    </tr>
    @foreach ($competitions as $competition)
    <tr class="border-b-4 border-black mb-2">
            <td class="break-words text-left pr-3">{{$competition->name}}</td>
            <td class="pr-3">{{$competition->location}}</td>
            <td class="pr-3">{{Str::replaceMatches('/\s\d.*/', '', $competition->date) }}</td>
            <td>
                <x-crud-button :href="route('competitions.edit',$competition->id)" :edit="true">
                    Edit
                </x-crud-button>
            </td>
            <td>

                <form action="{{route('competitions.destroy', $competition->id)}}" method="POST" id="delete">
                    @csrf
                    @method('DELETE')
                    <x-crud-button :delete="true"  onclick="return confirm('Esti sigur ca vrei sa stergi aceasta competitie?')">
                        Delete
                    </x-crud-button>
                </form>

            </td>
    </tr>
    @endforeach
</table>
<div class="flex justify-center mt-3">
    {{ $competitions->links() }}
</div>
</x-dash-app-layout>
