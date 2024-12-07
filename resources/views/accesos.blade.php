<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accesos</title>
    <!-- Vincular el CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Accesos</h1>
         <!-- Select Empresa -->
         <div class="mb-3">
            <label for="empresa" class="form-label">Seleccionar Empresa</label>
            <select id="empresa" class="form-select">
                <option value="">Seleccione una empresa</option>
                @foreach($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Grupo -->
        <div class="mb-3">
            <label for="grupo" class="form-label">Seleccionar Grupo</label>
            <select id="grupo" class="form-select">
                <option value="">Seleccione un grupo</option>
                @foreach($grupos as $grupo)
                    <option value="{{ $grupo->id }}" data-empresa-id="{{ $grupo->empresa_id }}">
                        {{ $grupo->descripcion }}
                    </option>
                @endforeach
            </select>
        </div>

        <button id="mostrarAccesos" class="btn btn-primary">Mostrar Accesos</button>

        <!-- Contenedor para mostrar los accesos y proyectos -->
        <div id="accesos" class="mt-4" style="display:none;">
            <h3>Accesos</h3>
            <div class="row">
                <!-- Columna de Accesos -->
                <div class="col-md-6">
                    <h4>Permisos</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso1">
                        <label class="form-check-label" for="acceso1">iTrade</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso2">
                        <label class="form-check-label" for="acceso2">Seguridad</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso3">
                        <label class="form-check-label" for="acceso3">G. Comercial</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso4">
                        <label class="form-check-label" for="acceso4">Logística</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso5">
                        <label class="form-check-label" for="acceso5">Tesorería</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso6">
                        <label class="form-check-label" for="acceso6">Ajustes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso7">
                        <label class="form-check-label" for="acceso7">Reportes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso8">
                        <label class="form-check-label" for="acceso8">Servicios</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="acceso9">
                        <label class="form-check-label" for="acceso9">Proyectos</label>
                    </div>
                </div>

                <!-- Columna de Proyectos -->
                <div class="col-md-6">
                    <h4>Proyectos</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto1">
                        <label class="form-check-label" for="proyecto1">LOS ROBLES</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto2">
                        <label class="form-check-label" for="proyecto2">LOS FRESNOS</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto3">
                        <label class="form-check-label" for="proyecto3">REAL DEL BOSQUE</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto4">
                        <label class="form-check-label" for="proyecto4">ARAGON</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto5">
                        <label class="form-check-label" for="proyecto5">ARBOLES DEL PARAISO</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto6">
                        <label class="form-check-label" for="proyecto6">LLANOS SANTOS II</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto7">
                        <label class="form-check-label" for="proyecto7">AGAVES</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto8">
                        <label class="form-check-label" for="proyecto8">FRESNOS II</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto9">
                        <label class="form-check-label" for="proyecto9">LOS NOGALES</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto10">
                        <label class="form-check-label" for="proyecto10">LOS SAUCES</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="proyecto11">
                        <label class="form-check-label" for="proyecto11">CONSTRUCCIONES DE VIVIENDA</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vincular el JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('mostrarAccesos').addEventListener('click', function() {
            var empresaId = document.getElementById('empresa').value;
            var grupoId = document.getElementById('grupo').value;

            if (empresaId && grupoId) {
                // Mostrar la sección de accesos y proyectos
                document.getElementById('accesos').style.display = 'block';
            } else {
                alert('Por favor, seleccione tanto la empresa como el grupo.');
            }
        });
    </script>
</body>
</html>
