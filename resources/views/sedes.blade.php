<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sedes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Sedes</h1>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Botón para abrir el modal de creación -->
        <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createSedeModal">
            Crear Nueva Sede
        </button>

        <!-- Modal para crear una nueva sede -->
        <div class="modal fade" id="createSedeModal" tabindex="-1" aria-labelledby="createSedeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSedeModalLabel">Crear Nueva Sede</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('sedes.store') }}" method="POST">
                            @csrf
                            <!-- Campos del formulario -->
                            <div class="mb-3">
                                <label for="sede" class="form-label">Sede</label>
                                <input type="text" id="sede" name="sede" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefonos" class="form-label">Teléfonos</label>
                                <input type="text" id="telefonos" name="telefonos" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" id="pais" name="pais" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" id="estado" name="estado" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="municipio" class="form-label">Municipio</label>
                                <input type="text" id="municipio" name="municipio" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="localidad" class="form-label">Localidad</label>
                                <input type="text" id="localidad" name="localidad" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="empresa_id" class="form-label">Empresa</label>
                                <select id="empresa_id" name="empresa_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una empresa</option>
                                    @foreach($empresas as $empresa)
                                        <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de sedes -->
        <div class="card">
            <div class="card-header">Lista de Sedes</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sede</th>
                            <th>Empresa</th>
                            <th>Dirección</th>
                            <th>Teléfonos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sedes as $sede)
                            <tr>
                                <td>{{ $sede->sede }}</td>
                                <td>{{ $sede->empresa->nombre }}</td>
                                <td>{{ $sede->direccion }}</td>
                                <td>{{ $sede->telefonos }}</td>
                                <td>
                                    <!-- Botón para abrir el modal de edición -->
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSedeModal-{{ $sede->id }}">
                                        Editar
                                    </button>
                                    <form action="{{ route('sedes.destroy', $sede->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sede?')">Eliminar</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal de edición -->
                            <div class="modal fade" id="editSedeModal-{{ $sede->id }}" tabindex="-1" aria-labelledby="editSedeModalLabel-{{ $sede->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editSedeModalLabel-{{ $sede->id }}">Editar Sede</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('sedes.update', $sede->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Campos del formulario de edición -->
                                                <div class="mb-3">
                                                    <label for="sede-{{ $sede->id }}" class="form-label">Sede</label>
                                                    <input type="text" id="sede-{{ $sede->id }}" name="sede" class="form-control" value="{{ $sede->sede }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="direccion-{{ $sede->id }}" class="form-label">Dirección</label>
                                                    <input type="text" id="direccion-{{ $sede->id }}" name="direccion" class="form-control" value="{{ $sede->direccion }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="telefonos-{{ $sede->id }}" class="form-label">Teléfonos</label>
                                                    <input type="text" id="telefonos-{{ $sede->id }}" name="telefonos" class="form-control" value="{{ $sede->telefonos }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pais-{{ $sede->id }}" class="form-label">País</label>
                                                    <input type="text" id="pais-{{ $sede->id }}" name="pais" class="form-control" value="{{ $sede->pais }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="estado-{{ $sede->id }}" class="form-label">Estado</label>
                                                    <input type="text" id="estado-{{ $sede->id }}" name="estado" class="form-control" value="{{ $sede->estado }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="municipio-{{ $sede->id }}" class="form-label">Municipio</label>
                                                    <input type="text" id="municipio-{{ $sede->id }}" name="municipio" class="form-control" value="{{ $sede->municipio }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="localidad-{{ $sede->id }}" class="form-label">Localidad</label>
                                                    <input type="text" id="localidad-{{ $sede->id }}" name="localidad" class="form-control" value="{{ $sede->localidad }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email-{{ $sede->id }}" class="form-label">Email</label>
                                                    <input type="email" id="email-{{ $sede->id }}" name="email" class="form-control" value="{{ $sede->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="empresa_id-{{ $sede->id }}" class="form-label">Empresa</label>
                                                    <select id="empresa_id-{{ $sede->id }}" name="empresa_id" class="form-control" required>
                                                        @foreach($empresas as $empresa)
                                                            <option value="{{ $empresa->id }}" {{ $empresa->id == $sede->empresa_id ? 'selected' : '' }}>
                                                                {{ $empresa->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-warning">Actualizar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin del modal de edición -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
