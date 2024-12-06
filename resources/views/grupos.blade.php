<?php
// Vista en PHP
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos Inmobiliarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Grupos Inmobiliarios</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form class="d-flex" action="<?= url('/grupos') ?>" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar por descripción o empresa" value="<?= htmlspecialchars(request('search', '')) ?>">
                <button class="btn btn-outline-primary" type="submit">Buscar</button>
            </form>
            <div>
                <a href="<?= url('/grupos/export') ?>" class="btn btn-success">Exportar a Excel</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoGrupoModal">Nuevo</button>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción del Grupo</th>
                    <th>Empresa Inmobiliaria</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grupos as $key => $grupo): ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= htmlspecialchars($grupo['descripcion']) ?></td>
                        <td><?= htmlspecialchars($grupo['empresa']['nombre']) ?></td> <!-- Mostrar solo el nombre -->
                        <td>
                            <button class="btn btn-warning btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para nuevo grupo -->
    <div class="modal fade" id="nuevoGrupoModal" tabindex="-1" aria-labelledby="nuevoGrupoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoGrupoModalLabel">Nuevo Grupo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('grupos.store') }}" method="POST">
                @csrf
                        <div class="mb-3">
                            <label for="empresa" class="form-label">Empresa Inmobiliaria</label>
                            <select name="empresa" id="empresa" class="form-select">
                                <option value="Constructora FDR" selected>Constructora FDR</option>
                                <option value="Otra Empresa">Otra Empresa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del Grupo</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
