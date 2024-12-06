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
                        @foreach ($manzanas as $manzana)
                        <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="tipo_venta">Filtrar por Tipo de Venta:</label>
                    <select id="tipo_venta" name="tipo_venta" class="form-control">
                        <option value="todas">Todas</option>
                        @foreach ($tiposDeVenta as $tipo)
                        <option value="{{ $tipo->tipo_venta }}">{{ $tipo->tipo_venta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="vendedor">Filtrar por Vendedor:</label>
                    <select id="vendedor" name="vendedor" class="form-control">
                        <option value="todos">Todos los Vendedores</option>
                        @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->vendedor }}">{{ $vendedor->vendedor }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="button-grid mt-3">
                <a href="{{ route('generar_pdf') }}" class="btn btn-info" target="_blank">Vista Previa PDF</a>
                <!-- Botón para Detalle de Venta -->
                <a href="{{ route('detalle_venta') }}" class="btn btn-primary" target="_blank">Detalle de Venta</a>
            </div>
        </div>
        <!-- Nuevo Filtro por Vendedor -->
        <div class="filter-section">
            <h5>Filtrar por Vendedor</h5>
            <div class="form-row">
                <!-- Dropdown de Vendedor -->
                <div class="col">
                    <label for="filtro_vendedor">Seleccionar Vendedor:</label>
                    <select id="filtro_vendedor" name="filtro_vendedor" class="form-control">
                        <option value="todos">Todos los Vendedores</option>
                        @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->vendedor }}">{{ $vendedor->vendedor }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Botones adicionales -->
            <div class="button-grid mt-3">
                <a class="btn btn-primary" target="_blank">Ventas por Vendedor</a>
                <a class="btn btn-primary" target="_blank">Cuotas por Cobrar</a>
            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>