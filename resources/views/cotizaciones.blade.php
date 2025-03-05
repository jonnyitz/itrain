<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Cotizaciones</h1>
         <!-- Botón Nuevo -->
         <button class="btn btn-success mb-4" data-toggle="modal" data-target="#nuevoCotizacionModal">Nuevo</button>

        <!-- Barra de Búsqueda -->
        <div class="mb-3">
            <input type="text" class="form-control" id="search" placeholder="Buscar...">
        </div>

        <!-- Tabla de Cotizaciones -->
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Lote/Manzana</th>
            <th>Cotizador</th>
            <th>Tipo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Verificar si hay cotizaciones -->
        @if($cotizaciones->isEmpty())
            <tr>
                <td colspan="5" class="text-center">No hay cotizaciones disponibles.</td>
            </tr>
        @else
            <!-- Aquí se llenarán los datos de la base de datos -->
            @foreach($cotizaciones as  $index => $cotizacion)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cotizacion->contacto->nombre }}</td>
                    <td>{{ $cotizacion->lote->lote }}</td>
                    <td>{{ $cotizacion->cotizador->nombre }}</td>
                    <td>{{ $cotizacion->tipo->nombre }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                        <!-- Botón para PDF -->
                        <button class="btn btn-warning btn-sm" title="Descargar PDF">
                            <i class="fas fa-file-pdf"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>


       
        <!-- Modal para Nuevo Cotización -->
        <div class="modal fade" id="nuevoCotizacionModal" tabindex="-1" aria-labelledby="nuevoCotizacionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevoCotizacionModalLabel">Nueva Cotización</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('cotizaciones.store') }}" method="POST">
                            @csrf
                            <!-- Contacto -->
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <select class="form-control" id="contacto" name="contacto_id" required>
                                    @foreach($contactos as $contacto)
                                        <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Lote -->
                            <div class="form-group">
                                <label for="lote">Lote</label>
                                <select class="form-control" id="lote" name="lote_id" required>
                                    @foreach($lotes as $lote)
                                        <option value="{{ $lote->id }}">{{ $lote->lote }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cotizador -->
                            <div class="form-group">
                                <label for="cotizador">Cotizador</label>
                                <select class="form-control" id="cotizador" name="cotizador_id" required>
                                    @foreach($cotizadores as $cotizador)
                                        <option value="{{ $cotizador->id }}">{{ $cotizador->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tipo -->
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <select class="form-control" id="tipo" name="tipo_id" required>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Modalidad -->
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <select class="form-control" id="modalidad" name="modalidad" required>
                                    <option value="quincenal">Quincenal</option>
                                    <option value="mensual">Mensual</option>
                                    <option value="bimestral">Bimestral</option>
                                    <option value="trimestral">Trimestral</option>
                                    <option value="cuatrimestral">Cuatrimestral</option>
                                    <option value="anual">Anual</option>
                                </select>
                            </div>
                            <!-- Fecha de Primer Pago -->
                            <div class="form-group">
                                <label for="fecha_primer_pago">Fecha de Primer Pago</label>
                                <input type="date" class="form-control" id="fecha_primer_pago" name="fecha_primer_pago" required>
                            </div>

                            <!-- Primer Pago del Enganche -->
                            <div class="form-group">
                                <label for="primer_pago_enganche">Primer Pago del Enganche</label>
                                <input type="number" step="0.01" class="form-control" id="primer_pago_enganche" name="primer_pago_enganche" required>
                            </div>

                            <!-- Precio de Venta Final -->
                            <div class="form-group">
                                <label for="precio_venta_final">Precio de Venta Final</label>
                                <input type="number" step="0.01" class="form-control" id="precio_venta_final" name="precio_venta_final" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script para la barra de búsqueda -->
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>
</html>
