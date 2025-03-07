<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créditos - Reporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Reporte de Créditos</h1>
     <!-- Barra de búsqueda -->
     <input 
        type="text" 
        id="searchInput" 
        class="form-control" 
        placeholder="Buscar por contacto, lote o fecha de venta...">

    <!-- Tabla para mostrar Contacto, Lote y Fecha de Venta -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Lote/Manzana</th>
                <th>Sig. CP.</th> <!-- Nueva columna -->
                <th>#SCP</th> <!-- Nueva columna -->
                <th>M.Cuota P.</th> <!-- Nueva columna -->
                <th> M. Restante</th> <!-- Nueva columna -->
                <th>Total Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>      
            @foreach($ventas as  $index => $venta)
                <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $venta->contacto->nombre ?? 'Sin contacto' }}</td>
                <td>                
                    @if($venta->lote)
                    <div>Lote: {{ $venta->lote->lote }}</div>
                    <div>Manzana: {{ $venta->lote->manzana ? $venta->lote->manzana->nombre : 'No disponible' }}</div>
                    @else
                    <div>No asignado</div>
                    @endif
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($venta->fecha_venta)->addMonth()->format('d/m/Y') }} <!-- Agrega un mes -->
                </td>
                <td>
                    {{ $venta->cantidad_pagos ?? 'N/A' }} <!-- Mostrar la cantidad de pagos -->
                </td>
                <td>
                    ${{ number_format($venta->enganche, 2) ?? '0.00' }}
                </td>
                <td>
                    ${{ number_format($venta->precio_venta_final - $venta->enganche, 2) }}
                </td>
                <td>
                    ${{ number_format($venta->precio_venta_final, 2) }}
                </td>
                    <td>
                        <!-- Botón Descargar PDF (solo visual) -->
                        <a href="{{ route('ventas.pagare', $venta->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-invoice"></i> 
                        </a>
                      <!-- Botón para Ver Cronograma en PDF -->
                        <a href="{{ route('ventas.cronograma', $venta->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-calendar-alt"></i> Ver Cronograma
                        </a>
                        <a href="{{ route('ventas.descargarPDF', ['id' => $venta->id]) }}" 
                        class="btn btn-primary" 
                        style="padding: 8px; text-decoration: none; color: white; background-color: #007bff; border-radius: 4px;">
                            <i class="fas fa-dollar-sign"></i>
                        </a>
                        @if($venta->modalidad_enganche == 2 || $venta->credito) 
                        <a href="{{ route('creditos.enganche', $venta->id) }}" 
                        style="display: inline-block; width: 20px; height: 10px; background-color: rgb(128, 0, 128); color: black; border-radius: 3px; text-decoration: none;"
                        target="_blank">
                        </a>
                        @endif
                        <a href="{{ route('estado_de_cuenta', $venta->id) }}" class="btn btn-danger">
                            <i class="fas fa-file-pdf"></i> E.C
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#ventasTable tbody tr');

        searchInput.addEventListener('keyup', function () {
            const query = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                if (rowText.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
</body>
</html>
