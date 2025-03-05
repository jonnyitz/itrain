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
        <table class="table table-bordered table-striped">       
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Moneda</th>
                    <th>Total de Lotes</th>
                    <th>Lotes Disponibles</th>
                    <th>Estado</th>
                    <th>Imagen</th>
                    <th>Propietario</th> <!-- Campo propietario agregado -->
                    <th>Parcela</th> <!-- Campo parcela agregado -->
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
                            <img src="{{ asset($proyecto->imagen) }}" alt="Imagen del proyecto" width="80">
                        @else
                            Sin imagen
                        @endif

                        </td>
                        <td>{{ $proyecto->propietario }}</td> <!-- Mostrar propietario -->
                        <td>{{ $proyecto->parcela }}</td> <!-- Mostrar parcela -->
                        <td>
                        <a href="{{ route('proyectos.edit', $proyecto->id) }}" class="btn btn-warning">Editar Proyecto</a>
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
        <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProjectModalLabel">Agregar Nuevo Proyecto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('proyectos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre del Proyecto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                            <div class="form-group">
                                <label for="moneda">Moneda</label>
                                <input type="text" class="form-control" id="moneda" name="moneda" required>
                            </div>
                            <div class="form-group">
                                <label for="total_lotes">Total de Lotes</label>
                                <input type="number" class="form-control" id="total_lotes" name="total_lotes" required>
                            </div>
                            <div class="form-group">
                                <label for="lotes_disponibles">Lotes Disponibles</label>
                                <input type="number" class="form-control" id="lotes_disponibles" name="lotes_disponibles" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="activo">EN VENTA</option>
                                    <option value="inactivo">VENDIDO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen del Proyecto</label>
                                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="propietario">Propietario</label>
                                <input type="text" class="form-control" id="propietario" name="propietario" required>
                            </div>

                            <div class="form-group">
                                <label for="parcela">Parcela</label>
                                <input type="text" class="form-control" id="parcela" name="parcela" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editProjectModal = document.getElementById('editProjectModal');
            editProjectModal.addEventListener('show.bs.modal', (event) => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const ubicacion = button.getAttribute('data-ubicacion');
                const moneda = button.getAttribute('data-moneda');
                const totalLotes = button.getAttribute('data-total_lotes');
                const lotesDisponibles = button.getAttribute('data-lotes_disponibles');
                const estado = button.getAttribute('data-estado');
                const imagen = button.getAttribute('data-imagen');

                // Establecer la acción del formulario
                document.getElementById('editProjectForm').action = `/proyecto-ajustes/${id}`;

                // Llenar los campos del formulario
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_ubicacion').value = ubicacion;
                document.getElementById('edit_moneda').value = moneda;
                document.getElementById('edit_total_lotes').value = totalLotes;
                document.getElementById('edit_lotes_disponibles').value = lotesDisponibles;
                document.getElementById('edit_estado').value = estado;

                // Actualizar la vista previa de la imagen actual
                const currentImage = document.getElementById('current_image');
                if (imagen) {
                    currentImage.src = `/storage/${imagen}`;
                } else {
                    currentImage.src = '/path/to/default/image.jpg'; // Imagen predeterminada
                }
            });
        });
    </script>
</body>
</html>
