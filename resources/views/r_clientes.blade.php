<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            /* Fondo claro */
        }

        .container {
            margin-top: 50px;
        }

        .filter-section {
            margin-bottom: 30px;
        }

        .filter-header {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-custom {
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
            width: 100%;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
            background-color: transparent;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }

        .row {
            margin-bottom: 20px;
            /* Espaciado entre filas */
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center mb-4">Reporte de Clientes</h2>

        <!-- Filtros de búsqueda -->
        <div class="filter-section">
            <div class="form-row">
                <div class="col">
                    <label for="tipo_cliente">Filtrar por Tipo de Cliente:</label>
                    <select id="tipo_cliente" name="tipo_cliente" class="form-control">
                        <option value="todos">Todos</option>
                        <option value="potencial">Potenciales</option>
                        <option value="activo">Activos</option>
                        <!-- Agregar más opciones si es necesario -->
                    </select>
                </div>
            </div>
        </div>

        <!-- Botones de reporte -->
        <div class="row">
            <div class="col-md-6 text-center">
                <a href="{{ route('clientes.pdf') }}" target="_blank" class="btn btn-outline-primary btn-block btn-custom">
                    <i class="fas fa-file-pdf"></i> Lista de Clientes PDF
                </a>
            </div>
            <div class="col-md-6 text-center">
                <a target="_blank" class="btn btn-outline-secondary btn-block btn-custom">
                    <i class="fas fa-file-pdf"></i> Clientes Potenciales PDF
                </a>
            </div>
        </div>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>