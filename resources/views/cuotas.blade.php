<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cuotas</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Cobros</h2>
        <div class="mb-4">
            <input
                type="text"
                id="searchBar"
                class="form-control"
                placeholder="Buscar por contacto, lote o tipo...">
        </div>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCuotaModal">Nuevo</button>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Lote/Manzana</th>
                    <th>Comprobante</th>
                    <th>N Cts</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>R.D</th>
                    <th>Voucher</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuotas as $index => $cuota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cuota->contacto->nombre }}</td>
                    <td>{{ $cuota->lote->lote }}</td>
                    <td>{{ $cuota->comprobante }}</td>
                    <td>{{ $cuota->n_cts }}</td>
                    <td>{{ $cuota->tipo }}</td>
                    <td>{{ $cuota->fecha }}</td>
                    <td>{{ $cuota->rd }}</td>
                    <td>{{ $cuota->voucher }}</td>
                    <td>
                        <!-- Aquí puedes agregar botones para editar o eliminar -->
                        <!-- Botón Editar -->
                        <button
                            class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#editarClienteModal{{ $cuota->contacto->id }}"
                            onclick="cargarDatosEditar({{ $cuota->contacto->id }}, '{{ $cuota->contacto->nombre }}', '{{ $cuota->contacto->apellidos }}', '{{ $cuota->contacto->curp_rfc }}', '{{ $cuota->contacto->telefono }}', '{{ $cuota->contacto->direccion }}', '{{ $cuota->contacto->observacion }}')">
                            Editar
                        </button>

                        <!-- Formulario Eliminar -->
                        <form
                            action="{{ route('contactos.destroy', $cuota->contacto->id) }}"
                            method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este contacto?')">
                                Eliminar
                            </button>
                        </form>

                        <!-- Botón para PDF -->
                        <button
                            class="btn btn-warning btn-sm"
                            title="Descargar PDF">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar nueva cuota -->
    <div class="modal fade" id="addCuotaModal" tabindex="-1" aria-labelledby="addCuotaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cuotas.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCuotaModalLabel">Nueva Cuota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="contacto_id">Contacto</label>
                            <select name="contacto_id" id="contacto_id" class="form-control">
                                @foreach ($contactos as $contacto)
                                <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lote_id">Lote</label>
                            <select name="lote_id" id="lote_id" class="form-control">
                                @foreach ($lotes as $lote)
                                <option value="{{ $lote->id }}">{{ $lote->lote }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comprobante">Comprobante</label>
                            <input type="text" class="form-control" id="comprobante" name="comprobante">
                        </div>
                        <div class="form-group">
                            <label for="n_cts">N Cts</label>
                            <input type="text" class="form-control" id="n_cts" name="n_cts">
                        </div>
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="form-group">
                            <label for="rd">R.D</label>
                            <input type="text" class="form-control" id="rd" name="rd">
                        </div>
                        <div class="form-group">
                            <label for="voucher">Voucher</label>
                            <input type="text" class="form-control" id="voucher" name="voucher">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Enlace a jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchBar').on('keyup', function() {
                let value = $(this).val().toLowerCase(); // Captura el texto ingresado
                $('#cuotasTable tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); // Filtra las filas
                });
            });
        });
    </script>
</body>

</html>