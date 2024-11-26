<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f8ff; /* Fondo azul claro */
        }
        .project-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            padding: 20px;
            text-align: center;
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
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Proyectos</h1>

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

    <div class="row">
        @foreach($proyectos as $proyecto)
            <div class="col-md-4">
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
            </div>
        @endforeach
    </div>
</div>

<!-- jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
