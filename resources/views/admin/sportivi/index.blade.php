<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('athlets.create')" :add="true">
            Adauga sportivi
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Sportivi</h1>
    </div>

<table class="m-0 m-auto table table-bordered table-hover">
    <tr>
        <th class="pr-5">Nume</th>
        <th class="pr-5">Virsta</th>
        <th class="pr-5" colspan="2">Actiuni</th>

    </tr>
    @foreach ($athlets as $athlet)
    <tr class="border-b-4 border-black mb-2">
            <td class="break-words text-left pr-3">{{$athlet->fullName}}</td>
            <td class="pr-3 text-center">{{$athlet->age}}</td>
            <td>
                <x-crud-button :href="route('athlets.edit',$athlet->id)" :edit="true">
                    Edit
                </x-crud-button>
            </td>
            <td>

                <form action="{{route('athlets.destroy', $athlet->id)}}" method="POST" id="delete">
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
