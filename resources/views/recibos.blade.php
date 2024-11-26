<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Recibos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestión de Recibos</h1>
        
        <!-- Barra de búsqueda -->
         <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar recibos..." onkeyup="filterTable()">
        </div>
        
        <!-- Botón para abrir el modal -->
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoReciboModal">
                Nuevo Recibo
            </button>
        </div>

        <!-- Tabla de recibos -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Clientes</th>
                    <th>Concepto</th>
                    <th>Tipo Recibo</th>
                    <th>Fecha</th>
                    <th>Correlativo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recibos as $index => $recibo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $recibo->contacto->nombre }}</td>
                        <td>{{ $recibo->monto }}</td>
                        <td>{{ $recibo->tipo_recibo }}</td>
                        <td>{{ $recibo->fecha }}</td>
                        <td>{{ $recibo->correlativo }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm">Editar</a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
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

    <!-- Modal -->
    <div class="modal fade" id="nuevoReciboModal" tabindex="-1" aria-labelledby="nuevoReciboModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoReciboModalLabel">Nuevo Recibo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('recibos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="contacto_id" class="form-label">Cliente</label>
                            <select name="contacto_id" id="contacto_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione un cliente</option>
                                @foreach($contactos as $contacto)
                                    <option value="{{ $contacto->id }}">{{ $contacto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control" placeholder="Ingrese el gasto" required>
                        </div>
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
                            <label for="tipo_recibo" class="form-label">Tipo de Recibo</label>
                            <select name="tipo_recibo" id="tipo_recibo" class="form-select" required>
                                <option value="Recibo De Ingreso (Cobro)">Recibo De Ingreso (Cobro)</option>
                                <option value="Recibo De Salida (Gasto)">Recibo De Salida (Gasto)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correlativo" class="form-label">Correlativo</label>
                            <input type="text" name="correlativo" id="correlativo" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script de búsqueda -->
    <script>
        function filterTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("recibosTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? "" : "none";
            }
        }
    </script>
</body>
</html>
