<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta Finiquito de Compraventa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

         h2 {
            text-align: center;
            font-size: 8px;
        }
        h3 {
            text-align: center;
            font-size: 18px;
        }
        h4 {
            text-align: center;
            font-size: 16px;
        }
        p {
            font-size: 14px;
            line-height: 1.15;
            text-align: justify;
        }
        a {
            font-size: 14px;
            line-height: 1.6;
        }
        .signature-page-break {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        margin-top: 50px;
    }

        .signature-vendedor {
            display: inline-block;
            text-align: center;
        }

        

        .signature-vendedor a {
            display: block;
            margin-top: 10px;
            font-size: 14px;
        }
        .line {
            display: block;
            margin: 10px auto;
            border-top: 1px solid black;
            width: 100%;
        }
        .logo {
            width: 200px; /* Ajusta el tamaño de la imagen */
            display: inline-flex;
            margin: 20px auto; /* Agrega espacio arriba y abajo de la imagen */
            position: relative; /* Elimina el posicionamiento absoluto para que fluya con el documento */
            top: 0; /* Mantén la imagen en la parte superior */
            left: 50%; /* Centra la imagen horizontalmente */
            transform: translateX(-50%); /* Ajuste para centrar completamente */
            margin-right: 10px; /* Ajusta este valor si quieres más o menos espacio entre la imagen y el texto */
        }
        .p2 {
            flex-grow: 1; /* Hace que el texto ocupe todo el espacio restante */
            margin: 0; /* Elimina márgenes que puedan interferir */
            white-space: nowrap; /* Evita que el texto se divida en varias líneas */
            overflow: hidden; /* Asegura que el texto que no cabe en el espacio disponible no se desborde */
            text-overflow: ellipsis; /* Agrega "..." si el texto se corta */
            text-align: right;
            font-size: 14px;
        }
        .centrado {
        text-align: center;
        font-size: 14px;
        margin-top: 20px;
        }
        /* Salto de página antes de la firma del vendedor */
        table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 12px;
    }

    th, td {
    padding: 8px 12px;
    text-align: center;
    border: 1px solid #000000; /* Bordes negros */
    color: black; /* El texto en color negro */
    }

    th {
        background-color: #f2f2f2; /* Fondo gris claro para el encabezado */
        font-weight: bold;

    }

    tr:nth-child(even) {
        background-color: #ffffff; /* Fondo blanco para las filas pares */
    }

    tr:hover {
        background-color: #f9f9f9; /* Fondo más claro al pasar el ratón */
    }

    td {
        font-size: 12px;
    }

    .table-container {
        overflow-x: auto;
    }
      
    </style>
</head>
<body>
@if($venta->modalidad_enganche == 1 || $venta->contado)
    <div class="section">
        <div class="logo-container">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
            <h2>Callejón de Quijano N.236, Colonia Centro, Zacatecas, Zac., Tel: 492 161 6835</h2>
        </div>
        <h3 class="uppercase">CARTA FINIQUITO DE COMPRAVENTA</h3>
        <p class="p2">Zacatecas, Zacatecas, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
    </p>
        <p>A quien corresponda:</p>
        <p>Se hace constar que a la fecha {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}
        el <strong>C. {{ strtoupper($contacto->nombre) }} {{ strtoupper($contacto->apellidos) }}</strong>:</p>
        <p>Finiquita el <strong>{{ $venta->lote->lote }}</strong> de la <strong>{{ $venta->manzana->nombre }}</strong>, rústico y sin servicios que adquirió, por la cantidad total de <strong> ${{ number_format($venta->precio_venta_final, 2) }} ({{ strtoupper($numeroALetras) }} 00/100 M.N.)</strong>, el cual se encuentra ubicado en la parcela con número <strong>PARCELA {{ $proyecto->parcela }}</strong> del <strong>"FRACCIONAMIENTO LOS {{ $proyecto->nombre }}"</strong> en Ejido de la Escondida, Municipio y Estado de Zacatecas, quedando pendiente la aportación a los servicios de urbanización tal como lo marca la cláusula cuarta del contrato celebrado.</p>
        
        @php
            $cantidadLotes = $venta->contacto->ventas->count();
            $textoLotes = $cantidadLotes > 1 ? 'Los lotes mencionados' : 'El lote mencionado';
        @endphp

        <p>{{ $textoLotes }} cuenta{{ $cantidadLotes > 1 ? 'n' : '' }} con la siguiente orientación y medidas:</p>

        <!-- Campos para completar -->
        <div>
            <p><strong>{{ $venta->lote->lote }}</strong> de la <strong>{{ $venta->manzana->nombre }}</strong> </p>
            <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><strong>ORIENTACIÓN</strong></th>
                        <th><strong>MEDIDAS (MTS)</strong></th>
                        <th><strong>COLINDANCIAS</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AL NORESTE</td>
                        <td>{{ $venta->lote->medida_costado_derecho}}</td>
                        <td>{{ $venta->lote->colindancia_derecho }}</td>
                    </tr>
                    <tr>
                        <td>AL SURESTE</td>
                        <td>{{ $venta->lote->medida_frontal}}</td>
                        <td>{{ $venta->lote->colindancia_frontal }}</td>
                    </tr>
                    <tr>
                        <td>AL SUROESTE</td>
                        <td>{{ $venta->lote->medida_costado_izquierdo }}</td>
                        <td>{{ $venta->lote->colindancia_izquierdo }}</td>
                    </tr>
                    <tr>
                        <td>AL NOROESTE</td>
                        <td>{{ $venta->lote->medida_posterior}}</td>
                        <td>{{ $venta->lote->colindancia_posterior }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        </div>

        <p>El vendedor se obliga a enajenar al comprador una superficie total de <strong>{{$venta->lote->area}} metros cuadrados</strong> correspondiente al <strong>{{ $venta->lote->lote }} </strong> de la <strong>{{ $venta->manzana->nombre }}</strong> mismo que se recibe a entera satisfacción, haciéndose constar que a la fecha no se adeuda cantidad alguna por parte del comprador, por concepto de compraventa de terreno.</p>
        <p class="centrado">Se extiende la presente para los fines lícitos que al interesado convenga.</p>

        <div class="signature-page-break">
            <div class="signature-vendedor">
                <span class="line"></span>
                <a><strong>ING. {{ $proyecto->propietario }}</strong></a>
            </div>

            
        </div>
    </div>
    @endif

</body>
</html>
