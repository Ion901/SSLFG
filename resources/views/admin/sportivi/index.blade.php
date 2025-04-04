@vite('resources/css/admin/filterNavbar.css')
<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('athlets.create')" :add="true">
            Adauga sportivi
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Sportivi</h1>
    </div>

    <x-table-filter
    :tableName="'athlets'"
    :id="'id'"
    :columns="[
        'fullName' => 'Nume',
        'age' => 'Virsta',
    ]"
    :data="$athlets"
    :filters="[
        'fullName' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele sportivului'],
        'age' => ['type' => 'number','class' => 'yearpicker', 'placeholder' => 'Cauta dup anul nasterii'],
    ]"
    :actions="['view' => false, 'edit' => true, 'delete' => true]"
    />

<div class="flex justify-center mt-3">
    {{ $athlets->withQueryString()->links() }}
</div>
</x-dash-app-layout>
