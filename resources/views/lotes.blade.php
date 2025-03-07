<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Lotes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Gestión de Lotes</h1>

    <!-- Barra de búsqueda -->
    <div class="mb-3">
        <input 
            type="text" 
            id="searchInput" 
            class="form-control" 
            placeholder="Buscar lotes por descripción, precio, estado, etc."
        >
    </div>

    <!-- Botón para abrir el modal -->
    <div class="text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoteModal">
            Agregar Nuevo Lote
        </button>
    </div>

    <!-- Tabla de lotes -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th> 
                <th>Descripción</th>
                <th>Precio Venta</th>
                <th>M.F (ML)</th>
                <th>M.C.D (ML)</th>
                <th>Área</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lotes as  $index => $lote)
                <tr>
                    <td>{{ ($lotes->currentPage() - 1) * $lotes->perPage() + $index + 1 }}</td>
                    <td>{{ str_pad($lote->manzana->nombre, 2, '0', STR_PAD_LEFT) }} -  {{ str_pad($lote->lote, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>${{ number_format($lote->costo_aproximado, 2) }}</td>
                    <td>{{ $lote->medida_costado_derecho }}</td>
                    <td>{{ $lote->medida_frontal }}</td>
                    <td>{{ $lote->area }}m2</td>
                    <td>{{$lote ->estado}}
                    </td>
                    <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editLoteModal-{{ $lote->id }}">
                        Editar
                    </button>
                    <form action="{{ route('lotes.destroy', $lote->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
<!-- Paginación -->
<div class="d-flex justify-content-center" id="pagination-container">
    {{ $lotes->links('pagination::bootstrap-5') }}
</div>

</div>

<!-- Modal para agregar un nuevo lote -->
<div class="modal fade" id="addLoteModal" tabindex="-1" aria-labelledby="addLoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLoteModalLabel">Agregar Nuevo Lote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('lotes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="lote" class="form-label">Lote</label>
                        <input type="text" class="form-control" id="lote" name="lote" required>
                    </div>
                   <!-- Manzana -->
                    <div class="mb-3">
                        <label for="manzana_id" class="form-label">Manzana</label>
                        <select class="form-select" id="manzana_id" name="manzana_id" required>
                            @php
                                // Obtener el proyecto_id de la sesión
                                $proyectoId = session('proyecto_id');
                                
                                // Filtrar las manzanas que pertenecen al proyecto actual
                                $manzanasFiltradas = $manzanas->where('proyecto_id', $proyectoId);
                            @endphp

                            @if($manzanasFiltradas->isNotEmpty())
                                @foreach($manzanasFiltradas as $manzana)
                                    <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>No hay manzanas disponibles para este proyecto.</option>
                            @endif
                        </select>
                    </div>


                    <!-- Denominación y costo -->
                    <div class="mb-3">
                        <label for="denominacion" class="form-label">Denominación del Lote</label>
                        <input type="text" class="form-control" id="denominacion" name="denominacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="costo_aproximado" class="form-label">Costo Aproximado</label>
                        <input type="number" class="form-control" id="costo_aproximado" name="costo_aproximado"  required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_venta_contado" class="form-label">Precio Venta Contado</label>
                        <input type="number" class="form-control" id="precio_venta_contado" name="precio_venta_contado"  required>
                    </div>

                   <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="cancelado">Cancelado</option>
                            <option value="reservado">Reservado</option>
                            <option value="disponible">Disponible</option>
                            <option value="vendido">Vendido</option>
                        </select>
                    </div>


                    <!-- Descripción -->
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>

                    <!-- Medidas -->
                    <div class="mb-3">
                        <h5>Medidas</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="medida_frontal" class="form-label">Frontal/Norte/Noreste (ML)</label>
                                <input type="number" class="form-control" id="medida_frontal" name="medida_frontal" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="medida_costado_derecho" class="form-label">Derecho/Este/Sureste (ML)</label>
                                <input type="number" class="form-control" id="medida_costado_derecho" name="medida_costado_derecho" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="medida_costado_izquierdo" class="form-label">Izquierdo/Oeste/Noroeste (ML)</label>
                                <input type="number" class="form-control" id="medida_costado_izquierdo" name="medida_costado_izquierdo" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="medida_posterior" class="form-label">Posterior/Fondo/Sur/Suroeste (ML)</label>
                                <input type="number" class="form-control" id="medida_posterior" name="medida_posterior" step="0.01" required>
                            </div>

                            <div class="form-group">
                                <label for="area">Área (m²)</label>
                                <input type="number" step="0.01" class="form-control" id="area" name="area" value="{{ old('area', $lote->area ?? '') }}" placeholder="Ingrese el área del lote">
                            </div>
                        </div>
                    </div>

                    <!-- Colindancias -->
                    <div class="mb-3">
                        <h5>Colindancias</h5>
                        <div class="row">
                        <div class="col-md-6">
                                <label for="colindancia_frontal" class="form-label">Colindancia_frontal</label>
                                <input type="text" class="form-control" id="colindancia_frontal" name="colindancia_frontal" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="colindancia_derecho" class="form-label">Colindancia_derecha</label>
                                <input type="text" class="form-control" id="colindancia_derecho" name="colindancia_derecho" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="colindancia_izquierdo" class="form-label">Colindancia_izquierda</label>
                                <input type="text" class="form-control" id="colindancia_izquierdo" name="colindancia_izquierdo" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label for="colindancia_posterior" class="form-label">colindancia_posterior</label>
                                <input type="text" class="form-control" id="colindancia_posterior" name="colindancia_posterior" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <!-- Observaciones -->
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observaciones del Lote</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="3"></textarea>
                    </div>

                    <!-- Precio por M2 -->
                    <div class="mb-3">
                        <label for="precio_m2" class="form-label">Precio M2 ($)</label>
                        <input type="number" class="form-control" id="precio_m2" name="precio_m2" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="precio_venta_final" class="form-label">Precio Venta Final</label>
                        <input type="text" class="form-control" id="precio_venta_final" name="precio_venta_final" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Lote</button>
                </form>
            </div>
        </div>
    </div>
</div>
            <!-- Modal de edición -->
            @foreach ($lotes as $lote)
            <div class="modal fade" id="editLoteModal-{{ $lote->id }}" tabindex="-1" aria-labelledby="editLoteModalLabel-{{ $lote->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editLoteModalLabel-{{ $lote->id }}">Editar Lote</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('lotes.update', $lote->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="lote-{{ $lote->id }}" class="form-label">Lote</label>
                                    <input type="text" class="form-control" id="lote-{{ $lote->id }}" name="lote" value="{{ $lote->lote }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="manzana_id-{{ $lote->id }}" class="form-label">Manzana</label>
                                    <select class="form-select" id="manzana_id-{{ $lote->id }}" name="manzana_id" required>
                                        @foreach($manzanas as $manzana)
                                            <option value="{{ $manzana->id }}" {{ $lote->manzana_id == $manzana->id ? 'selected' : '' }}>
                                                {{ $manzana->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="denominacion-{{ $lote->id }}" class="form-label">Denominación</label>
                                    <input type="text" class="form-control" id="denominacion-{{ $lote->id }}" name="denominacion" value="{{ $lote->denominacion }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="costo_aproximado-{{ $lote->id }}" class="form-label">Costo Aproximado</label>
                                    <input type="number" class="form-control" id="costo_aproximado-{{ $lote->id }}" name="costo_aproximado" value="{{ $lote->costo_aproximado }}" step="0.01" required>
                                </div>
                                
                               <!-- Estado -->
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="cancelado">Cancelado</option>
                                    <option value="reservado">Reservado</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="vendido">Vendido</option>
                                </select>
                            </div>


                                <!-- Agrega más campos necesarios -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach


<!-- Bootstrap JS -->
<!-- Bootstrap JS Bundle (incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase(); // Obtener el texto del filtro en minúsculas
        const rows = document.querySelectorAll('#lotesTable tbody tr'); // Seleccionar todas las filas de la tabla
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td'); // Obtener todas las celdas de la fila
            const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' '); // Combinar textos de todas las celdas
            row.style.display = rowText.includes(filter) ? '' : 'none'; // Mostrar u ocultar la fila según el filtro
        });
    });
</script>

</body>
</html>
