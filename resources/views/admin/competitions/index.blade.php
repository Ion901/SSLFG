@vite('resources/css/admin/filterNavbar.css')
<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('competitions.create')" :add="true">
            Adauga o competiție
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Competiții</h1>
    </div>

    <x-table-filter
    :tableName="'competitions'"
    id="id"
    :columns="[
        'name' => 'Titlu',
        'location' => 'Locatie',
        'date' => 'Date'
    ]"
    :data="$competitions"
    :filters="[
        'name' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele competiției'],
        'location' => ['type' => 'text','placeholder' => 'Cauta dupa numele orașului'],
        'from_date' => ['type' => 'date', 'label' => 'Începând cu:'],
        'to_date' => ['type' => 'date', 'label' => 'Pînă pe:']
    ]"
    :actions="['view' => false, 'edit' => true, 'delete' => true]"
    />

<div class="flex justify-center mt-3">
    {{ $competitions->withQueryString()->links() }}
</div>
</x-dash-app-layout>
