<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="{{ asset('build/assets/yearpicker.css') }}" rel="stylesheet" />
<script src="{{ asset('build/assets/yearpicker.js') }}" async></script>
@props(['tableName','id','columns','data','filters'=>[], 'actions' => []])

<x-filter-data :$tableName :$filters/>

<table class="m-0 m-auto table table-bordered table-hover">
    <tr>
        @foreach ($columns as $column)
        <th>{{$column}}</th>
        @endforeach
    </tr>
    @forelse ($data as $row)

        <tr class="border-b-4 border-black mb-2">
            @foreach ($columns as $key => $value )

                @if($key === 'post_title')
                    <td class="break-words text-left pr-3">{{ $row[$key] }}</td>
                @elseif($value === 'Date')
                    <td class="pr-3">{{ Str::replaceMatches('/\s\d.*/', '', $row[$key]) }}</td>
                @else
                    <td class="pr-3">{{ $key == "category" ? $row[$key]['type'] : $row[$key] }}</td>
                @endif
            @endforeach
            <td class="select-none">
                <x-crud-button :href="route($tableName . '.show', $row[$id])" :view="$actions['view']">
                    View
                </x-crud-button>
            </td>

            <td class="select-none">
                <x-crud-button :href="route($tableName . '.edit', $row[$id])" :edit="$actions['edit']">
                    Edit
                </x-crud-button>
            </td>

            <td class="select-none">
                <form action="{{ route($tableName . '.destroy', $row[$id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                    @csrf
                    @method('DELETE')
                    <x-crud-button type="submit" :delete="$actions['delete']">
                        Delete
                    </x-crud-button>
                </form>
            </td>


        </tr>
    @empty
    <tr>
        <td colspan="{{ count($columns) + ($actions ? 1 : 0) }}" class="text-center py-4">Nu există date disponibile.</td>
    </tr>
    @endforelse

</table>
<script>
    //  $(document).ready(function() {
        $(function() {
            $('.yearpicker').each(function() {
            const initialValue = $(this).val();
            $(this).yearpicker(); // Initialize the yearpicker
            $(this).val(initialValue); // Restore the initial value
        });
        });
    // })
</script>
