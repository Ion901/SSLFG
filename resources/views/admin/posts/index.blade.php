@vite('resources/css/admin/filterNavbar.css')
<x-dash-app-layout>

    <div class="flex ml-8">
        <x-crud-button :href="route('posts.create')" :add="true">
            Adauga o postare
        </x-crud-button>
        <h1 class="justify-content-sm-center text-center text-3xl m-0 m-auto">Postari</h1>
    </div>

    <x-table-filter
    :tableName="'posts'"
    :id="'post_slug'"
    :columns="[
        'post_title' => 'Titlu',
        'category' => 'Categorie',
        'post_date' => 'Date'
    ]"
    :data="$posts"
    :filters="[
        'post_title' => ['type' => 'text', 'placeholder' => 'Cauta dupa numele postării'],
        'category' => [
            'type' => 'select',
            'options' => $category->pluck('type', 'id')->toArray()
            ],
        'from_date' => ['type' => 'date', 'label' => 'Începând cu:'],
        'to_date' => ['type' => 'date', 'label' => 'Pînă pe:']
    ]"
    :actions="['view' => true, 'edit' => true, 'delete' => true]"
    />


    <div class="flex justify-center mt-3">
        {{ $posts->withQueryString()->links() }}
    </div>
</x-dash-app-layout>
