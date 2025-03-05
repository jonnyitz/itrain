<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Concepto</title>
    <!-- Enlace al archivo de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Concepto</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Formulario de Edición de Concepto</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('conceptos.update', $concepto->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Campo para concepto -->
                            <div class="form-group">
                                <label for="concepto">Concepto</label>
                                <input type="text" name="concepto" id="concepto" class="form-control @error('concepto') is-invalid @enderror" value="{{ old('concepto', $concepto->concepto) }}" required>
                                @error('concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo para tipo de concepto -->
                            <div class="form-group">
                                <label for="tipo_concepto">Tipo de Concepto</label>
                                <input type="text" name="tipo_concepto" id="tipo_concepto" class="form-control @error('tipo_concepto') is-invalid @enderror" value="{{ old('tipo_concepto', $concepto->tipo_concepto) }}" required>
                                @error('tipo_concepto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Botones de acción -->
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                                <a href="{{ route('inicio') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
