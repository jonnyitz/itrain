<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conceptos - Constructora FDR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Conceptos - Constructora FDR</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar concepto...">
    </div>

    <!-- Botón para agregar nuevo concepto -->
    <div class="mb-3 text-end">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoConceptoModal">Nuevo Concepto</button>
    </div>

    <!-- Tabla de conceptos -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Concepto</th>
                <th>Tipo de Concepto</th>
                <th>Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($conceptos as $index => $concepto)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $concepto->concepto }}</td>
                    <td>{{ $concepto->tipo_concepto }}</td>
                    <td>{{ $concepto->created_at->format('d-m-Y') }}</td>
                    <td>
                        <form action="{{ route('conceptos.destroy', $concepto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este concepto?')">Eliminar</button>
                        </form>
                        <a href="{{ route('conceptos.edit', $concepto->id) }}" class="btn btn-warning btn-lg">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para agregar nuevo concepto -->
<div class="modal fade" id="nuevoConceptoModal" tabindex="-1" aria-labelledby="nuevoConceptoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoConceptoModalLabel">Registrar Nuevo Concepto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('conceptos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Concepto</label>
                        <input type="text" name="concepto" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipo de Concepto</label>
                        <input type="text" name="tipo_concepto" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
