<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Lista de Reservas</h2>
    <!-- Barra de búsqueda -->
    <input 
        type="text" 
        id="searchInput" 
        class="form-control mb-3" 
        placeholder="Buscar por Contacto, CURP, Asesor...">

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#nuevoReservaModal">Nuevo</button>

    <!-- Tabla de Reservas -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>CURP</th>
                <th>Asesor</th>
                <th>Fecha de Firma</th>
                <th>Fecha de Pago</th>
                <th>Monto</th>
                <th>Acciones</th>
            </tr> 
        </thead>
        <tbody>
            @foreach($reservas as $index => $reserva)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reserva->contacto->nombre }}</td>
                    <td>{{ $reserva->contacto->curp_rfc }}</td>
                    <td>{{ $reserva->venta?->asesor ?? 'Sin asignar' }}</td>
                    <td>{{ $reserva->fecha_firma }}</td>
                    <td>{{ $reserva->fecha_pago }}</td>
                    <td>{{ $reserva->monto }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarReserva({{ $reserva->id }})">Editar</button>
                        <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para Nueva/Editar Reserva -->
    <div class="modal fade" id="nuevoReservaModal" tabindex="-1" aria-labelledby="nuevoReservaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="reservaForm" action="{{ route('reservas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="reserva_id" name="reserva_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoReservaModalLabel">Nueva Reserva</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Seleccionar Contacto -->
                        <div class="form-group">
                            <label for="contacto_id">Contacto</label>
                            <select class="form-control" id="contacto_id" name="contacto_id" required>
                                <option value="">Seleccione un contacto</option>
                                @foreach($contactos as $contacto)
                                    <option value="{{ $contacto->id }}" data-curp="{{ $contacto->curp_rfc }}">{{ $contacto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mostrar CURP basado en el contacto seleccionado -->
                        <div class="form-group">
                            <label for="curp_rfc">CURP</label>
                            <input type="text" class="form-control" id="curp_rfc" name="curp_rfc" readonly>
                        </div>

                        <!-- Seleccionar Asesor -->
                        <div class="form-group">
                            <label for="venta_id">Asesor</label>
                            <select class="form-control" id="venta_id" name="venta_id" required>
                                <option value="">Seleccione un asesor</option>
                                @foreach($ventas as $venta)
                                    <option value="{{ $venta->id }}">{{ $venta->asesor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fecha de Firma -->
                        <div class="form-group">
                            <label for="fecha_firma">Fecha de Firma</label>
                            <input type="date" class="form-control" id="fecha_firma" name="fecha_firma" required>
                        </div>

                        <!-- Fecha de Pago -->
                        <div class="form-group">
                            <label for="fecha_pago">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
                        </div>

                        <!-- Monto -->
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('#contacto_id').on('change', function () {
        var selectedCURP = $(this).find('option:selected').data('curp');
        $('#curp_rfc').val(selectedCURP);
    });

    function editarReserva(id) {
    fetch(`/reservas/${id}/edit`)
        .then(response => response.json()) // Suponiendo que la respuesta es JSON
        .then(data => {
            // Rellenar el formulario con los datos recibidos
            document.getElementById('reserva_id').value = data.reserva.id;
            document.getElementById('contacto_id').value = data.reserva.contacto_id;
            document.getElementById('venta_id').value = data.reserva.venta_id;
            document.getElementById('fecha_firma').value = data.reserva.fecha_firma;
            document.getElementById('fecha_pago').value = data.reserva.fecha_pago;
            document.getElementById('monto').value = data.reserva.monto;
            document.getElementById('nuevoReservaModalLabel').textContent = 'Editar Reserva';
            document.getElementById('reservaForm').setAttribute('action', `/reservas/${data.reserva.id}`);
            
            // Agregar el campo de método PUT (para Laravel)
            const inputMethod = document.createElement('input');
            inputMethod.type = 'hidden';
            inputMethod.name = '_method';
            inputMethod.value = 'PUT';
            document.getElementById('reservaForm').appendChild(inputMethod);
            
            // Mostrar el modal
            $('#nuevoReservaModal').modal('show');
        })
        .catch(error => {
            console.error('Error al obtener los datos:', error);
            alert('Hubo un error al cargar los datos.');
        });
}

    $('#nuevoReservaModal').on('hidden.bs.modal', function () {
        $('#reservaForm').trigger('reset').attr('action', '{{ route('reservas.store') }}').find('input[name="_method"]').remove();
        $('#nuevoReservaModalLabel').text('Nueva Reserva');
    });
     // Función de búsqueda
     document.getElementById("searchInput").addEventListener("keyup", function() {
        var filter = this.value.toUpperCase();
        var rows = document.getElementById("reservasTable").getElementsByTagName("tr");

        for (var i = 1; i < rows.length; i++) {
            var cols = rows[i].getElementsByTagName("td");
            var match = false;
            for (var j = 0; j < cols.length - 1; j++) {  // -1 to ignore the Actions column
                if (cols[j].textContent.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none";
        }
    });
</script>
</body>
</html>
