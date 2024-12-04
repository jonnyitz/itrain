<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Lotes</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Fondo claro */
        }
        .container {
            margin-top: 50px;
        }
        .btn-custom {
            padding: 15px;
            font-size: 16px;
            border-radius: 8px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .row {
            margin-bottom: 20px; /* Espaciado entre filas */
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Reporte de Ventas</h2>
    <div class="row">
        <div class="col-md-6 text-center">
            <a class="btn btn-primary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Total de Lotes
            </a>
        </div>
        <div class="col-md-6 text-center">
            <a class="btn btn-secondary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Lotes Disponibles
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <a class="btn btn-primary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Lotes Vendidos
            </a>
        </div>
        <div class="col-md-6 text-center">
            <a class="btn btn-secondary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Lotes Reservados
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 text-center">
            <a class="btn btn-primary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Total Lotes Detalle
            </a>
        </div>
        <div class="col-md-6 text-center">
            <a class="btn btn-secondary btn-block btn-custom">
                <i class="fas fa-file-pdf"></i> Reporte General Detallado
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
