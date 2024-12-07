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

        <div class="container mt-4">
            <!-- Reporte de Ventas -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h2 class="mb-0">Reporte de Ventas </h2>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="form-group">
                        <label for="manzana">Filtrar por Manzana:</label>
                        <select id="manzana" name="manzana" class="form-control">
                            <option value="todas">Todas...</option>
                            @foreach ($manzanas as $manzana)
                            <option value="{{ $manzana->id }}">{{ $manzana->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_venta">Filtrar por Tipo de Venta:</label>
                        <select id="tipo_venta" name="tipo_venta" class="form-control">
                            <option value="todas">Todos...</option>
                            @foreach ($tiposDeVenta as $tipo)
                            <option value="{{ $tipo->tipo_venta }}">{{ $tipo->tipo_venta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones relacionados -->
                    <div class="button-grid my-3">
                        <a href="{{ route('generar_pdf') }}" class="btn btn-outline-primary btn-block" target="_blank">
                            <i class="bi bi-file-earmark-pdf"></i> Reporte de Ventas
                        </a>
                        <a href="{{ route('detalle_venta') }}" class="btn btn-outline-info btn-block" target="_blank">
                            <i class="bi bi-file-earmark-text"></i> Detalle de Ventas
                        </a>
                    </div>


                    <!-- Separador -->
                    <hr>

                    <!-- Filtro por Vendedor -->
                    <div class="form-group">
                        <label for="filtro_vendedor">Filtrar por Vendedor:</label>
                        <select id="filtro_vendedor" name="filtro_vendedor" class="form-control">
                            <option value="todos">Todos los Vendedores...</option>
                            @foreach ($vendedores as $vendedor)
                            <option value="{{ $vendedor->vendedor }}">{{ $vendedor->vendedor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones adicionales -->
                    <div class="button-grid my-3">
                        <a href="{{ route('ventas_por_vendedor', ['vendedor' => 'todos']) }}" class="btn btn-outline-primary btn-block" target="_blank">
                            <i class="bi bi-person-lines-fill"></i> Ventas x Vendedor
                        </a>
                        <a href="#" class="btn btn-outline-info btn-block">
                            <i class="bi bi-wallet"></i> Cuotas x Cobrar
                        </a>
                    </div>

                    <!-- Separador -->
                    <hr>

                    <!-- Botones generales -->
                    <div class="button-grid mt-4">
                        <button class="btn btn-outline-secondary btn-block">
                            <i class="bi bi-check-card"></i> Ventas Completadas
                        </button>
                        <button class="btn btn-outline-success btn-block">
                            <i class="bi bi-credit-card"></i> Créditos por Cobrar
                        </button>
                        <button class="btn btn-outline-danger btn-block">
                            <i class="bi bi-x-card"></i> Ventas Anuladas
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <!-- Reporte de Ventas por Cliente -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h2 class="mb-0">Reporte de Ventas por Cliente </h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="cliente">Cliente con Venta Exitosa <span class="text-danger">*</span></label>
                        <input type="text" id="cliente" name="cliente" class="form-control" placeholder="Buscar cliente...">
                    </div>
                    <div class="button-grid mt-3">
                        <button class="btn btn-outline-primary btn-block">
                            <i class="bi bi-person-check"></i> Ventas x Cliente
                        </button>
                        <button class="btn btn-outline-info btn-block">
                            <i class="bi bi-receipt"></i> Recibos x Cliente
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reporte de Vouchers / Carta Cobranza -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h2 class="mb-0">Reporte de Vouchers / Carta Cobranza </h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="cliente_credito">Cliente con Venta al Crédito Exitosa <span class="text-danger">*</span></label>
                        <input type="text" id="cliente_credito" name="cliente_credito" class="form-control" placeholder="Buscar Cliente con Venta al Crédito Exitosa...">
                    </div>
                    <div class="button-grid mt-3">
                        <button class="btn btn-outline-primary btn-block">
                            <i class="bi bi-cash-stack"></i> Vouchers x Venta
                        </button>
                        <button class="btn btn-outline-info btn-block">
                            <i class="bi bi-envelope"></i> Carta Cobranza
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>