<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .section { 
            margin-bottom: 20px; 
            text-align: center; /* Alinear texto a la derecha */
            font-size: 10px;
        }
        .right-align { 
            text-align: left; /* Alinear texto a la derecha */
            font-size: 14px;
            line-height: 1.0;
            text-align: justify; /* Justificar el texto en esta sección */

        }
        
        .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 14px; /* Ajustar el tamaño de la letra */
        }

        .table, th, td {
            border: 1px solid black; /* Líneas de borde negras */
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2; /* Color de fondo para las cabeceras */
            text-align: center; /* Justificar el texto en esta sección */
        }


        .uppercase { text-transform: uppercase; }
        .bold { font-weight: bold; }
        a {
            font-size: 10px;
            line-height: 1.6;
        }
        .signature-vendedor, .signature-comprador {
            display: inline-block;
            width: 45%;
            text-align: center;
            vertical-align: top;
            margin-top: 50px;
        }
        .signature-vendedor strong, .signature-comprador strong {
            display: block;
            margin-bottom: 10px;
        }
        .signature-vendedor p, .signature-comprador p {
            margin: 5px 0;
        }
        .line {
            display: block;
            margin: 10px auto;
            border-top: 1px solid black;
            width: 100%;
        }
        .p2 {
            font-size: 10px;
            line-height: 1.0;
        }
        .label {
        display: inline-block;
        width: 120px;       /* Ancho fijo para las etiquetas */
        font-weight: bold;  /* Negrita para las etiquetas */
        text-align: justify; /* Justificar el texto en esta sección */

        }
        .section p {
            margin: 5px 0;      /* Espaciado entre las líneas */
        }
        h3.uppercase {
        font-size: 14px; /* Tamaño de letra para el h3 */
        }
        h4.uppercase {
            font-size: 14px; /* Tamaño de letra para el h4 */
        }
        .logo-container {
        position: absolute;
        top: 10px; /* Ajusta según sea necesario */
        left: 10px; /* Ajusta según sea necesario */
        z-index: 10; /* Para asegurarse de que la imagen esté por encima de otros elementos */
        }

        .logo {
            width: 100px; /* Ajusta el tamaño de la imagen */
            height: auto; /* Mantiene la proporción de la imagen */
        }
        h4 {
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="logo-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
    </div>
    <div class="section">
        <h2>CONSTRUCTORA FDR</h2>
        <p class= p2>Callejón de Quijano #236, ZACATECAS</p2>
        <p class= p2>Teléfono: 492 161 6835</p2>
        <p class= p2>Email: constructora.fdr.cci@hotmail.com</p2>
    </div>

    <div class="section">
        <h3 class="uppercase"> LOS {{ $proyecto->nombre }}</h3>
        <h4 class="uppercase">COMPROBANTE DE PAGO</h4>
    </div>
    <div class="section right-align" style="text-align: justify;">
    <p><span class="label">Cliente:</span>{{ $venta->contacto->nombre }} {{ $venta->contacto->apellidos }}</p>
    <p><span class="label">CURP:</span>{{$venta->contacto->curp_rfc }}</p>
    <p><span class="label">Emisión:</span>{{ now()->format('d/m/Y H:i:s A') }}</p>
    <p><span class="label">Forma de Pago:</span>{{ $venta->forma_pago }}</p>
    <p><span class="label">Tipo Venta:</span>
    @if($venta->modalidad_enganche == 1)
        Contado
    @elseif($venta->modalidad_enganche == 2)
        Crédito
    @else
        No especificado
    @endif
</p>
</div>

<table class="table">
    <thead>
        <tr>
            <th>CONCEPTO</th>
            <th>MONTO</th>
        </tr>
    </thead>
    <tbody>
    <tr>
    <td>
    @if($venta->contacto->ventas->isNotEmpty())
        @php
            $ventaItem = $venta->contacto->ventas->first(); // Obtener solo la primera venta
        @endphp

        @if($ventaItem->lote)
            <span style="text-decoration: underline;">
            {{ $ventaItem->lote->lote ? $ventaItem->lote->lote : 'No disponible' }} - 
            {{ $ventaItem->lote->manzana ? $ventaItem->lote->manzana->nombre : 'No disponible' }} 
                @if($ventaItem->lote->area)
                    (<strong>{{ number_format($ventaItem->lote->area, 2) }} m²</strong>)
                @else
                    (<strong>Área no disponible</strong>)
                @endif
            </span>
        @else
            <span>No asignado</span>
        @endif
    @endif
</td>
    <td>$ {{ number_format($venta->precio_venta_final, 2) }}</td> <!-- Agregar coma como separador de miles -->
</tr>
<tr>
<strong style="text-align: right; display: block;">TOTAL</strong>
<td>$ {{ number_format($venta->precio_venta_final, 2) }}</td> <!-- Agregar coma como separador de miles -->
</tr>
    </tbody>
</table>

    <div class="section right-align">
        <p class="uppercase">
            SON: 
            {{ strtoupper($numeroALetras) }} PESOS 00/100 M.N.
        </p>
    </div>

    <!-- Salto de página antes de las firmas -->
    <div class="signature-page-break">
        <div class="signature-vendedor">
        <h4><strong>“RECIBE”</strong></h4> 
            <br><br> 
            <span class="line"></span>
            <a><strong>ING. {{ $proyecto->propietario }}</strong></a>
        </div>

        <div class="signature-comprador">
        <h4><strong>“ENTREGA”</strong></h4> 
            <br><br> 
            <span class="line"></span>
            <a><strong>C. {{ $venta->contacto->nombre }} {{$venta->contacto->apellidos}} </strong></a>
        </div>
    </div>

</body>
</html>
