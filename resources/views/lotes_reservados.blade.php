<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Lotes Reservados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1, .header h2 {
            margin: 0;
        }
        .header h1 {
            font-size: 16px;
        }
        .header h2 {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CONSTRUCTORA FDR</h1>
        <h2>CALLEJÓN DE QUIJANO #236 - ZACATECAS</h2>
        <h3>Teléfono: 492-161-68-35</h3>
        <h2>{{ $proyecto }}</h2>
        <h3>LISTA DE LOTES RESERVADOS AL {{ $fecha_reporte }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>ASESOR</th>
                <th>CLIENTE</th>
                <th>LOTE - MANZANA</th>
                <th>F.FIRMA</th>
                <th>MONTO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as $index => $lote)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lote['asesor'] }}</td>
                    <td>{{ $lote['cliente'] }}</td>
                    <td>{{ $lote['lote_manzana'] }}</td>
                    <td>{{ $lote['fecha_firma'] }}</td>
                    <td>${{ number_format($lote['monto'], 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5">TOTAL</td>
                <td>${{ number_format($totalMonto, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
