<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Editar Registro</h2>
        <form action="{{ route('gastosgenerales.update', $gasto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Concepto</label>
                <input type="text" class="form-control" name="concepto" value="{{ $gasto->concepto }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Monto</label>
                <input type="number" class="form-control" name="monto" value="{{ $gasto->monto }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" value="{{ $gasto->fecha }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Observación</label>
                <textarea class="form-control" name="observacion">{{ $gasto->observacion }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Método de Pago</label>
                <input type="text" class="form-control" name="metodo_pago" value="{{ $gasto->metodo_pago }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Constancia (Imagen)</label>
                <input type="file" class="form-control" name="constancia">
                @if ($gasto->constancia)
                    <p>Imagen actual:</p>
                    <img src="{{ asset('storage/' . $gasto->constancia) }}" alt="Constancia" width="100">
                @endif
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
