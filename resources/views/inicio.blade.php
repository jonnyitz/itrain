<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
   
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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
            background-color: #572364;
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
            color:#ff5733;
        }
        .nav-link:hover {
            color: #yellow;
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
@if(session()->has('proyecto_id'))
    @php
        $proyecto = \App\Models\Proyecto::find(session('proyecto_id'));
    @endphp
    <div style="background-color: #007BFF; color: white; padding: 10px; text-align: center; font-size: 18px; font-weight: bold; border-radius: 5px;">
        <span>🌟 Estás trabajando en el proyecto: <strong>{{ $proyecto->nombre }}</strong></span>
    </div>
@endif

<div class="sidebar">
    <h3 class="text-center text-white">Menú</h3>
    <ul class="nav flex-column">
        <li class="nav-item">
        <a class="nav-link active" href="{{ route('proyectos') }}" data-title="Inicio" data-content="Bienvenido a la Vista de Proyectos">Inicio</a>
    </li>

        <!-- Seguridad Section -->
        @if(auth()->user()->role === 'administrador')
        <li class="nav-item">
            <a class="nav-link" href="#seguridadMenu" data-toggle="collapse" aria-expanded="false">Seguridad</a>
            <div class="collapse" id="seguridadMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                    <a class="nav-link tab-link" href="#" data-title="Grupos" data-url="{{ route('grupos') }}">Grupos</a>
                    <a class="nav-link tab-link" href="#" data-title="Accesos" data-url="{{ route('accesos') }}">Accesos</a>   
                    <a class="nav-link tab-link" href="#" data-title="Users" data-url="{{ route('users') }}">Usuarios</a>   
                </li>
                </ul>
            </div>
            @endif
        </li>
        
        <!-- Comercial Section -->
        @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'gerencia' || auth()->user()->role === 'ventas')
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
        @endif

        <!-- Logística Section -->
        @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'gerencia')
        <li class="nav-item">
            <a class="nav-link" href="#logisticaMenu" data-toggle="collapse" aria-expanded="false">Logística</a>
            <div class="collapse" id="logisticaMenu">
                <ul class="nav flex-column ml-3">
                    <li class="nav-item">
                        <a class="nav-link tab-link" href="#" data-title="Manzanas" data-url="{{ route('manzanas') }}">Manzanas</a>
                        <a class="nav-link tab-link" href="#" data-title="Lotes" data-url="{{ route('lotes') }}">Lotes</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif


        <!-- Tesorería Section -->
       @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'gerencia')
         <li class="nav-item">
                <a class="nav-link" href="#tesoreriaMenu" data-toggle="collapse" aria-expanded="false">Tesorería</a>
                <div class="collapse" id="tesoreriaMenu">
                    <ul class="nav flex-column ml-3">
                        <li class="nav-item">
                            <a class="nav-link tab-link" href="#" data-title="Conceptos" data-url="{{ route('conceptos') }}">Conceptos</a>
                            <a class="nav-link tab-link" href="#" data-title="Gtos Proyecto" data-url="{{ route('gastos_proyecto.index') }}">Gtos Proyecto</a>
                            <a class="nav-link tab-link" href="#" data-title="Gtos Generales" data-url="{{ route('gastos_generales.index') }}">Gtos Generales</a>   
                            <a class="nav-link tab-link" href="#" data-title="Recibos" data-url="{{ route('recibos') }}">Recibos</a>     
                        </li>
                    </ul>
                </div>
            </li>
        @endif
        
        <!-- Reportes Section -->
        @if(auth()->user()->role === 'administrador' || auth()->user()->role === 'gerencia')
            <li class="nav-item">
                <a class="nav-link" href="#Reportes" data-toggle="collapse" aria-expanded="false">Reportes</a>
                <div class="collapse" id="Reportes">
                    <ul class="nav flex-column ml-3">
                        <li class="nav-item">
                            <a class="nav-link tab-link" href="#" data-title="Reportes Ventas" data-url="{{ route('r.ventas') }}">Reportes Ventas</a>
                            <a class="nav-link tab-link" href="#" data-title="Reportes Financieros" data-url="{{ route('r.financieros') }}">Reportes Financieros</a>
                            <a class="nav-link tab-link" href="#" data-title="Reportes Lotes" data-url="{{ route('r.lotes') }}">Reportes Lotes</a>
                            <a class="nav-link tab-link" href="#" data-title="Reportes Clientes" data-url="{{ route('r.clientes') }}">Reportes Clientes</a>  
                        </li>
                    </ul>
                </div>
            </li>
        @endif



        <!-- Proyectos Section for Administrators -->
        @if(auth()->user()->role === 'administrador')
            <li class="nav-item">
                <a class="nav-link" href="#proyectosMenu" data-toggle="collapse" aria-expanded="false">Ajustes</a>
                <div class="collapse" id="proyectosMenu">
                    <ul class="nav flex-column ml-3">
                        <a class="nav-link tab-link" href="#" data-title="Proyectos" data-url="{{ route('proyecto-ajustes.index') }}">Proyectos</a>     
                        <a class="nav-link tab-link" href="#" data-title="Bancos" data-url="{{ route('bancos.index') }}">Bancos</a>     
                        <a class="nav-link tab-link" href="#" data-title="Sedes" data-url="{{ route('sedes.index') }}">Sedes</a>     
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
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen">
                        </div>
                        <div class="form-group">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="form-group">
                            <label for="cliente_id">Cliente</label>
                            <select class="form-control" id="cliente_id" name="cliente_id" required>
                                <!-- Opciones de clientes aquí -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Proyecto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    var $j = jQuery.noConflict(); // Activar noConflict para evitar problemas con otras librerías

    $j(document).ready(function () {
        console.log("Usando noConflict para evitar problemas.");

        // Manejo de clic en enlaces de pestañas
        $j('.tab-link').click(function (e) {
            e.preventDefault();

            const title = $j(this).data('title');
            const url = $j(this).data('url');

            let existingTab = $j(`#tabs-container .tab[data-url="${url}"]`);
            if (existingTab.length > 0) {
                activateTab(url);
                return;
            }

            const newTab = $j(`
                <div class="tab active" data-url="${url}">
                    ${title} <span class="close" title="Cerrar">&times;</span>
                </div>
            `);
            $j('#tabs-container .tab').removeClass('active');
            $j('#tabs-container').append(newTab);

            activateTab(url);
        });

        // Manejo de cierre de pestañas
        $j(document).on('click', '.close', function () {
            const tab = $j(this).parent('.tab');
            const isActive = tab.hasClass('active');
            tab.remove();

            if ($j('#tabs-container').children().length === 0) {
                $j('#tab-content').html('<p>Selecciona una pestaña para ver su contenido aquí.</p>');
            } else if (isActive) {
                const lastTabUrl = $j('#tabs-container .tab').last().data('url');
                activateTab(lastTabUrl);
            }
        });

        // Función para activar una pestaña
        function activateTab(url) {
            $j('#tabs-container .tab').removeClass('active');

            const currentTab = $j(`#tabs-container .tab[data-url="${url}"]`);
            if (currentTab.length > 0) {
                currentTab.addClass('active');
            }

            const tabContent = $j('#tab-content');
            tabContent.empty();

            // Cargar contenido dinámico y inicializar campos y plugins
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error al cargar contenido: ${response.statusText}`);
                    }
                    return response.text();
                })
                .then(data => {
                    tabContent.html(data);

                    // Inicializar valores en los campos dinámicos
                    initDynamicFields();

                    // Enlazar eventos dinámicos
                    bindDynamicEvents();
                })
                .catch(error => {
                    tabContent.html(`<p>Error: ${error.message}</p>`);
                    console.error("Error:", error);
                });
        }

        // Inicializar valores dinámicos en los campos del formulario
        function initDynamicFields() {
            console.log("Inicializando valores dinámicos en los campos.");
            const contractNumber = 'CONTRATO-' + Math.random().toString(36).substr(2, 6).toUpperCase();
            const operationCode = Math.floor(10000000 + Math.random() * 90000000); // 8 dígitos
            const comprobanteNumber = Math.floor(1000000000 + Math.random() * 9000000000); // 10 dígitos
            const n_ctsValue = Math.floor(1000000000 + Math.random() * 9000000000); // 10 dígitos

            const numeroContrato = document.getElementById('numero_contrato');
            const codigoOperacion = document.getElementById('codigo_operacion');
            const numeroComprobante = document.getElementById('numero_comprobante');
            const n_cts = document.getElementById('n_cts'); 

            if (numeroContrato) numeroContrato.value = contractNumber;
            if (codigoOperacion) codigoOperacion.value = operationCode;
            if (numeroComprobante) numeroComprobante.value = comprobanteNumber;
            if (n_cts) n_cts.value = n_ctsValue; 
        }

        // Enlazar eventos dinámicos
        function bindDynamicEvents() {
            console.log("Enlazando eventos dinámicos.");
            $j('#tab-content').on('change', '.auto-fill-input', function () {
                const value = $j(this).val();
                $j('#related-field').val(`Procesado: ${value}`);
            });
        }
        
    });
    
</script>


</body>
</html>
