<table>
    <thead>
        <tr>
            <th>{{ $data['book']->title }}</th>
        </tr>
        <tr>
            <th>Num</th>
            <th>Fecha</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
    @php $index = 1;  @endphp
    @foreach($data['notes'] as $note)
        <tr>
            <td>{{ $index++ }}</td>
            <td>{{ date('d/m/Y', strtotime(str_replace('-', '/', $note->writing_date))) }}</td>
            <td>{{ $note->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

