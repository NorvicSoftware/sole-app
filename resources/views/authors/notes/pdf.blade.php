<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="pdf/css/pdf-style.css">
        <title>PDF NOTAS</title>
    </head>
    <body>
        <div>
            <h1><strong>Notas de autor: {{ $author->full_name }}</strong></h1>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>FECHA DE REGISTRO</th>
                        <th>NOTAS</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime(str_replace('-', '/', $note->writing_date))) }}</td>
                        <td>{{ $note->description }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
