<x-dash-app-layout>
    <x-slot name="scripts">
        @vite(['resources/css/admin/view.css','resources/js/noutati.js'])
    </x-slot>

    <x-admin.news-post :post=$post />

    {{-- @include('../pages/noutati',['admin'=>'true','post'=>$post]) --}}
</x-dash-app-layout>
