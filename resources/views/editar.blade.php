<!-- resources/views/manzanas/editar.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Manzana</title>
    <!-- Puedes agregar tus enlaces de estilo aquí -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Editar Manzana</h2>

        <form action="{{ route('manzanas.update', $manzana->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Manzana</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $manzana->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="proyecto_id" class="form-label">Proyecto</label>
                <select class="form-control" id="proyecto_id" name="proyecto_id" required>
                    <option value="" disabled selected>Selecciona un Proyecto</option>
                    @foreach($proyectos as $proyecto)
                        <option value="{{ $proyecto->id }}" {{ $manzana->proyecto_id == $proyecto->id ? 'selected' : '' }}>
                            {{ $proyecto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="vendedor" class="form-label">Vendedor</label>
                <input type="text" class="form-control" id="vendedor" name="vendedor" value="{{ $manzana->vendedor }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('inicio') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Agregar tus scripts de Bootstrap o JS aquí -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
