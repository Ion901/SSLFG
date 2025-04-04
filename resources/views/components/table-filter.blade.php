<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="{{ asset('build/assets/yearpicker.css') }}" rel="stylesheet" />
<script src="{{ asset('build/assets/yearpicker.js') }}" async></script>
@props(['tableName','id','columns','data','filters'=>[], 'actions' => []])

<div class="m-0 m-auto">
    <form action="{{route("$tableName")}}" method="GET">
    <div class="filter-container">
        @foreach ($filters as $key => $filter)
            @if($filter['type'] === "text")
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass" id="searchIcon"></i>
                    <input type="text" name="{{$key}}" class="form-control" placeholder="{{$filter['placeholder']}}" value="{{request($key)}}" style="width:{{$filter['width'] ?? null}}">
                </div>
            @elseif ($filter['type'] === 'select' && isset($filter['options']))
            <div class="select-category">
                <select name="{{$key}}" id="{{$key}}">
                    <option value="" selected >Alege categoria</option>
                    @foreach ($filter['options'] as $value  => $name)
                    <option value="{{$value}}"{{ request($key) == $value ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach

                </select>
            </div>
            @elseif($filter['type'] === "date")
            <div class="date-filter">
                <label for="{{ $key }}">{{ $filter['label'] }}</label>
                <input type="date" id="{{ $key }}" name="{{ $key }}" value="{{ request($key) }}">
            </div>
            @elseif($filter['type'] === 'number' && isset($filter['class']))
            <div class="year-search">
                <input type="{{$filter['type']}}" id="{{$key}}" name="{{ $key }}"
                        class="yearpicker w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        placeholder="{{$filter['placeholder']}}" value="{{ old($key, request($key)) }}">
            </div>
            @elseif($filter['type'] === 'number')
            <div class="weight-search">
                <input type="{{$filter['type']}}" id={{$key}} name="{{$key}}" placeholder="{{$filter['placeholder']}}" min="{{$filter['min']}}" value="{{request($key)}}">
            </div>
            @endif
        @endforeach
            <button type="submit" class="find-search">Caută</button>
        </div>

    </form>
</div>

<table class="m-0 m-auto table table-bordered table-hover">
    <tr>
        @foreach ($columns as $column)
        <th>{{$column}}</th>
        @endforeach
    </tr>
    @forelse ($data as $row)
    {{-- {{dd($row['id'])}} --}}
        <tr class="border-b-4 border-black mb-2">
            @foreach ($columns as $key => $value )

                @if($key === 'post_title')
                    <td class="break-words text-left pr-3">{{ $row[$key] }}</td>
                @elseif($value === 'Date')
                    <td class="pr-3">{{ Str::replaceMatches('/\s\d.*/', '', $row[$key]) }}</td>
                @else
                    <td class="pr-3">{{ $row[$key] }}</td>
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
