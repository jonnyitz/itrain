<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conceptos - Constructora FDR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Conceptos - Constructora FDR</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input type="text" class="form-control" placeholder="Buscar concepto...">
    </div>

    <!-- Botón para agregar nuevo concepto -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" data-toggle="modal" data-target="#nuevoConceptoModal">Nuevo Concepto</button>
    </div>

    <!-- Tabla de conceptos -->
    <table class="table table-bordered">
        <thead class="thead-dark">
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
                        <button class="btn btn-warning btn-sm">Editar</button>
                          <!-- Botón para PDF -->
                        <button class="btn btn-warning btn-sm" title="Descargar PDF">
                            <i class="fas fa-file-pdf"></i>
                        </button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('conceptos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Concepto</label>
                        <input type="text" name="concepto" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de Concepto</label>
                        <input type="text" name="tipo_concepto" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
