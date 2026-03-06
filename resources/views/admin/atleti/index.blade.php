<x-dash-app-layout>

    <x-slot name="scripts">
        @vite('resources/js/admin/pickerImplementation.js')
    </x-slot>

    <x-slot name="styles">
        @vite('resources/css/admin/filterNavbar.css')
    </x-slot>

    <div class="flex ml-8">
        <x-crud-button :href="route('premiants.create')" :add="true">
            Adauga premiantii
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-auto">Premianți</h1>
    </div>

    <x-table-filter :tableName="'premiants'" :id="'id'" :columns="[
        'fullName' => 'Nume',
        'age' => 'Virsta',
        'weight' => 'Categorie',
        'place' => 'Loc ocupat',
        'competitionName' => 'Competiție',
        'date' => 'Date'
    ]" :data="$athletes" :filters="[
        'fullName' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele premiantului', 'width' => '180px'],
        'age' => ['type' => 'number', 'class' => 'yearpicker', 'placeholder' => 'Cauta dupa anul nasterii'],
        'weight' => ['type' => 'number', 'placeholder' => 'Cauta dupa greutate', 'min' => '20'],
        'place' => ['type' => 'number', 'placeholder' => 'Cauta dupa loc ocupat', 'min' => '0'],
        'competition' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele competiției'],
        'date' => ['type' => 'date', 'label' => 'Data']
    ]"
        :actions="['view' => false, 'edit' => true, 'delete' => true]" />

    <div class="flex justify-center mt-3">
        {{ $athletes->withQueryString()->links() }}
    </div>
</x-dash-app-layout>
