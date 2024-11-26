<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créditos - Reporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <th>Lote/ Manzana</th>
                <th>Fecha de Venta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>      
            @foreach($ventas as  $index => $venta)
                <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $venta->contacto->nombre ?? 'Sin contacto' }}</td>
                <td>{{ $venta->lote}}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                    <td>
                        <!-- Botón Editar (solo visual) -->
                        <button 
                            class="btn btn-primary btn-sm" 
                            disabled
                        >
                            Editar
                        </button>

                        <!-- Botón Eliminar (solo visual) -->
                        <button 
                            class="btn btn-danger btn-sm" 
                            disabled
                        >
                            Eliminar
                        </button>

                        <!-- Botón Descargar PDF (solo visual) -->
                        <button 
                            class="btn btn-warning btn-sm" 
                            title="Descargar PDF"
                            disabled
                        >
                            <i class="fas fa-file-pdf"></i>
                        </button>
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
