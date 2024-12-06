<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2 class="title">Lista de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Dirección</th>
                <th>CURP/RFC</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contactos as $contacto)
            <tr>
                <td>{{ $contacto->id }}</td>
                <td>{{ $contacto->nombre }}</td>
                <td>{{ $contacto->direccion }}</td>
                <td>{{ $contacto->curp_rfc }}</td>
                <td>{{ $contacto->telefono }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
