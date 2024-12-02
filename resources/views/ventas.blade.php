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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Venta</button>
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
                            <a href="{{ route('ventas.edit', $venta->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
