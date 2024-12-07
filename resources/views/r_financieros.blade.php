<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Ventas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .filter-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-header {
            font-weight: bold;
            font-size: 1.2em;
            color: #333;
        }

        .button-grid button {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .button-grid {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-header {
            border-bottom: 2px solid #ddd;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1.5rem 0;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Sección de Filtros Generales -->
        <div class="filter-section mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="filter-header">Filtros Generales - Rango de Fechas</h2>
                <div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                    </label>
                    <span>Filtrar por Fechas</span>
                </div>
            </div>
            <div class="form-row mt-3">
                <div class="col">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                </div>
                <div class="col">
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                </div>
            </div>
        </div>

        <!-- Reporte de Ingresos -->
        <div class="filter-section mb-4">
            <h2 class="filter-header">Reporte de Ingresos</h2>

            <!-- Filtro por Forma de Pago -->
            <div class="form-row">
                <div class="col">
                    <label for="forma_pago">Filtrar por Forma de Pago:</label>
                    <select id="forma_pago" name="forma_pago" class="form-control">
                        <option value="todas">Todas</option>
                        <!-- Agregar opciones de forma de pago aquí -->
                    </select>
                </div>
            </div>

            <!-- Botones Reporte de Ingresos y Recibos Emitidos -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-primary btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte de Ingresos
                </a>
                <a class="btn btn-outline-info btn-block" target="_blank">
                    <i class="bi bi-file-earmark-text"></i> Recibos Emitidos
                </a>
            </div>

            <!-- Filtro por Tipo de Cuota -->
            <div class="form-row mt-4">
                <div class="col">
                    <label for="tipo_cuota">Filtrar por Tipo de Cuota:</label>
                    <select id="tipo_cuota" name="tipo_cuota" class="form-control">
                        <option value="todas">Todas</option>
                        <!-- Agregar opciones de tipo de cuota aquí -->
                    </select>
                </div>
            </div>

            <!-- Botón Reporte Cobro Cuotas -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-warning btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte Cobro Cuotas
                </a>
            </div>

            <!-- Filtro por Banco/Caja Interna -->
            <div class="form-row mt-4">
                <div class="col">
                    <label for="banco_caja">Filtrar por Banco / Caja Interna:</label>
                    <select id="banco_caja" name="banco_caja" class="form-control">
                        <option value="todos">Todos</option>
                        <!-- Agregar opciones de banco/caja interna aquí -->
                    </select>
                </div>
            </div>

            <!-- Botón Ingreso por Banco -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-success btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Ingreso por Banco
                </a>
            </div>
        </div>

        <!-- Reporte de Gastos -->
        <div class="filter-section mb-4">
            <h2 class="filter-header">Reporte de Gastos</h2>

            <!-- Filtro por Tipo de Gasto -->
            <div class="form-row">
                <div class="col">
                    <label for="tipo_gasto">Filtrar por Tipo de Gasto:</label>
                    <select id="tipo_gasto" name="tipo_gasto" class="form-control">
                        <option value="todos">Todos</option>
                        <!-- Agregar opciones de tipo de gasto aquí -->
                    </select>
                </div>
            </div>

            <!-- Botones Reporte de Gastos y Consolidado de Gastos -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-primary btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte de Gastos
                </a>
                <a class="btn btn-outline-info btn-block" target="_blank">
                    <i class="bi bi-file-earmark-text"></i> Consolidado de Gastos
                </a>
            </div>

            <!-- Filtro por Concepto -->
            <div class="form-row mt-4">
                <div class="col">
                    <label for="concepto">Filtrar por Concepto:</label>
                    <select id="concepto" name="concepto" class="form-control">
                        <option value="todos">Todos</option>
                        <!-- Agregar opciones de concepto aquí -->
                    </select>
                </div>
            </div>

            <!-- Botón Gastos por Concepto -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-warning btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Gastos por Concepto
                </a>
            </div>

            <!-- Filtro por Sedes -->
            <div class="form-row mt-4">
                <div class="col">
                    <label for="sede">Filtrar por Sede:</label>
                    <select id="sede" name="sede" class="form-control">
                        <option value="todas">Todas</option>
                        <!-- Agregar opciones de sede aquí -->
                    </select>
                </div>
            </div>

            <!-- Botón Gastos por Sede -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-success btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Gastos por Sede
                </a>
            </div>
        </div>
        <!-- Reporte de Ingresos y Gastos -->
        <div class="filter-section mb-4">
            <h2 class="filter-header">Reporte de Ingresos y Gastos</h2>

            <!-- Filtro por Proyecto -->
            <div class="form-row">
                <div class="col">
                    <label for="proyecto">Filtrar por Proyecto:</label>
                    <select id="proyecto" name="proyecto" class="form-control">
                        <option value="todos">Todos</option>
                        <!-- Agregar opciones de proyecto aquí -->
                    </select>
                </div>
            </div>

            <!-- Botón Reporte de Ingresos y Gastos -->
            <div class="button-grid mt-3">
                <a class="btn btn-outline-primary btn-block" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Reporte de Ingresos y Gastos
                </a>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>