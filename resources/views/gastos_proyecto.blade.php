<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos del Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Gastos del Proyecto</h1>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('gastos_proyecto.index') }}" class="mb-4">
        <input type="text" name="search" placeholder="Buscar..." class="form-control" value="{{ $search ?? '' }}">
    </form>

    <!-- Botón para abrir el modal de nuevo gasto -->
    <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#nuevoGastoModal">Nuevo</button>

    <!-- Tabla de gastos -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Observación</th>
                <th>Constancia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gastos as $index => $gasto)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $gasto->concepto }}</td>
                    <td>${{ number_format($gasto->monto, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $gasto->observacion }}</td>
                    <td>
                        <!-- Verificar si existe una imagen de constancia y mostrarla en un modal -->
                        @if($gasto->constancia)
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imagenModal{{ $gasto->id }}">Ver Imagen</button>
                        @else
                            <p>No hay imagen</p>
                        @endif
                    </td>
                    <td>
                        <!-- Aquí podrías agregar botones de editar/eliminar -->
                        <button class="btn btn-secondary btn-sm">Editar</button>
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

    {{ $gastos->links() }}
</div>

<!-- Modal de Imagen (se genera dinámicamente para cada gasto) -->
@foreach($gastos as $gasto)
<div class="modal fade" id="imagenModal{{ $gasto->id }}" tabindex="-1" aria-labelledby="imagenModalLabel{{ $gasto->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagenModalLabel{{ $gasto->id }}">Constancia de Gasto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($gasto->constancia)
                <p><img src="{{ asset('storage/' . $gasto->constancia) }}" alt="Imagen del proyecto" style="width: 200px;"></p>
                @else
                    <p>No hay imagen disponible</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal de Nuevo Gasto -->
<div class="modal fade" id="nuevoGastoModal" tabindex="-1" aria-labelledby="nuevoGastoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('gastos_proyecto.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoGastoModalLabel">Nuevo Gasto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="concepto" class="form-label">Concepto de Gasto</label>
                        <select id="concepto" name="concepto" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="Egreso de Enganche">Egreso de Enganche</option>
                            <option value="Pago de Comision">Pago de Comision</option>
                            <option value="Devolucion por Cancelacion">Devolucion por Cancelacion</option>
                            <option value="Condonacion General de Pago">Condonacion General de Pago</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                        <select id="metodo_pago" name="metodo_pago" class="form-select" required>
                            <option value="">Seleccionar...</option>
                            <option value="DEPOSITO EN EFECTIVO (BANCARIO)">DEPOSITO EN EFECTIVO (BANCARIO)</option>
                            <option value="TRANSFERENCIA BANCARIA">TRANSFERENCIA BANCARIA</option>
                            <option value="PAGO EN EFECTIVO">PAGO EN EFECTIVO</option>
                            <option value="TARJETA DE CRÉDITO">TARJETA DE CRÉDITO</option>
                            <option value="TARJETA DE DÉBITO">TARJETA DE DÉBITO</option>
                            <option value="PAGO CON CHEQUE">PAGO CON CHEQUE</option>
                            <option value="MONEY ORDER">MONEY ORDER</option>
                            <option value="PAYPAL">PAYPAL</option>
                            <option value="VALE A LA VISTA">VALE A LA VISTA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="constancia" class="form-label">Constancia (Imagen)</label>
                        <input type="file" class="form-control" id="constancia" name="constancia" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
