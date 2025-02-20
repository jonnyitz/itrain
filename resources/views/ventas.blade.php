<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery y JavaScript de Bootstrap -->
  

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Gestión de Ventas</h2>

        <!-- Botones y barra de búsqueda -->
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#ventaModal">Nueva Venta</button>
            <!-- Barra de búsqueda -->
        <form action="{{ url('ventas') }}" method="GET" class="mb-3">
            <input type="text" name="search" id="buscarVenta" class="form-control" placeholder="Buscar venta por nombre, descripción o contacto" value="{{ request()->input('search') }}">
        </form>

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
                                    <label for="contacto_search">Contacto:</label>
                                    <input type="text" id="contacto_search" class="form-control" placeholder="Buscar contacto..." required>
                                    <input type="hidden" name="contacto_id" id="contacto_id">
                                    <ul id="contacto_results" class="list-group mt-2 d-none"></ul>
                                </div>
                                    <div class="form-group">
                                        <label for="fecha_venta">Fecha de Venta:</label>
                                        <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="modalidad_enganche">Tipo de Venta:</label>
                                    <select name="modalidad_enganche" id="modalidad_enganche" class="form-control" required>
                                        <option value="">Seleccione Modalidad</option>
                                        <option value="1">Contado</option>
                                        <option value="2">Crédito</option>
                                        <!-- Add other options here -->
                                    </select>
                                </div>
                                    <div class="form-group">
                                        <label for="asesor">Asesor:</label>
                                        <input type="text" name="asesor" id="asesor" class="form-control" required maxlength="255">
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_contrato">Número de Contrato:</label>
                                        <input type="text" name="numero_contrato" id="numero_contrato" class="form-control" required maxlength="255" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="aval">Aval:</label>
                                        <input type="text" name="aval" id="aval" class="form-control" maxlength="255">
                                    </div>
                                </div>
                                

                                <!-- Formulario Lotes -->
                                <div class="tab-pane fade" id="lotes" role="tabpanel" aria-labelledby="lotes-tab">
                                <div class="form-group">
                                    <label for="manzana_id">Seleccione la Manzana:</label>
                                    <select name="manzana_id" id="manzana_id" class="form-control" required>
                                    <option value="" selected disabled>Seleccione una manzana</option>
                                        @foreach ($manzanas as $manzana)
                                            <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                    <div class="form-group">
                                        <label for="lote_id">Seleccione el Lote:</label>
                                        <select name="lote_id" id="lote_id" class="form-control" required>
                                            <option value="" selected disabled>Seleccione un lote</option>
                                            @foreach ($lotes as $lote)
                                                <option value="{{ $lote->id }}">{{ $lote->lote }}</option>
                                            @endforeach
                                        </select>
                                    </div>                                
                                    
                                    <!-- Contenedor de enganche -->
                                   <!-- Contenedor de Enganche -->
                                    <div id="enganche_container" style="display: none;">
                                    <div class="form-group">
                                        <label for="enganche">Enganche</label>
                                        <input type="number" id="enganche" name="enganche" min="0"  class="form-control" required>
                                    </div>
                                   </div> 

                                    <!-- Contenedor de Cantidad de Pagos -->
                                    <div id="cantidad_pagos_container" style="display: none;">
                                    <div class="form-group">
                                        <label for="cantidad_pagos">Cantidad de Pagos</label>
                                        <input type="number" id="cantidad_pagos" name="cantidad_pagos" min="1"  class="form-control" required>
                                    </div>
                                    </div>
                                    <!-- Fecha de Inicio -->
                                    <div class="form-group">
                                        <label for="fecha_inicio">Fecha de pago diferido:</label>
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
                                        <label for="banco_id">Banco/Caja Interna, Destino:</label>
                                        <select name="banco_id" id="banco_id" class="form-control" required>
                                            <option value="">Seleccione un banco</option>
                                            @foreach ($bancos as $banco)
                                                <option value="{{ $banco->id }}">
                                                    {{ $banco->nombre_banco }} / {{ $banco->tipo_cuenta }} - {{ $banco->nombre_responsable }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comprobante">Comprobante:</label>
                                        <select name="comprobante" id="comprobante" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="RECIBO">RECIBO</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="numero_comprobante">Número de Comprobante:</label>
                                        <input type="text" name="numero_comprobante" id="numero_comprobante" class="form-control" required maxlength="255" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="forma_pago">Forma de Pago:</label>
                                        <select name="forma_pago" id="forma_pago" class="form-control" required>
                                            <option value="">Seleccionar...</option>
                                            <option value="Deposito en Efectivo (Bancario)">Deposito en Efectivo (Bancario)</option>
                                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                                            <option value="Pago en Efectivo">Pago en Efectivo</option>
                                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                                            <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                                            <option value="Pago con Cheque">Pago con Cheque</option>
                                            <option value="Tarjeta de Débito">Money Order</option>
                                            <option value="Paypal">Paypal</option>
                                            <option value="Vale a la Vista">Vale a la Vista</option>
                                        </select>
                                    </div>
                                    <!-- Otros campos -->
                                    <div class="form-group">
                                        <label for="banco_caja_interna">MONEDA</label>
                                        <input type="text"  name="banco_caja_interna" id="banco_caja_interna" class="form-control" 
                                        placeholder="Ingrese Banco o Caja Interna" value="mexicana" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="codigo_operacion">Código de Operación</label>
                                        <input type="text" name="codigo_operacion" id="codigo_operacion" class="form-control" placeholder="Ingrese el código de operación" required readonly>
                                    </div>
                                   <!-- Campo para seleccionar meses -->
                                <div class="form-group" id="meses_container" style="display: none;">
                                    <label for="meses">¿A cuántos meses lo requiere?</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeValue(-1)">-</button>
                                        <input type="number" id="meses" name="meses" class="form-control" value="1" min="1" max="90" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="changeValue(1)">+</button>
                                    </div>
                                </div>

                                <div class="form-group" id="monto_primer_pago_container" style="display: none;">
                                    <label for="monto_primer_pago">Monto del Primer Pago:</label>
                                    <input type="number" name="monto_primer_pago" id="monto_primer_pago" class="form-control" step="0.01" readonly>
                                </div>


                                    <div class="form-group">
                                        <label for="fecha_hora_pago">Fecha del primer pago</label>
                                        <input type="date" name="fecha_hora_pago" id="fecha_hora_pago" class="form-control" required>
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
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
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
                @foreach ($ventas as $index => $venta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $venta->contacto->nombre }}</td>
                        <td>{{ $venta->fecha_venta }}</td>
                        <td>{{ $venta->modalidad_enganche_nombre }}</td>
                        <td>{{ $venta->asesor }}</td>
                        <td>{{ $venta->numero_contrato }}</td>
                        <td>${{ $venta->precio_venta_final }}</td>
                        <td>
                      <!--  <button
                            class="btn btn-warning btn-sm btnEditarVenta"
                            data-id="{{ $venta->id }}"
                            data-contacto-id="{{ $venta->contacto_id }}"
                            data-fecha-venta="{{ $venta->fecha_venta }}"
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
                        </button>-->
                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            @if($venta->modalidad_enganche == 2 || $venta->credito)
                                <a href="{{ route('generarCartaFiniquito', ['id' => $venta->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                            @endif
                            @if($venta->modalidad_enganche == 1 || $venta->contado)
                            <a href="{{ route('generarCartaFiniquitoContado', ['id' => $venta->id]) }}" class="btn" style="background-color: #FFD700; color: black;" target="_blank">
                                <i class="fas fa-copyright"></i>
                            </a>
                            @endif
                            @if($venta->modalidad_enganche == 1 || $venta->contado) 
                            <a href="{{ route('contrato.descargar', $venta->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-download"></i> 
                            </a>
                            @endif
                            @if($venta->modalidad_enganche == 1 || $venta->contado) 
                            <!-- Botón para generar el comprobante -->
                            <a href="{{ route('generarAut', $venta->id) }}" class="btn btn-primary"  style="background-color:rgb(0, 255, 72); color: black;" target="_blank"></a>
                            </a>
                            @endif
                            <a href="{{ route('contrato.descargar.credito', $venta->id) }}" class="btn btn-success btn-sm" 
                                @if($venta->modalidad_enganche == 2 || $venta->credito) 
                                    style="display: inline;" 
                                @else 
                                    style="display: none;" 
                                @endif
                            >
                                <i class="fas fa-download"></i>
                            </a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </t>
    </div>
  <!-- Paginación -->
<div class="d-flex justify-content-center">
    {{ $ventas->links('pagination::bootstrap-5') }}
</div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


        <script>
    var $j = jQuery.noConflict();

    $j(document).ready(function () {

        // Función para manejar los cambios en el valor del contador de meses
        function changeValue(change) {
            var $mesInput = $j('#meses');
            var currentValue = parseInt($mesInput.val());
            var newValue = currentValue + change;

            if (newValue >= 1 && newValue <= 90) {
                $mesInput.val(newValue); // Establece el nuevo valor en el input
            }
        }

        // Asignar eventos a los botones de incremento y decremento
        $j('#meses_container .btn-outline-secondary').click(function() {
            var change = $j(this).text() === '+' ? 1 : -1;
            changeValue(change);
            calcularMontoPrimerPago(); // Actualizar monto primer pago al cambiar los meses
        });

        // Obtener los elementos del DOM
        const modalidadEnganche = document.getElementById('modalidad_enganche');
        const mesesContainer = document.getElementById('meses_container');
        const engancheContainer = document.getElementById('enganche_container');
        const cantidadPagosContainer = document.getElementById('cantidad_pagos_container');
        const montoPrimerPagoContainer = document.getElementById('monto_primer_pago_container'); // Contenedor de monto primer pago
        const fechaFinalizacionContainer = document.getElementById('fecha_finalizacion').parentElement; // Contenedor de fecha de finalización
        const fechaInicioContainer = document.getElementById('fecha_inicio').parentElement; // Contenedor de fecha de pago diferido

        const mesesInput = document.getElementById('meses');
        const engancheInput = document.getElementById('enganche');
        const cantidadPagosInput = document.getElementById('cantidad_pagos');

        // Función para calcular el monto del primer pago
        function calcularMontoPrimerPago() {
            var precioVentaFinal = parseFloat($j('#precio_venta_final').val()) || 0;
            var enganche = parseFloat($j('#enganche').val()) || 0;
            var meses = parseInt($j('#meses').val()) || 1; // Asegúrate de que meses sea un número válido (por defecto 1 si es NaN)
    
            var montoRestante = precioVentaFinal - enganche;
            var primerPago = montoRestante / meses;

            // Redondear el primer pago a 2 decimales
            primerPago = Math.round(primerPago * 100) / 100;
            // Formatear el monto primer pago con separador de miles y decimales
            var primerPagoFormateado = primerPago.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Formato con coma como separador de miles

            // Asignar el valor calculado y formateado al campo de Monto Primer Pago (para mostrarlo)
            $j('#monto_primer_pago_display').val(primerPagoFormateado); // Mostrar valor formateado

            // Asignar el valor numérico al campo de Monto Primer Pago
            $j('#monto_primer_pago').val(primerPago); // Solo el valor numérico sin formato
        }

        // Llamar a la función al cambiar cualquiera de los campos involucrados
        $j('#precio_venta_final, #enganche, #meses').on('input', function() {
            calcularMontoPrimerPago();
        });

        // Manejar el evento de cambio
        modalidadEnganche.addEventListener('change', function () {
            if (this.value === "2") { // Si selecciona "CRÉDITO"
                // Mostrar los campos
                mesesContainer.style.display = 'block';
                engancheContainer.style.display = 'block';
                cantidadPagosContainer.style.display = 'block';
                montoPrimerPagoContainer.style.display = 'block'; // Mostrar el contenedor de monto primer pago
                fechaFinalizacionContainer.style.display = 'block'; // Mostrar el contenedor de fecha de finalización
                fechaInicioContainer.style.display = 'block'; // Mostrar el contenedor de fecha de pago diferido

                // Hacer los campos requeridos
                mesesInput.setAttribute('required', 'required');
                engancheInput.setAttribute('required', 'required');
                cantidadPagosInput.setAttribute('required', 'required');
                document.getElementById('fecha_finalizacion').setAttribute('required', 'required'); // Hacer requerido
                document.getElementById('fecha_inicio').setAttribute('required', 'required'); // Hacer requerido
            } else {
                // Ocultar los campos
                mesesContainer.style.display = 'none';
                engancheContainer.style.display = 'none';
                cantidadPagosContainer.style.display = 'none';
                montoPrimerPagoContainer.style.display = 'none'; // Ocultar el contenedor de monto primer pago
                fechaFinalizacionContainer.style.display = 'none'; // Ocultar el contenedor de fecha de finalización
                fechaInicioContainer.style.display = 'none'; // Ocultar el contenedor de fecha de pago diferido

                // Eliminar el atributo 'required' de los campos
                mesesInput.removeAttribute('required');
                engancheInput.removeAttribute('required');
                cantidadPagosInput.removeAttribute('required');
                document.getElementById('fecha_finalizacion').removeAttribute('required'); // Eliminar requerido
                document.getElementById('fecha_inicio').removeAttribute('required'); // Eliminar requerido
            }
        });
            // Función para calcular la última fecha de pago
            function calcularUltimaFechaPago() {
            var fechaHoraPago = $j('#fecha_hora_pago').val(); // Obtener la fecha y hora de pago
            var meses = parseInt($j('#meses').val()) || 0; // Obtener los meses, asegurándose de que sea un número válido

            if (fechaHoraPago && meses > 0) {
                var fecha = new Date(fechaHoraPago);
                fecha.setMonth(fecha.getMonth() + meses); // Sumar los meses a la fecha de pago

                // Formatear la fecha en formato YYYY-MM-DD
                var ultimaFechaPago = fecha.toISOString().split('T')[0];
                $j('#fecha_finalizacion').val(ultimaFechaPago); // Asignar la última fecha de pago al campo correspondiente
            } else {
                $j('#fecha_finalizacion').val(''); // Vaciar el campo si los valores son inválidos
            }
        }

        // Llamar a la función al cambiar los valores de fecha_hora_pago o meses
        $j('#fecha_hora_pago, #meses').on('change input', function () {
            calcularUltimaFechaPago();
        });


            $j('#guardarVentaBtn').click(function(e) {
    e.preventDefault(); // Prevenir el comportamiento de envío por defecto

    // Validación de meses (solo si la modalidad de enganche es "Crédito" - valor 2)
    var modalidad = $j('#modalidad_enganche').val();
    var meses = parseInt($j('#meses').val());

    if (modalidad === "2" && (isNaN(meses) || meses < 1 || meses > 90)) {
        alert('El valor de meses debe ser un número entre 1 y 90.');
        return;
    }

    // Construir formData correctamente sin tipo_venta
    var formData = {
        'contacto_id': $j('#contacto_id').val(),
        'fecha_venta': $j('#fecha_venta').val(),
        'asesor': $j('#asesor').val(),
        'numero_contrato': $j('#numero_contrato').val(),
        'aval': $j('#aval').val() || null,
        'lote_id': $j('#lote_id').val(),
        'manzana_id': $j('#manzana_id').val(),
        'fecha_inicio': $j('#fecha_inicio').val(),
        'precio_venta_final': $j('#precio_venta_final').val(),
        'descripcion': $j('#descripcion').val() || null,
        'observacion': $j('#observacion').val() || null,
        'comprobante': $j('#comprobante').val(),
        'numero_comprobante': $j('#numero_comprobante').val(),
        'forma_pago': $j('#forma_pago').val(),
        'banco_id': $j('#banco_id').val(),
        'codigo_operacion': $j('#codigo_operacion').val(),
        'monto_primer_pago': $j('#monto_primer_pago').val(),
        'fecha_hora_pago': $j('#fecha_hora_pago').val(),
        'modalidad_enganche': modalidad,
        'fecha_finalizacion': $j('#fecha_finalizacion').val() || null,
        'observacion_finalizacion': $j('#observacion_finalizacion').val() || null,
    };

    // Incluir modalidad de enganche si es "Crédito" (2)
    if (modalidad === "2") {
        formData['meses'] = $j('#meses').val() || null;
        formData['enganche'] = $j('#enganche').val() || null;
        formData['cantidad_pagos'] = $j('#cantidad_pagos').val() || null;
    } else {
        formData['meses'] = null;
        formData['enganche'] = null;
        formData['cantidad_pagos'] = null;
    }

    // Validación manual de campos obligatorios sin tipo_venta
    var camposObligatorios = ['contacto_id', 'fecha_venta', 'asesor', 'numero_contrato', 'comprobante', 'numero_comprobante', 'forma_pago', 'codigo_operacion', 'monto_primer_pago', 'fecha_hora_pago'];

    for (var i = 0; i < camposObligatorios.length; i++) {
        var campo = camposObligatorios[i];
        if (!formData[campo] || formData[campo] === "") {
            alert(`El campo ${campo.replace('_', ' ')} es obligatorio.`);
            return;
        }
    }

    // Mostrar el contenido del formData para depuración
    console.log('FormData:', formData);

    // Enviar la solicitud AJAX
    $j.ajax({
        url: '{{ route('ventas.store') }}', // Asegúrate de que esta ruta sea correcta
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF en los headers
        },
        success: function(response) {
            console.log('Venta guardada con éxito:', response);
            alert("Venta guardada con éxito.");
            location.reload(); // Recarga la página después de guardar la venta
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            console.log('Detalles de la respuesta:', xhr.responseText); // Ver el contenido completo del error
            alert('Ocurrió un error al guardar la venta, por favor inténtelo de nuevo.');

            // Mostrar errores devueltos por Laravel
            try {
                var errores = JSON.parse(xhr.responseText);
                if (errores.errors) {
                    var mensajeError = Object.values(errores.errors).flat().join("\n");
                    alert(mensajeError);
                }
            } catch (e) {
                console.error('Error al parsear JSON de respuesta:', e);
            }
        }
    });
});


        // Buscar contactos a medida que se escribe
        document.getElementById('contacto_search').addEventListener('input', function () {
            const query = this.value;
            const resultsList = document.getElementById('contacto_results');

            // No buscar si hay menos de 2 caracteres
            if (query.length < 2) {
                resultsList.classList.add('d-none');
                return;
            }

            fetch(`/buscar-contactos?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsList.innerHTML = '';
                    if (data.length > 0) {
                        resultsList.classList.remove('d-none');
                        data.forEach(contacto => {
                            const nombreCompleto = `${contacto.nombre || ''} ${contacto.apellidos || ''}`.trim();
                            const item = document.createElement('li');
                            item.textContent = nombreCompleto;
                            item.className = 'list-group-item list-group-item-action';
                            item.addEventListener('click', function () {
                                document.getElementById('contacto_search').value = nombreCompleto;
                                document.getElementById('contacto_id').value = contacto.id;
                                resultsList.classList.add('d-none');
                            });
                            resultsList.appendChild(item);
                        });
                    } else {
                        resultsList.classList.add('d-none');
                    }
                })
                .catch(error => console.error('Error al buscar contactos:', error));
        });

        // Generar valores aleatorios para número de contrato, código de operación y comprobante
        window.onload = function() {
            var contractNumber = 'CONTRATO-' + Math.random().toString(36).substr(2, 6).toUpperCase();
            document.getElementById('numero_contrato').value = contractNumber;

            var operationCode = Math.floor(10000000 + Math.random() * 90000000);
            document.getElementById('codigo_operacion').value = operationCode;

            var comprobanteNumber = Math.floor(1000000000 + Math.random() * 9000000000);
            document.getElementById('numero_comprobante').value = comprobanteNumber;
        };

        document.getElementById('manzana_id').addEventListener('change', function () {
            const manzanaId = this.value;
            const loteSelect = document.getElementById('lote_id');

            loteSelect.innerHTML = '<option value="" selected disabled>Seleccione un lote</option>';

            if (manzanaId) {
                fetch(`/ventas/lotes/por-manzana/${manzanaId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.lotes.length > 0) {
                            data.lotes.forEach(lote => {
                                if (lote.estado !== 'vendido') { // Solo mostrar lotes disponibles
                                    const option = document.createElement('option');
                                    option.value = lote.id;
                                    option.textContent = lote.lote;
                                    loteSelect.appendChild(option);
                                }
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No hay lotes disponibles para esta manzana';
                            loteSelect.appendChild(option);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Función para actualizar la lista de lotes después de eliminar una venta
        function actualizarLotesDisponibles(manzanaId) {
            const loteSelect = document.getElementById('lote_id');
            loteSelect.innerHTML = '<option value="" selected disabled>Seleccione un lote</option>';

            if (manzanaId) {
                fetch(`/ventas/lotes/por-manzana/${manzanaId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.lotes.length > 0) {
                            data.lotes.forEach(lote => {
                                if (lote.estado !== 'vendido') { // Solo mostrar lotes disponibles
                                    const option = document.createElement('option');
                                    option.value = lote.id;
                                    option.textContent = lote.lote;
                                    loteSelect.appendChild(option);
                                }
                            });
                        } else {
                            const option = document.createElement('option');
                            option.value = '';
                            option.textContent = 'No hay lotes disponibles para esta manzana';
                            loteSelect.appendChild(option);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Llamar la función de actualización cuando se elimine una venta
        function eliminarVenta(idVenta) {
            fetch(`/ventas/eliminar/${idVenta}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            })
            .then(response => {
                if (response.ok) {
                    // Obtener el manzana_id actualizado
                    const manzanaId = document.getElementById('manzana_id').value;
                    actualizarLotesDisponibles(manzanaId);
                    alert('Venta eliminada y lote actualizado');
                } else {
                    alert('Error al eliminar la venta');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>


</body></html>