<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Cuotas por Cobrar</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; }
        .header p { margin: 2px; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: center; font-size: 12px; }
        .table th { background-color: #f4f4f4; }
        .totals { margin-top: 20px; font-size: 12px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CONSTRUCTORA FDR</h1>
        <p>Callejón de Quijano #236, Zacatecas</p>
        <p>Teléfono: 492-116-68-35</p>
        <h2>REPORTE TOTAL DE CUOTAS PENDIENTES POR COBRAR</h2>
        <p><strong>{{ $proyecto }}</strong> - {{ $fecha_reporte }}</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Lote - Manzana</th>
                <th>Teléfono</th>
                <th>Fecha Pago</th>
                <th>Tipo Cuota</th>
                <th>Cantidad</th>
                <th>Monto</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuotas as $index => $cuota)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cuota['cliente'] }}</td>
                <td>{{ $cuota['lote_manzana'] }}</td>
                <td>{{ $cuota['telefono'] }}</td>
                <td>{{ $cuota['fecha_pago'] }}</td>
                <td>{{ $cuota['tipo_cuota'] }}</td>
                <td>{{ $cuota['cantidad'] }}</td>
                <td>${{ number_format($cuota['monto'], 2) }}</td>
                <td>${{ number_format($cuota['total'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="totals">
        <p><strong>Total Cuotas:</strong> {{ $totalCuotas }}</p>
        <p><strong>Total Monto:</strong> ${{ number_format($montoTotal, 2) }}</p>
    </div>
</body>
</html>
