@props(['tableName','filters'])
<div class="m-auto">
    <form action="{{ route($tableName) }}" method="GET">
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
