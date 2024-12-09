<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Usuarios</h1>

        <!-- Mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Botón para abrir el modal de creación -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Crear Usuario</button>

        <!-- Tabla de usuarios -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Grupo</th>
                    <th>Empresa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->apellidos }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->grupo->descripcion ?? 'No asignado' }}</td>
                        <td>{{ $user->empresa->nombre ?? 'No asignado' }}</td>
                        <td>
                            <span class="badge {{ $user->activo ? 'bg-success' : 'bg-danger' }}">
                                {{ $user->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td>
                            <!-- Botones para editar y eliminar -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Editar</button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</button>
                            </form>
                            <form method="POST" action="{{ route('users.toggle-active', $user->id) }}" style="display:inline-block">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $user->activo ? 'btn-danger' : 'btn-success' }}">
                            {{ $user->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                        </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear usuario -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Crear Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="empresa_id" class="form-label">Empresa</label>
                            <select class="form-select" id="empresa_id" name="empresa_id" required>
                                <option value="" selected disabled>Selecciona una empresa</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grupo_id" class="form-label">Grupo</label>
                            <select class="form-select" id="grupo_id" name="grupo_id" required>
                                <option value="" selected disabled>Selecciona un grupo</option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
