

<table id="dataTable">
    <thead>
        <tr>
            <th>Nume, Prenume</th>
            <th>Titluri Obtinute</th>
            <th>Anul Performantei</th>
            <th>Competitie</th>
        </tr>
    </thead>
    <tbody>
      @foreach ($campioni as $campion)
    @php
        $colspan = !$campion->year ? 3 : null;
    @endphp
    <tr>
        <td>{{ $campion->name }}</td>
        <td {!! $colspan ? "colspan=\"$colspan\"" : "" !!}>{{ $campion->titles }}</td>
        @if($campion->year)
                    <td {!! !$campion->competition ? 'colspan=2' : null !!}>{{ $campion->year }}</td>
                @endif
                @if($campion->competition)
                    <td >{{ $campion->competition }}</td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination">
    <button id="btnPrev">Previous</button>
    <span id="pageInfo"></span>
    <button id="btnNext">Next</button>
</div>
