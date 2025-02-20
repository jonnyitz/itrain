<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Bancos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Administrar Bancos</h2>

        <!-- Botón para abrir el modal de creación de banco -->
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createBancoModal">
            Crear Banco
        </button>

        <!-- Tabla para mostrar los bancos existentes -->
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Banco</th>
            <th>Tipo de Cuenta</th>
            <th>Moneda</th>
            <th>Número / Código</th>
            <th>Nombre Responsable</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bancos as $index => $banco)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $banco->nombre_banco }}</td>
            <td>{{ $banco->tipo_cuenta }}</td>
            <td>{{ $banco->moneda }}</td>
            <td>{{ $banco->numero_cuenta }}</td>
            <td>{{ $banco->nombre_responsable }}</td>
            <td>
                <!-- Aquí agregas los botones de acción -->
                <a href="#" class="btn btn-warning btn-sm">Editar</a>
                <form action="{{ route('bancos.destroy', $banco->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
  <!-- Modal para crear un nuevo banco -->
  <div class="modal fade" id="createBancoModal" tabindex="-1" role="dialog" aria-labelledby="createBancoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBancoModalLabel">Nuevo Banco</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('bancos.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nombre_banco">Nombre del Banco / Caja Interna</label>
                                <input type="text" class="form-control" id="nombre_banco" name="nombre_banco" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo_cuenta">Tipo Cuenta</label>
                                <input type="text" class="form-control" id="tipo_cuenta" name="tipo_cuenta" required>
                            </div>
                            <div class="form-group">
                                <label for="moneda">Moneda</label>
                                <input type="text" class="form-control" id="moneda" name="moneda" required>
                            </div>
                            <div class="form-group">
                                <label for="numero_cuenta">N° Cuenta / Código</label>
                                <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" required>
                            </div>
                            <div class="form-group">
                                <label for="cci">CCI</label>
                                <input type="text" class="form-control" id="cci" name="cci" required>
                            </div>
                            <div class="form-group">
                                <label for="nombre_responsable">A Nombre de / Responsable</label>
                                <input type="text" class="form-control" id="nombre_responsable" name="nombre_responsable" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Banco</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.5/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
