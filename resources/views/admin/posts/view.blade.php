@vite('resources/css/admin/view.css')
@vite('resources/js/admin/app.js')
<x-dash-app-layout>

    @include('../pages/noutati',['admin'=>'true'])
</x-dash-app-layout>
