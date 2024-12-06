<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilo para la imagen de fondo */
        body, html {
            height: 100%; /* Asegura que el body y html ocupen toda la altura */
            margin: 0; /* Elimina el margen por defecto */
            background: url('/images/fondo.jpg') no-repeat center center fixed; /* Imagen de fondo centrada y fija */
            background-size: cover; /* Asegura que la imagen cubra todo el fondo */
        }
        /* Estilo para centrar el contenido */
        .content-container {
            position: flex; /* Cambia a posición absoluta */
            top: 20px; /* Posiciona el contenedor desde el borde superior */
            right: 20px; /* Posiciona el contenedor desde el borde derecho */
            text-align: center; /* Alinea el texto a la derecha */
            z-index: 10; /* Asegura que el contenido esté sobre el fondo */
        }
        /* Estilo para el video */
        .video-container {
            position: absolute; /* Posiciona el video de forma absoluta */
            bottom: 20px; /* Distancia del fondo */
            left: 20px; /* Distancia del lado izquierdo */
            width: 60%; /* El video ocupará el 60% del ancho */
            max-width: 500px; /* Ancho máximo del video */
            z-index: 10; /* Asegura que el video esté sobre el fondo */
        }
        video {
            width: 100%; /* El video ocupa el 100% del contenedor */
            height: auto; /* Mantiene la proporción */
        }
        /* Fondo blanco para los modales */
        .modal-content {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco con opacidad */
        }
        /* Estilos para el texto */
        .text-white {
            color: white; /* Color blanco para el texto */
        }
        .input-group-append .input-group-text {
            cursor: pointer; /* Cambia el cursor al pasar sobre el ícono */
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2 class="text-white">Bienvenido</h2>
        <p class="text-white">Seleccione una opción para continuar</p>
        <!-- Botones para abrir los modales -->
        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#loginModal">
            Ingresar
        </button>
       <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#registerModal">
            Registrar
        </button>
    </div>-->

    <!-- Video -->
    <div class="video-container mb-4">
        <video controls autoplay muted>
            <source src="/videos/Nogales.mp4" type="video/mp4">
            Tu navegador no soporta la etiqueta de video.
        </video>
    </div>
    
    <!-- Modal para Ingresar -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Ingresar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePasswordLogin"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recuérdame</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Registrar -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registrar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_register" name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePasswordRegister"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePasswordConfirm"><i class="fas fa-eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap y jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función para mostrar y ocultar la contraseña
        $(document).ready(function() {
            $('#togglePasswordLogin').click(function() {
                const passwordField = $('#password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            $('#togglePasswordRegister').click(function() {
                const passwordField = $('#password_register');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            $('#togglePasswordConfirm').click(function() {
                const passwordField = $('#password_confirmation');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });
        });
    </script>
</body>
</html>
