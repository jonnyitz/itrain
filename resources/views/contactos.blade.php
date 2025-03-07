<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Contactos</h1>

    <!-- Barra de búsqueda -->
<form action="{{ url('contactos') }}" method="GET" class="mb-3">
    <input type="text" name="search" id="buscarContacto" class="form-control" placeholder="Buscar contacto por nombre, CURP/RFC o teléfono" value="{{ request()->input('search') }}">
</form>
    <!-- Botón para agregar nuevo cliente -->
    <div class="mb-3">
        <button class="btn btn-success" data-toggle="modal" data-target="#nuevoClienteModal">Nuevo Cliente</button>
        <a href="{{ route('contactos.export') }}" class="btn btn-success">
                            Exportar a Excel
         </a>
    </div>
    

    <!-- Tabla de contactos -->
    <table class="table table-bordered table-striped">
            <tr>
                <th>#</th>
                <th>Nombre y Apellidos</th>
                <th>CURP/RFC</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Observación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contactos as $index => $contacto)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $contacto->nombre }} {{ $contacto->apellidos }}</td>
                    <td>{{ $contacto->curp_rfc }}</td>
                    <td>{{ $contacto->telefono }}</td>
                    <td>{{ $contacto->direccion }}</td>
                    <td>{{ $contacto->observacion }}</td>
                    <td>
                        <!-- Botón Editar -->
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editarClienteModal{{ $contacto->id }}" onclick="cargarDatosEditar({{ $contacto->id }}, '{{ $contacto->nombre }}', '{{ $contacto->apellidos }}', '{{ $contacto->curp_rfc }}', '{{ $contacto->telefono }}', '{{ $contacto->direccion }}', '{{ $contacto->observacion }}')">Editar</button>

                        <!-- Formulario Eliminar -->
                        <form action="{{ route('contactos.destroy', $contacto->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este contacto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                
              <!-- Modal para editar cliente -->
            <div class="modal fade" id="editarClienteModal{{ $contacto->id }}" tabindex="-1" aria-labelledby="editarClienteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarClienteModalLabel">Editar Cliente</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formEditarCliente{{ $contacto->id }}" method="POST" action="{{ route('contactos.update', $contacto->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" name="nombre" id="editarNombre{{ $contacto->id }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Apellidos</label>
                                    <input type="text" name="apellidos" id="editarApellidos{{ $contacto->id }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>CURP/RFC</label>
                                    <input type="text" name="curp_rfc" id="editarCurpRfc{{ $contacto->id }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" id="editarTelefono{{ $contacto->id }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" id="editarDireccion{{ $contacto->id }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Observación</label>
                                    <textarea name="observacion" id="editarObservacion{{ $contacto->id }}" class="form-control"></textarea>
                                </div>
                            <button class="btnGuardarCambios btn btn-success" data-id="{{ $contacto->id }}">Guardar cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Paginación -->
<div class="d-flex justify-content-center" id="pagination-container">
    {{ $contactos->links('pagination::bootstrap-5') }}
</div>

<!-- Modal para agregar nuevo cliente -->
<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nuevoClienteModalLabel">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('contactos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>CURP/RFC</label>
                        <input type="text" name="curp_rfc" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección (Escribir completa sin abreviaciones y con C.P).</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Observación</label>
                        <textarea name="observacion" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Crear Cliente</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Script para cargar datos en el modal de edición -->
<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script para cargar datos en el modal de edición -->
<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function () {
        // Definición de la función cargarDatosEditar
        window.cargarDatosEditar = function(id, nombre, apellidos, curpRfc, telefono, direccion, observacion) {
            $j('#editarNombre' + id).val(nombre);
            $j('#editarApellidos' + id).val(apellidos);
            $j('#editarCurpRfc' + id).val(curpRfc);
            $j('#editarTelefono' + id).val(telefono);
            $j('#editarDireccion' + id).val(direccion);
            $j('#editarObservacion' + id).val(observacion);
        };

        // Manejo de la acción del botón de guardar cambios con AJAX
        $j('.btnGuardarCambios').click(function(e) {
            e.preventDefault();

            var id = $j(this).data('id');
            var formData = {
                'nombre': $j('#editarNombre' + id).val(),
                'apellidos': $j('#editarApellidos' + id).val(),
                'curp_rfc': $j('#editarCurpRfc' + id).val(),
                'telefono': $j('#editarTelefono' + id).val(),
                'direccion': $j('#editarDireccion' + id).val(),
                'observacion': $j('#editarObservacion' + id).val(),
                '_token': $j('meta[name="csrf-token"]').attr('content')
            };

            // Validación de datos antes de enviar
            if (!formData.nombre || !formData.apellidos || !formData.curp_rfc || !formData.telefono || !formData.direccion) {
                return; // No hacemos nada si falta un campo
            }

            $j.ajax({
                url: '{{ route('contactos.update', '') }}/' + id,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    if(response.success) {
                        // Actualización de la tabla con nuevos valores
                        $j('#nombre' + id).text(formData.nombre + ' ' + formData.apellidos);
                        $j('#curpRfc' + id).text(formData.curp_rfc);
                        $j('#telefono' + id).text(formData.telefono);
                        $j('#direccion' + id).text(formData.direccion);
                        $j('#observacion' + id).text(formData.observacion);
                        
                        // Cerrar modal
                        $j('#editarClienteModal' + id).modal('hide');
                    }
                    // Recargar la página después de éxito o error
                    location.reload(); // Recarga la página en ambos casos
                },
                error: function() {
                    // Recargar la página en caso de error
                    location.reload(); // Recarga la página en caso de error
                }
            });
        });
    });
</script>



</body>
</html>
