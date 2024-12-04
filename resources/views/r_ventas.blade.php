<!DOCTYPE<!DOCTYPE html>
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
        .button-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .form-control {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Reporte Ventas</h1>

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

    <!-- Reporte de Ventas -->
    <div class="filter-section mb-4">
        <h2 class="filter-header">Reporte de Ventas LOS ROBLES</h2>
        <div class="form-row">
            <div class="col">
                <label for="manzana">Filtrar por Manzana:</label>
                <select id="manzana" name="manzana" class="form-control">
                    <option value="todas">Todas</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>
            <div class="col">
                <label for="tipo_venta">Filtrar por Tipo de Venta:</label>
                <select id="tipo_venta" name="tipo_venta" class="form-control">
                    <option value="todas">Todas</option>
                    <option value="contado">Contado</option>
                    <option value="credito">Crédito</option>
                </select>
            </div>
            <div class="col">
                <label for="vendedor">Filtrar por Vendedor:</label>
                <select id="vendedor" name="vendedor" class="form-control">
                    <option value="todos">Todos los Vendedores</option>
                    <option value="vendedor1">Vendedor 1</option>
                    <option value="vendedor2">Vendedor 2</option>
                </select>
            </div>
        </div>

        <div class="button-grid mt-3">
            <button class="btn btn-primary">Ventas Completadas</button>
            <button class="btn btn-secondary">Reporte de Ventas</button>
            <button class="btn btn-info">Detalle de Ventas</button>
            <button class="btn btn-success">Créditos por Cobrar</button>
        </div>
    </div>

    <!-- Reporte por Cliente -->
    <div class="filter-section mb-4">
        <h2 class="filter-header">Reporte de Ventas por Cliente LOS ROBLES</h2>
        <div class="form-row">
            <div class="col">
                <label for="cliente_venta_exitosa">Cliente con Venta Exitosa:</label>
                <input type="text" id="cliente_venta_exitosa" name="cliente_venta_exitosa" class="form-control" placeholder="Buscar cliente">
            </div>
        </div>
        <div class="button-grid mt-3">
            <button class="btn btn-warning">Ventas x Cliente</button>
            <button class="btn btn-dark">Recibos x Cliente</button>
        </div>
    </div>

    <!-- Reporte de Vouchers -->
    <div class="filter-section mb-4">
        <h2 class="filter-header">Reporte de Vouchers / Carta Cobranza LOS ROBLES</h2>
        <div class="form-row">
            <div class="col">
                <label for="cliente_credito">Cliente con Venta al Crédito Exitosa:</label>
                <input type="text" id="cliente_credito" name="cliente_credito" class="form-control" placeholder="Buscar cliente">
            </div>
        </div>
        <div class="button-grid mt-3">
            <button class="btn btn-primary">Vouchers x Venta</button>
            <button class="btn btn-secondary">Carta Cobranza</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
