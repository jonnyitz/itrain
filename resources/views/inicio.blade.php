<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Cargar CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: black;
            height: 100vh;
            margin: 0;
        }
        .sidebar {
            height: 100%;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            background-color: black;
            padding-top: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            height: 100%;
        }
        .logout-button {
            position: absolute;
            bottom: 20px;
            left: 20px;
        }
        .nav-link {
            color: #007bff;
        }
        .nav-link:hover {
            color: #0056b3;
        }
        .tab {
            padding: 10px;
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
            position: relative;
            cursor: pointer;
        }
        .tab .close {
            position: absolute;
            top: 0;
            right: 5px;
            cursor: pointer;
            color: red;
        }
        .tab-content {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h3 class="text-center">Menú</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#" data-title="Inicio" data-content="Bienvenido a la Vista de Inicio">Inicio</a>
        </li>

        <!-- Seguridad Section -->
        <li class="nav-item">
            <a class="nav-link" href="#seguridadMenu" data-toggle="collapse" aria-expanded="false">Seguridad</a>
            <div class="collapse" id="seguridadMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                        
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Comercial Section -->
        <li class="nav-item">
            <a class="nav-link" href="#comercialMenu" data-toggle="collapse" aria-expanded="false">Comercial</a>
            <div class="collapse" id="comercialMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#" data-title="Contactos" data-url="{{ route('contactos') }}">Contactos</a>
                        <a class="nav-link tab-link" href="#" data-title="Ventas" data-url="{{ route('ventas') }}">Ventas</a>
                        <a class="nav-link tab-link" href="#" data-title="Creditos" data-url="{{ route('creditos') }}">Creditos</a>
                        <a class="nav-link tab-link" href="#" data-title="Cobros" data-url="{{ route('cuotas.index') }}">Cobros</a>
                        <a class="nav-link tab-link" href="#" data-title="Cotizaciones" data-url="{{ route('cotizaciones.index') }}">Cotizaciones</a>
                        <a class="nav-link tab-link" href="#" data-title="Reservas" data-url="{{ route('reservas') }}">Reservas</a>
                    </li>
                </ul>
            </div>
        </li>
        <!-- Logística Section -->
        <li class="nav-item">
            <a class="nav-link" href="#logisticaMenu" data-toggle="collapse" aria-expanded="false">Logística</a>
            <div class="collapse" id="logisticaMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#" data-title="Manzanas" data-url="{{ route('manzanas') }}">Manzanas</a>
                        <a class="nav-link tab-link" href="#" data-title="lotes" data-url="{{ route('lotes') }}">Lotes</a>
                    </li>
                </ul>
            </div>
        </li>

        

        <!-- Tesorería Section -->
        <li class="nav-item">
            <a class="nav-link" href="#tesoreriaMenu" data-toggle="collapse" aria-expanded="false">Tesorería</a>
            <div class="collapse" id="tesoreriaMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                    <a class="nav-link tab-link" href="#" data-title="Conceptos" data-url="{{ route('conceptos') }}">Conceptos</a>
                    <a class="nav-link tab-link" href="#" data-title="Gtos Proyecto" data-url="{{ route('gastos_proyecto.index') }}">Gtos Proyecto</a>
                    <a class="nav-link tab-link" href="#" data-title="Gtos Generales" data-url="{{ route('gastos_generales.index') }}">Gtos Generales</a>   
                    <a class="nav-link tab-link" href="#" data-title="recibos" data-url="{{ route('recibos') }}">Recibos</a>     
                </li>
                </ul>
            </div>
        </li>


        <!-- Proyectos Section for Administrators -->
        @if(auth()->user()->role === 'administrador')
            <li class="nav-item">
                <a class="nav-link" href="#proyectosMenu" data-toggle="collapse" aria-expanded="false">Ajustes</a>
                <div class="collapse" id="proyectosMenu">
                    <ul class="nav flex-column ml-3">
                        <!--<li class="nav-item"
                            <a class="nav-link" href="#addProjectModal" data-toggle="modal">
                                <i class="fas fa-plus"></i> Agregar Nuevo Proyecto
                            </a>>-->
                            <a class="nav-link tab-link" href="#" data-title="proyecto-ajustes" data-url="{{ route('proyecto-ajustes.index') }}">Proyectos</a>     
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>

    <!-- Logout Button -->
    <div class="logout-button">
        <form action="{{ route('logout') }}" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</div>

    <div class="content">
        <h1>Bienvenido a la Vista de Inicio</h1>
        <div id="tabs-container"></div>
        <div class="tab-content" id="tab-content">
            <!-- Contenido inicial -->
            <p>Selecciona una pestaña para ver su contenido aquí.</p>
        </div>

        <!-- Modal para agregar un nuevo proyecto -->
        <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProjectModalLabel">Agregar Nuevo Proyecto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('proyectos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre del Proyecto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                            <div class="form-group">
                                <label for="moneda">Moneda</label>
                                <input type="text" class="form-control" id="moneda" name="moneda" required>
                            </div>
                            <div class="form-group">
                                <label for="total_lotes">Total de Lotes</label>
                                <input type="number" class="form-control" id="total_lotes" name="total_lotes" required>
                            </div>
                            <div class="form-group">
                                <label for="lotes_disponibles">Lotes Disponibles</label>
                                <input type="number" class="form-control" id="lotes_disponibles" name="lotes_disponibles" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado" required>
                                    <option value="activo">EN VENTA</option>
                                    <option value="inactivo">VENDIDO</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen del Proyecto</label>
                                <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Proyecto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        
        // Manejo de clic en enlaces de pestañas
        $('.tab-link').click(function (e) {
            e.preventDefault();

            const title = $(this).data('title');
            const url = $(this).data('url');

            // Verificar si la pestaña ya existe
            let existingTab = $(`#tabs-container .tab[data-url="${url}"]`);
            if (existingTab.length > 0) {
                // Activar la pestaña existente
                activateTab(url);
                return;
            }

            // Crear y agregar nueva pestaña
            const newTab = $(`
                <div class="tab active" data-url="${url}">
                    ${title} <span class="close" title="Cerrar">&times;</span>
                </div>
            `);
            $('#tabs-container .tab').removeClass('active'); // Desactivar otras pestañas
            $('#tabs-container').append(newTab);

            // Activar la nueva pestaña y cargar su contenido
            activateTab(url);
        });

        // Manejo de cierre de pestañas
        $(document).on('click', '.close', function () {
            const tab = $(this).parent('.tab');
            const url = tab.data('url');

            // Eliminar la pestaña
            tab.remove();

            // Si no hay más pestañas, mostrar el mensaje predeterminado
            if ($('#tabs-container').children().length === 0) {
                $('#tab-content').html('<p>Selecciona una pestaña para ver su contenido aquí.</p>');
            } else {
                // Activar la última pestaña abierta
                const lastTabUrl = $('#tabs-container .tab').last().data('url');
                activateTab(lastTabUrl);
            }
        });

        // Función para activar una pestaña y cargar su contenido usando Fetch
        function activateTab(url) {
            // Quitar la clase activa de todas las pestañas
            $('#tabs-container .tab').removeClass('active');

            // Marcar la pestaña actual como activa
            const currentTab = $(`#tabs-container .tab[data-url="${url}"]`);
            if (currentTab.length > 0) {
                currentTab.addClass('active');
            }

            // Limpiar el contenido anterior
            const tabContent = $('#tab-content');
            tabContent.empty();

            // Cargar nuevo contenido usando Fetch
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al cargar el contenido');
                    }
                    return response.text();
                })
                .then(data => {
                    tabContent.html(data);
                })
                .catch(error => {
                    tabContent.html(`<p>${error.message}</p>`);
                });
        }
    });
</script>

</body>
</html>
