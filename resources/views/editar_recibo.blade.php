<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Recibo</title>
    <!-- Vincular el archivo CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJxj3PQ5wtqbi6Yxb+gDB4Kn0wlfC3x+qLBcHrrppA5i0gHRE7I8gpaRrYF4" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f7fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
        }
        .btn-primary, .btn-success {
            font-weight: bold;
        }
        .btn-warning {
            background-color: #ff9900;
            color: white;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            color: #333;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .col-md-6 {
            margin-bottom: 15px;
        }
        .form-label {
            font-weight: bold;
        }
        .row {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Editar Recibo</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Formulario de Edición de Recibo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('recibos.update', $recibo->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Campo de Contacto -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contacto_id" class="form-label">Contacto</label>
                                        <input type="text" name="contacto_id" class="form-control" value="{{ old('contacto_id', $recibo->contacto_id) }}" required>
                                    </div>
                                </div>

                                <!-- Campo de Monto -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="monto" class="form-label">Monto</label>
                                        <input type="number" name="monto" class="form-control" value="{{ old('monto', $recibo->monto) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Campo de Tipo de Recibo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_recibo" class="form-label">Tipo de Recibo</label>
                                        <input type="text" name="tipo_recibo" class="form-control" value="{{ old('tipo_recibo', $recibo->tipo_recibo) }}" required>
                                    </div>
                                </div>

                                <!-- Campo de Fecha -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha" class="form-label">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $recibo->fecha) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Campo de Correlativo -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correlativo" class="form-label">Correlativo</label>
                                        <input type="text" name="correlativo" class="form-control" value="{{ old('correlativo', $recibo->correlativo) }}" required>
                                    </div>
                                </div>

                                <!-- Campo de Concepto -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="concepto" class="form-label">Concepto</label>
                                        <input type="text" name="concepto" class="form-control" value="{{ old('concepto', $recibo->concepto) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Campo de Método de Pago -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="metodo_pago" class="form-label">Método de Pago</label>
                                        <input type="text" name="metodo_pago" class="form-control" value="{{ old('metodo_pago', $recibo->metodo_pago) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-group">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                                <a href="{{ route('inicio') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vincular el archivo JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq2lAXJXZa4t7IQbVjY0JrCllZsVmfLfZlT2K4uClNY+a" crossorigin="anonymous"></script>
</body>
</html>
