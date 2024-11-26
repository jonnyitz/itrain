<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes de Proyectos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Ajustes de Proyectos</h1>

        <!-- Botón para abrir el modal -->
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                Agregar Nuevo Proyecto
            </button>
        </div>

        <!-- Tabla de proyectos -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Moneda</th>
                    <th>Total de Lotes</th>
                    <th>Lotes Disponibles</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proyectos as $index => $proyecto)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $proyecto->nombre }}</td>
                        <td>{{ $proyecto->ubicacion }}</td>
                        <td>{{ $proyecto->moneda }}</td>
                        <td>{{ $proyecto->total_lotes }}</td>
                        <td>{{ $proyecto->lotes_disponibles }}</td>
                        <td>
                            <span class="badge bg-{{ $proyecto->estado == 'activo' ? 'success' : 'danger' }}">
                                {{ $proyecto->estado }}
                            </span>
                        </td>
                        <td>
                            @if($proyecto->imagen)
                                <img src="{{ asset('storage/' . $proyecto->imagen) }}" alt="Imagen del proyecto" width="80">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('proyecto-ajustes.destroy', $proyecto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar un nuevo proyecto -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProjectModalLabel">Agregar Nuevo Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('proyecto-ajustes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="moneda" class="form-label">Moneda</label>
                            <input type="text" class="form-control" id="moneda" name="moneda" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_lotes" class="form-label">Total de Lotes</label>
                            <input type="number" class="form-control" id="total_lotes" name="total_lotes" required>
                        </div>
                        <div class="mb-3">
                            <label for="lotes_disponibles" class="form-label">Lotes Disponibles</label>
                            <input type="number" class="form-control" id="lotes_disponibles" name="lotes_disponibles" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado" required>
                                <option value="activo">EN VENTA</option>
                                <option value="inactivo">VENDIDO</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del Proyecto</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
