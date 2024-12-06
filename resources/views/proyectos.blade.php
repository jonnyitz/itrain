<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONSTRUCTORA FDR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color:  #800080; /* Fondo azul morado */
        }
        .box-container {
            background-color: white; /* Fondo blanco */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra para el recuadro */
            margin: 20px auto;
            max-width: 800px; /* Ancho máximo del recuadro */
        }
        .top-left-image {
            position: absolute;
            top: 90px;
            left: 480px;
            width: 150px; /* Ancho de la imagen */
        }
        .project-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Espacio entre las tarjetas */
            justify-content: center;
        }
        .project-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            max-width: 300px; /* Mantén el ancho adecuado para las tarjetas */
            flex: 1 1 250px; /* Permite que las tarjetas se ajusten y se alineen */
        }
        .project-image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .progress {
            height: 30px; /* Altura de la barra de progreso */
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .logout-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            left: 290px; /* Ajusta la distancia desde la izquierda */
            top: 120px;
        }

        .logout-icon i {
            font-size: 24px;
            color: #007bff;
            cursor: pointer;
        }

        .logout-icon i:hover {
            color: #0056b3;
        }

        .logo-container img {
            height: 40px;
        }
    </style>
</head>
<body>
     <!-- Imagen en la parte superior izquierda -->
     <img src="{{ asset('images/logo.png') }}" alt="Logo" class="top-left-image">

        <!-- Contenedor del icono -->
        <div class="icon-container">
            <a href="{{ route('logout') }}" 
            class="logout-icon" 
            title="Cerrar sesión" 
            onclick="event.preventDefault(); var form = document.getElementById('logout-form'); if (form) form.submit();">
                <i class="fas fa-door-open"></i>
            </a>
        </div>

        <!-- Formulario de logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Contenedor principal -->
        <div class="box-container">
            <div class="container mt-5">
                <h1 class="text-center mb-4">CONSTRUCTORA FDR</h1>
                <h2 class="text-center mb-4">RFC: 0000111100</h2>
            </div>
        </div>

    <!-- Barra de filtro -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('proyectos.filtrar') }}" method="GET" class="form-inline justify-content-center">
                <input type="text" name="filtro" class="form-control mr-2" placeholder="Buscar por nombre o ubicación">
                <button type="submit" class="btn btn-primary mr-2">Buscar</button>
                <a href="{{ route('proyectos') }}" class="btn btn-secondary">Restablecer</a>
            </form>
        </div>
    </div>

    <div class="project-container">
        @foreach($proyectos as $proyecto)
            <div class="project-card">
                @if($proyecto->imagen)
                    <p><img src="{{ asset('storage/' . $proyecto->imagen) }}" alt="Imagen del proyecto" style="width: 200px;"></p>
                @endif
                <h3>{{ $proyecto->nombre }}</h3>
                <p>{{ $proyecto->ubicacion }}</p>
                <a href="{{ route('inicio', ['id' => $proyecto->id]) }}" class="btn btn-primary">
                    Ingresar <span class="ml-2">&rarr;</span>
                </a>
                <p><strong>Moneda:</strong> {{ $proyecto->moneda }}</p>
                <p><strong>Total de Lotes:</strong> {{ $proyecto->total_lotes }}</p>
                <p><strong>Lotes Disponibles:</strong> {{ $proyecto->lotes_disponibles }}</p>
                <p><strong>Estado:</strong> {{ $proyecto->estado }}</p>

                @php
                    // Calcular el total de lotes vendidos
                    $lotes_vendidos = $proyecto->total_lotes - $proyecto->lotes_disponibles;

                    // Verificar que total_lotes no sea cero para evitar división por cero
                    if ($proyecto->total_lotes > 0) {
                        // Calcular el porcentaje de progreso
                        $progreso = ($lotes_vendidos / $proyecto->total_lotes) * 100; 
                    } else {
                        $progreso = 0; // Si no hay lotes, el progreso es 0
                    }
                @endphp
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $progreso }}%;" aria-valuenow="{{ $progreso }}" aria-valuemin="0" aria-valuemax="100">{{ round($progreso) }}%</div>
                </div>
            </div>
        @endforeach
    </div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
