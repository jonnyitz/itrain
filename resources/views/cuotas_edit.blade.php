<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cuota</title>
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ01K2p1a6m/s7f2OK2uJTYjC5mxR1aHftyBc/qDQykE4WlA0mT0YdP8zF1y" crossorigin="anonymous">
    
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding-top: 50px;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 30px;
            font-weight: 600;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
            color: #2c3e50;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
            font-weight: 600;
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .card {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card img {
            border-radius: 5px;
            max-width: 100px;
        }

        .form-group {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Editar Cuota</h2>

        <form action="{{ route('cuotas.update', $cuota->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Contacto -->
            <div class="form-group">
                <label for="contacto_id" class="form-label">Contacto</label>
                <select class="form-control" id="contacto_id" name="contacto_id" required>
                    @foreach($contactos as $contacto)
                        <option value="{{ $contacto->id }}" {{ $cuota->contacto_id == $contacto->id ? 'selected' : '' }}>
                            {{ $contacto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Comprobante -->
            <div class="form-group">
                <label for="comprobante" class="form-label">Comprobante</label>
                <input type="text" class="form-control" id="comprobante" name="comprobante" value="{{ $cuota->comprobante }}" required>
            </div>

            <!-- Número de CTS -->
            <div class="form-group">
                <label for="n_cts" class="form-label">Número de CTS</label>
                <input type="text" class="form-control" id="n_cts" name="n_cts" value="{{ $cuota->n_cts }}" required>
            </div>

            <!-- Tipo -->
            <div class="form-group">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $cuota->tipo }}" required>
            </div>

            <!-- Fecha -->
            <div class="form-group">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $cuota->fecha }}" required>
            </div>

            <!-- Voucher -->
            <div class="form-group">
                <label for="voucher" class="form-label">Voucher (Imagen)</label>
                <input type="file" class="form-control" id="voucher" name="voucher">
                @if ($cuota->voucher)
                    <div class="card">
                        <p>Imagen actual:</p>
                        <img src="{{ asset($cuota->voucher) }}" alt="Voucher">
                    </div>
                @endif
            </div>

            <!-- Banco -->
            <div class="form-group">
                <label for="banco_id" class="form-label">Banco</label>
                <select class="form-control" id="banco_id" name="banco_id">
                    @foreach($bancos as $banco)
                        <option value="{{ $banco->id }}" {{ $cuota->banco_id == $banco->id ? 'selected' : '' }}>
                            {{ $banco->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Forma de Pago -->
            <div class="form-group">
                <label for="forma_de_pago" class="form-label">Forma de Pago</label>
                <input type="text" class="form-control" id="forma_de_pago" name="forma_de_pago" value="{{ $cuota->forma_de_pago }}" required>
            </div>

            <!-- Concepto -->
            <div class="form-group">
                <label for="concep" class="form-label">Concepto</label>
                <input type="text" class="form-control" id="concep" name="concep" value="{{ $cuota->concep }}">
            </div>

            <!-- Cuotas -->
            <div class="form-group">
                <label for="cuotas" class="form-label">Cuotas</label>
                <input type="number" class="form-control" id="cuotas" name="cuotas" value="{{ $cuota->cuotas }}">
            </div>

            <!-- Monto -->
            <div class="form-group">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" class="form-control" id="monto" name="monto" value="{{ $cuota->monto }}" required>
            </div>

            <!-- Botón para actualizar -->
            <button type="submit" class="btn btn-primary">Actualizar Cuota</button>
        </form>
    </div>

    <!-- Enlace a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
