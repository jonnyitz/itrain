<!-- resources/views/ventas.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery y JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Ventas</h2>

        <!-- Botones y barra de búsqueda -->
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#ventaModal">Nueva Venta</button>
            <input type="text" 
       class="form-control w-25 d-inline-block ml-3" 
       placeholder="Buscar..." 
       id="buscar" 
       name="buscar">
       @if ($errors->any())
       <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

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
                                       <!-- Campo para seleccionar el contacto -->
                                    <label for="contacto_id">Contacto:</label>
                                    <select name="contacto_id" id="contacto_id" required>
                                        <option value="">Seleccione un contacto</option>
                                        @foreach ($contactos as $contacto)
                                            <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group">
                                            <label for="fecha_venta">Fecha de Venta:</label>
                                            <input type="date" name="fecha_venta" id="fecha_venta" required>
                                    </div>
                                    <div class="form-group">
                                            <label for="tipo_venta">Tipo de Venta:</label>
                                            <input type="text" name="tipo_venta" id="tipo_venta" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                            <label for="asesor">Asesor:</label>
                                            <input type="text" name="asesor" id="asesor" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                            <label for="numero_contrato">Número de Contrato:</label>
                                            <input type="text" name="numero_contrato" id="numero_contrato" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                            <label for="aval">Aval:</label>
                                            <input type="text" name="aval" id="aval" maxlength="255">
                                    </div>
                                </div>

                                <!-- Formulario Lotes -->
                                <div class="tab-pane fade" id="lotes" role="tabpanel" aria-labelledby="lotes-tab">
                                    <div class="form-group mt-3">
                                            <label for="lote">Lote:</label>
                                            <input type="text" name="lote" id="lote" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                            <label for="precio_venta_final">Precio de Venta Final:</label>
                                            <input type="number" name="precio_venta_final" id="precio_venta_final" required step="0.01">
                                    </div>
                                    <div class="form-group">
                                            <label for="descripcion">Descripción:</label>
                                            <textarea name="descripcion" id="descripcion"></textarea>
                                    </div>
                                    <div class="form-group">
                                            <label for="observacion">Observación:</label>
                                            <textarea name="observacion" id="observacion"></textarea>
                                    </div>
                                </div>

                                <!-- Formulario Pago -->
                                <div class="tab-pane fade" id="pago" role="tabpanel" aria-labelledby="pago-tab">
                                    <div class="form-group mt-3">
                                        <label for="banco_caja_interna" >Seleccionar Pago</label>
                                        <select name="banco_caja_interna"  class="form-control" id="banco_caja_interna"  required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach($pagos as $pago)
                                                <option value="{{ $pago->id }}">{{ $pago->banco_caja_interna }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">                                      
                                            <label for="comprobante">Comprobante:</label>
                                            <input type="text" name="comprobante" id="comprobante" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                            <label for="numero_comprobante">Número de Comprobante:</label>
                                            <input type="text" name="numero_comprobante" id="numero_comprobante" required maxlength="255">
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="forma_pago">Forma de Pago</label>
                                        <select name="forma_pago" class="form-control" id="forma_pago" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach($pagos as $pago)
                                                <option value="{{ $pago->id }}">{{ $pago->forma_pago }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                            <label for="monto_primer_pago">Monto del Primer Pago:</label>
                                            <input type="number" name="monto_primer_pago" id="monto_primer_pago" required step="0.01">
                                    </div>
                                    <div class="form-group">
                                            <label for="fecha_hora_pago">Fecha y Hora del Pago:</label>
                                            <input type="datetime-local" name="fecha_hora_pago" id="fecha_hora_pago" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="codigo_operacion">Código de Operación (Generado Automáticamente)</label>
                                        <input type="text" name="codigo_operacion" class="form-control" id="codigo_operacion" readonly>
                                    </div>
                                </div>
                                <!-- Formulario Finalización -->
                                <div class="tab-pane fade" id="finalizacion" role="tabpanel" aria-labelledby="finalizacion-tab">
                                    <div class="form-group mt-3">
                                            <label for="modalidad_enganche">Modalidad del Enganche:</label>
                                            <input type="text" name="modalidad_enganche" id="modalidad_enganche" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                    <label for="enganche">Enganche:</label>
                                    <input type="number" name="enganche" id="enganche" required step="0.01">
                                </div>
                                    <div class="form-group">
                                            <label for="cantidad_pagos">Cantidad de Pagos:</label>
                                            <input type="number" name="cantidad_pagos" id="cantidad_pagos" required min="1">
                                    </div>
                                    <div class="form-group">
                                            <label for="fecha_inicio">Fecha de Inicio:</label>
                                            <input type="date" name="fecha_inicio" id="fecha_inicio" required>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button> <!-- Botón de envío -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de ventas -->
        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Lote/Manzana</th>
                        <th>Fecha</th>
                        <th>Tipo de Venta</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Contrato</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $index => $venta)
                        <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $contacto->nombre}}</td>
                            <td>{{ $venta->lote}}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                            <td>{{ $venta->tipo_venta }}</td>
                            <td>{{ $venta->precio_venta }}</td>
                            <td>{{ $venta->estado }}</td>
                            <td>{{ $venta->numero_contrato }}</td>
                            <td>
                                <button class="btn btn-info btn-sm">Ver</button>
                                <button class="btn btn-warning btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                                 <!-- Botón para PDF -->
                                <button class="btn btn-warning btn-sm" title="Descargar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
