<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ01K2p1a6m/s7f2OK2uJTYjC5mxR1aHftyBc/qDQykE4WlA0mT0YdP8zF1y" crossorigin="anonymous">
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
    </style>
</head>
<body>

    <div class="container">
        <h2>Editar Proyecto</h2>

        <form action="{{ route('proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $proyecto->nombre }}" required>
            </div>

            <!-- Ubicación -->
            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $proyecto->ubicacion }}" required>
            </div>

            <!-- Moneda -->
            <div class="mb-3">
                <label for="moneda" class="form-label">Moneda</label>
                <input type="text" class="form-control" id="moneda" name="moneda" value="{{ $proyecto->moneda }}" required>
            </div>

            <!-- Total de Lotes -->
            <div class="mb-3">
                <label for="total_lotes" class="form-label">Total de Lotes</label>
                <input type="number" class="form-control" id="total_lotes" name="total_lotes" value="{{ $proyecto->total_lotes }}" required>
            </div>

            <!-- Lotes Disponibles -->
            <div class="mb-3">
                <label for="lotes_disponibles" class="form-label">Lotes Disponibles</label>
                <input type="number" class="form-control" id="lotes_disponibles" name="lotes_disponibles" value="{{ $proyecto->lotes_disponibles }}" required>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado" value="{{ $proyecto->estado }}" required>
            </div>

            <!-- Imagen (opcional) -->
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagen" name="imagen">
                @if ($proyecto->imagen)
                    <div class="card mt-2">
                        <p>Imagen actual:</p>
                        <img src="{{ asset('storage/'.$proyecto->imagen) }}" alt="Imagen Proyecto" style="max-width: 100px;">
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label for="propietario" class="form-label">Propietario</label>
                <input type="text" class="form-control" id="propietario" name="propietario" value="{{ $proyecto->propietario }}" required>
            </div>

            <!-- Parcela -->
            <div class="mb-3">
                <label for="parcela" class="form-label">Parcela</label>
                <input type="text" class="form-control" id="parcela" name="parcela" value="{{ $proyecto->parcela }}" required>
            </div>
            <!-- Botón de actualización -->
            <button type="submit" class="btn btn-primary">Actualizar Proyecto</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
