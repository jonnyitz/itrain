<!-- resources/views/ventas.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery y JavaScript de Bootstrap -->
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Ventas</h2>

        <!-- Botones y barra de búsqueda -->
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#ventaModal">Nueva Venta</button>
            <input type="text" class="form-control w-25 d-inline-block ml-3" placeholder="Buscar..." id="buscar" name="buscar">
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Modal para crear nueva venta -->
        <div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ventaModalLabel">Nueva Venta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('ventas.store') }}" method="POST">
                            @csrf <!-- Agregar token CSRF -->
                            <!-- Pestañas de formulario -->
                            <ul class="nav nav-tabs" id="ventaTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="datos-tab" data-toggle="tab" href="#datos" role="tab" aria-controls="datos" aria-selected="true">Datos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lotes-tab" data-toggle="tab" href="#lotes" role="tab" aria-controls="lotes" aria-selected="false">Lotes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="manzanas-tab" data-toggle="tab" href="#manzanas" role="tab" aria-controls="manzanas" aria-selected="false">Manzanas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pago-tab" data-toggle="tab" href="#pago" role="tab" aria-controls="pago" aria-selected="false">Pago</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="finalizacion-tab" data-toggle="tab" href="#finalizacion" role="tab" aria-controls="finalizacion" aria-selected="false">Finalización</a>
                                </li>
                            </ul>

                            <!-- Contenido de los formularios en pestañas -->
                            <div class="tab-content" id="ventaTabContent">
                                <!-- Formulario Datos -->
                                <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                    <div class="form-group mt-3">
                                        <label for="contacto_id">Contacto:</label>
                                        <select name="contacto_id" id="contacto_id" class="form-control" required>
                                            <option value="">Seleccione un contacto</option>
                                            @foreach ($contactos as $contacto)
                                                <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_venta">Fecha de Venta:</label>
                                        <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_venta">Tipo de Venta:</label>
                                        <input type="text" name="tipo_venta" id="tipo_venta" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="asesor">Asesor:</label>
                                        <input type="text" name="asesor" id="asesor" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_contrato">Número de Contrato:</label>
                                        <input type="text" name="numero_contrato" id="numero_contrato" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="aval">Aval:</label>
                                        <input type="text" name="aval" id="aval" class="form-control" maxlength="255">
                                    </div>
                                </div>
                               

                                <!-- Formulario Lotes -->
                                <div class="tab-pane fade" id="lotes" role="tabpanel" aria-labelledby="lotes-tab">
                                    <div class="form-group">
                                        <label for="lote_id">Seleccione el Lote:</label>
                                        <select name="lote_id" id="lote_id" class="form-control" required>
                                            <option value="" selected disabled>Seleccione un lote</option>
                                            @foreach ($lotes as $lote)
                                                <option value="{{ $lote->id }}">{{ $lote->lote }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="manzanas" role="tabpanel" aria-labelledby="manzanas-tab">
                                        <div class="form-group">
                                            <label for="manzana_id">Seleccione la Manzana:</label>
                                            <select name="manzana_id" id="manzana_id" class="form-control" required>
                                                <option value="" selected disabled>Seleccione una manzana</option>
                                                @foreach ($manzanas as $manzana)
                                                    <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    
                                    
                                    <!-- Enganche -->
                                    <div class="form-group">
                                        <label for="enganche">Monto de Enganche:</label>
                                        <input type="number" name="enganche" id="enganche" class="form-control" required step="0.01">
                                    </div>

                                    <!-- Cantidad de Pagos -->
                                    <div class="form-group">
                                        <label for="cantidad_pagos">Cantidad de Pagos:</label>
                                        <input type="number" name="cantidad_pagos" id="cantidad_pagos" class="form-control" required min="1">
                                    </div>

                                    <!-- Fecha de Inicio -->
                                    <div class="form-group">
                                        <label for="fecha_inicio">Fecha de Inicio:</label>
                                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio_venta_final">Precio de Venta Final:</label>
                                        <input type="number" name="precio_venta_final" id="precio_venta_final" class="form-control" required step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion">Observación:</label>
                                        <textarea name="observacion" id="observacion" class="form-control"></textarea>
                                    </div>
                                </div>

                                <!-- Formulario Pago -->
                                <div class="tab-pane fade" id="pago" role="tabpanel" aria-labelledby="pago-tab">
                                    <div class="form-group">
                                        <label for="metodo_pago">Método de Pago:</label>
                                        <select name="metodo_pago" id="metodo_pago" class="form-control" required>
                                            <option value="">Seleccione un método</option>
                                            <option value="tarjeta">Tarjeta</option>
                                            <option value="efectivo">Efectivo</option>
                                            <option value="transferencia">Transferencia</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comprobante">Comprobante:</label>
                                        <input type="text" name="comprobante" id="comprobante" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_comprobante">Número de Comprobante:</label>
                                        <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="forma_pago">Concepto de Gasto:</label>
                                        <select name="forma_pago" id="forma_pago" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="Egreso de Enganche">Egreso de Enganche</option>
                                            <option value="Pago de Comision">Pago de Comision</option>
                                            <option value="Devolucion por Cancelacion">Devolucion por Cancelacion</option>
                                            <option value="Condonacion General de Pago">Condonacion General de Pago</option>
                                        </select>
                                    </div>
                                    <!-- Otros campos -->
                                        <div class="form-group">
                                            <label for="banco_caja_interna">Banco/Caja Interna</label>
                                            <input type="text" name="banco_caja_interna" id="banco_caja_interna" class="form-control" placeholder="Ingrese Banco o Caja Interna" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="codigo_operacion">Código de Operación</label>
                                            <input type="text" name="codigo_operacion" id="codigo_operacion" class="form-control" placeholder="Ingrese el código de operación" required>
                                        </div>
                                    <div class="form-group">
                                        <label for="monto_primer_pago">Monto del Primer Pago:</label>
                                        <input type="number" name="monto_primer_pago" id="monto_primer_pago" class="form-control" required step="0.01">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_hora_pago">Fecha y Hora del Pago:</label>
                                        <input type="datetime-local" name="fecha_hora_pago" id="fecha_hora_pago" class="form-control" required>
                                    </div>
                                     <!-- Modalidad Enganche -->
                                <div class="form-group">
                                    <label for="modalidad_enganche">Modalidad de Enganche:</label>
                                    <select name="modalidad_enganche" id="modalidad_enganche" class="form-control" required>
                                        <option value="">Seleccione Modalidad</option>
                                        <option value="1">Modalidad 1</option>
                                        <option value="2">Modalidad 2</option>
                                        <!-- Add other options here -->
                                    </select>
                                </div>
                                </div>
                               

                                <!-- Formulario Finalización -->
                                <div class="tab-pane fade" id="finalizacion" role="tabpanel" aria-labelledby="finalizacion-tab">
                                    <div class="form-group">
                                        <label for="fecha_finalizacion">Fecha de Finalización:</label>
                                        <input type="date" name="fecha_finalizacion" id="fecha_finalizacion" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion_finalizacion">Observaciones de Finalización:</label>
                                        <textarea name="observacion_finalizacion" id="observacion_finalizacion" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <!-- Cambiar de type="submit" a type="button" -->
                        <button type="button" class="btn btn-primary" id="guardarVentaBtn">Guardar Venta</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
      


        <!-- Tabla de ventas -->
        <h3 class="mt-5">Ventas Registradas</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Contacto</th>
                    <th>Fecha de Venta</th>
                    <th>Tipo de Venta</th>
                    <th>Asesor</th>
                    <th>Número de Contrato</th>
                    <th>Precio Final</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->contacto->nombre }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>{{ $venta->tipo_venta }}</td>
                        <td>{{ $venta->asesor }}</td>
                        <td>{{ $venta->numero_contrato }}</td>
                        <td>{{ $venta->precio_venta_final }}</td>
                        <td>
                        <button
                            class="btn btn-warning btn-sm btnEditarVenta"
                            data-id="{{ $venta->id }}"
                            data-contacto-id="{{ $venta->contacto_id }}"
                            data-fecha-venta="{{ $venta->fecha_venta }}"
                            data-tipo-venta="{{ $venta->tipo_venta }}"
                            data-asesor="{{ $venta->asesor }}"
                            data-numero-contrato="{{ $venta->numero_contrato }}"
                            data-precio-venta-final="{{ $venta->precio_venta_final }}"
                            data-lote-id="{{ $venta->lote_id }}"
                            data-manzana-id="{{ $venta->manzana_id }}"
                            data-banco-caja-interna="{{ $venta->banco_caja_interna }}"
                            data-comprobante="{{ $venta->comprobante }}"
                            data-numero-comprobante="{{ $venta->numero_comprobante }}"
                            data-forma-pago="{{ $venta->forma_pago }}"
                            data-monto-primer-pago="{{ $venta->monto_primer_pago }}"
                            data-fecha-hora-pago="{{ $venta->fecha_hora_pago }}"
                            data-codigo-operacion="{{ $venta->codigo_operacion }}"
                            data-modalidad-enganche="{{ $venta->modalidad_enganche }}"
                            data-enganche="{{ $venta->enganche }}"
                            data-cantidad-pagos="{{ $venta->cantidad_pagos }}"
                            data-fecha-inicio="{{ $venta->fecha_inicio }}"
                            data-toggle="modal"
                            data-target="#editarVentaModal"
                        >
                            Editar
                        </button>
                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            <a href="{{ route('ventas.pagare', $venta->id) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-invoice"></i> 
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  <!-- Modal para editar venta -->
  <div class="modal fade" id="editarVentaModal" tabindex="-1" aria-labelledby="editarVentaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarVentaModalLabel">Editar Venta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarVenta{{ $venta->id }}" method="POST" action="{{ route('ventas.update', $venta->id) }}">
                            @csrf
                            @method('PUT')
                            <!-- Campos del formulario -->
                            <div class="form-group">
                                <label for="editarContacto">Contacto:</label>
                                <select name="contacto_id" id="editarContacto" class="form-control" >
                                    @foreach ($contactos as $contacto)
                                        <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarFechaVenta">Fecha de Venta:</label>
                                <input type="date" name="fecha_venta" id="editarFechaVenta" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarTipoVenta">Tipo de Venta:</label>
                                <input type="text" name="tipo_venta" id="editarTipoVenta" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarAsesor">Asesor:</label>
                                <input type="text" name="asesor" id="editarAsesor" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarNumeroContrato">Número de Contrato:</label>
                                <input type="text" name="numero_contrato" id="editarNumeroContrato" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarPrecioFinal">Precio Final:</label>
                                <input type="number" name="precio_venta_final" id="editarPrecioFinal" class="form-control" >
                            </div>
                            <!-- Campos adicionales en el modal de edición -->
                            <div class="form-group">
                                <label for="editarLoteId">Lote:</label>
                                <select name="lote_id" id="editarLoteId" class="form-control" >
                                    @foreach ($lotes as $lote)
                                        <option value="{{ $lote->id }}">{{ $lote->lote }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarManzanaId">Manzana:</label>
                                <select name="manzana_id" id="editarManzanaId" class="form-control" >
                                    @foreach ($manzanas as $manzana)
                                        <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarBancoCajaInterna">Banco/Caja Interna:</label>
                                <input type="text" name="banco_caja_interna" id="editarBancoCajaInterna" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarComprobante">Comprobante:</label>
                                <input type="text" name="comprobante" id="editarComprobante" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarNumeroComprobante">Número de Comprobante:</label>
                                <input type="text" name="numero_comprobante" id="editarNumeroComprobante" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarFormaPago">Forma de Pago:</label>
                                <select name="forma_pago" id="editarFormaPago" class="form-control" >
                                    <option value="">Seleccione una forma de pago</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarMontoPrimerPago">Monto del Primer Pago:</label>
                                <input type="number" name="monto_primer_pago" id="editarMontoPrimerPago" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarFechaHoraPago">Fecha y Hora del Pago:</label>
                                <input type="datetime-local" name="fecha_hora_pago" id="editarFechaHoraPago" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarCodigoOperacion">Código de Operación:</label>
                                <input type="text" name="codigo_operacion" id="editarCodigoOperacion" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarModalidadEnganche">Modalidad de Enganche:</label>
                                <select name="modalidad_enganche" id="editarModalidadEnganche" class="form-control" >
                                    <option value="">Seleccione una modalidad</option>
                                    <option value="1">Modalidad 1</option>
                                    <option value="2">Modalidad 2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarEnganche">Enganche:</label>
                                <input type="number" name="enganche" id="editarEnganche" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarCantidadPagos">Cantidad de Pagos:</label>
                                <input type="number" name="cantidad_pagos" id="editarCantidadPagos" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="editarFechaInicio">Fecha de Inicio:</label>
                                <input type="date" name="fecha_inicio" id="editarFechaInicio" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).on('click', '.btnEditarVenta', function() {
        const id = $(this).data('id');
        const contactoId = $(this).data('contacto-id');
        const fechaVenta = $(this).data('fecha-venta');
        const tipoVenta = $(this).data('tipo-venta');
        const asesor = $(this).data('asesor');
        const numeroContrato = $(this).data('numero-contrato');
        const precioVentaFinal = $(this).data('precio-venta-final');

        // Nuevos campos
        const loteId = $(this).data('lote-id');
        const manzanaId = $(this).data('manzana-id');
        const bancoCajaInterna = $(this).data('banco-caja-interna');
        const comprobante = $(this).data('comprobante');
        const numeroComprobante = $(this).data('numero-comprobante');
        const formaPago = $(this).data('forma-pago');
        const montoPrimerPago = $(this).data('monto-primer-pago');
        const fechaHoraPago = $(this).data('fecha-hora-pago');
        const codigoOperacion = $(this).data('codigo-operacion');
        const modalidadEnganche = $(this).data('modalidad-enganche');
        const enganche = $(this).data('enganche');
        const cantidadPagos = $(this).data('cantidad-pagos');
        const fechaInicio = $(this).data('fecha-inicio');

        // Asignar datos a los campos del modal
        $('#formEditarVenta').attr('action', `/ventas/${id}`);
        $('#editar_contacto_id').val(contactoId);
        $('#editar_fecha_venta').val(fechaVenta);
        $('#editar_tipo_venta').val(tipoVenta);
        $('#editar_asesor').val(asesor);
        $('#editar_numero_contrato').val(numeroContrato);
        $('#editar_precio_venta_final').val(precioVentaFinal);

        // Asignar nuevos campos
        $('#editarLoteId').val(loteId);
        $('#editarManzanaId').val(manzanaId);
        $('#editarBancoCajaInterna').val(bancoCajaInterna);
        $('#editarComprobante').val(comprobante);
        $('#editarNumeroComprobante').val(numeroComprobante);
        $('#editarFormaPago').val(formaPago);
        $('#editarMontoPrimerPago').val(montoPrimerPago);
        $('#editarFechaHoraPago').val(fechaHoraPago);
        $('#editarCodigoOperacion').val(codigoOperacion);
        $('#editarModalidadEnganche').val(modalidadEnganche);
        $('#editarEnganche').val(enganche);
        $('#editarCantidadPagos').val(cantidadPagos);
        $('#editarFechaInicio').val(fechaInicio);
    });
</script>
<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function () {
        // Manejo del clic en el botón "Guardar Venta"
        $j('#guardarVentaBtn').click(function(e) {
            e.preventDefault(); // Prevenir el comportamiento de envío por defecto

            var formData = {
                'contacto_id': $j('#contacto_id').val(),
                'fecha_venta': $j('#fecha_venta').val(),
                'tipo_venta': $j('#tipo_venta').val(),
                'asesor': $j('#asesor').val(),
                'numero_contrato': $j('#numero_contrato').val(),
                'aval': $j('#aval').val(),
                'lote_id': $j('#lote_id').val(),
                'manzana_id': $j('#manzana_id').val(),
                'enganche': $j('#enganche').val(),
                'cantidad_pagos': $j('#cantidad_pagos').val(),
                'fecha_inicio': $j('#fecha_inicio').val(),
                'precio_venta_final': $j('#precio_venta_final').val(),
                'descripcion': $j('#descripcion').val(),
                'observacion': $j('#observacion').val(),
                'metodo_pago': $j('#metodo_pago').val(),
                'comprobante': $j('#comprobante').val(),
                'numero_comprobante': $j('#numero_comprobante').val(),
                'forma_pago': $j('#forma_pago').val(),
                'banco_caja_interna': $j('#banco_caja_interna').val(),
                'codigo_operacion': $j('#codigo_operacion').val(),
                'monto_primer_pago': $j('#monto_primer_pago').val(),
                'fecha_hora_pago': $j('#fecha_hora_pago').val(),
                'modalidad_enganche': $j('#modalidad_enganche').val(),
                'fecha_finalizacion': $j('#fecha_finalizacion').val(),
                'observacion_finalizacion': $j('#observacion_finalizacion').val(),
                '_token': $j('meta[name="csrf-token"]').attr('content')
            };

            // Validación de los campos antes de enviar el formulario
            if (!formData.contacto_id || !formData.fecha_venta || !formData.tipo_venta || !formData.asesor || !formData.numero_contrato) {
                return; // Salir si faltan campos obligatorios
            }

            // Enviar la solicitud AJAX
            $j.ajax({
                url: '{{ route('ventas.store') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Recargar la página después de la operación
                    location.reload(); // Recarga la página al guardar la venta con éxito
                },
                error: function() {
                    // Recargar la página si ocurre un error
                    location.reload(); // Recarga la página si hay error
                }
            });
        });
    });
</script>

</body>
</html>
