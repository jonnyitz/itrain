<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Gasto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Gasto</h2>

        <!-- Mostrar errores de validación -->
        <?php if ($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors->all() as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= route('gastos.update', $gasto->id) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-3">
                <label for="concepto" class="form-label">Concepto</label>
                <input type="text" name="concepto" class="form-control" value="<?= old('concepto', $gasto->concepto) ?>" required>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" name="monto" class="form-control" value="<?= old('monto', $gasto->monto) ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="<?= old('fecha', $gasto->fecha) ?>" required>
            </div>

            <div class="mb-3">
                <label for="observacion" class="form-label">Observación</label>
                <textarea name="observacion" class="form-control"><?= old('observacion', $gasto->observacion) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <input type="text" name="metodo_pago" class="form-control" value="<?= old('metodo_pago', $gasto->metodo_pago) ?>" required>
            </div>

            <div class="mb-3">
                <label for="constancia" class="form-label">Constancia (Opcional)</label>
                <input type="file" name="constancia" class="form-control">
                <?php if ($gasto->constancia): ?>
                    <p>Imagen actual:</p>
                    <img src="<?= asset('storage/' . $gasto->constancia) ?>" alt="Constancia" width="100">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Gasto</button>
            <a href="<?= route('inicio') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
