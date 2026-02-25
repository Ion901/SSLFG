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
                <td data-label="Nume, Prenume:">{{ $campion->name }}</td>
                <td data-label="Titluri Obtinute:" {!! $colspan ? "colspan=\"$colspan\"" : '' !!}>{{ $campion->titles }}</td>
                @if ($campion->year)
                    <td data-label="Anul Performantei:" {!! !$campion->competition ? 'colspan=2' : null !!}>{{ $campion->year }}</td>
                @endif
                @if ($campion->competition)
                    <td data-label="Competitie:" >{{ $campion->competition }}</td>
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
