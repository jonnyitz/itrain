<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Manzanas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Registrar Manzanas</h1>

         <!-- Barra de búsqueda -->
         <div class="mb-4">
            <input type="text" id="searchBar" class="form-control" placeholder="Buscar por nombre o proyecto">
        </div>

        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#nuevoManzanaModal">
            Nuevo
        </button>

        <!-- Modal -->
        <div class="modal fade" id="nuevoManzanaModal" tabindex="-1" aria-labelledby="nuevoManzanaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoManzanaModalLabel">Registrar Manzana</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario dentro del modal -->
                        <form action="{{ route('manzanas.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre de la Manzana</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre de la manzana" required>
                            </div>
                            <div class="form-group">
                                <label for="vendedor">Vendedor:</label>
                                <input type="text" name="vendedor" id="vendedor" class="form-control" value="{{ old('vendedor') }}">
                            </div>
                            <div class="mb-3">
                                <label for="proyecto_id" class="form-label">Proyecto</label>
                                <select name="proyecto_id" id="proyecto_id" class="form-select" required>
                                    <option value="" disabled selected>Seleccione un proyecto</option>
                                    @foreach ($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}">{{ $proyecto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

      <!-- Tabla para mostrar manzanas -->
<h2 class="mb-3">Lista de Manzanas</h2>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th> 
            <th>Nombre</th>
            <th>Proyecto</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($manzanas as  $index => $manzana)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $manzana->nombre }}</td>
                <td>{{ $manzana->proyecto->nombre }}</td>
                <td>
                    <button class="btn btn-warning btn-sm">Editar</button>
                    <form action="{{ route('manzanas.destroy', $manzana->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta manzana?')">Eliminar</button>
                    </form>
                    <button 
                        class="btn btn-warning btn-sm" 
                        title="Descargar PDF"
                        disabled
                    >
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay manzanas registradas.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Paginación -->
<div class="d-flex justify-content-center" id="pagination-container">
    {{ $manzanas->links('pagination::bootstrap-5') }}
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función de búsqueda
        document.getElementById('searchBar').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('#manzanasTable tr');

            rows.forEach(row => {
                const name = row.cells[1]?.textContent.toLowerCase();
                const project = row.cells[2]?.textContent.toLowerCase();

                if (name?.includes(query) || project?.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
