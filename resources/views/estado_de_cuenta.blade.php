<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; text-align: center; }
        h2, h3 { color: #00000F; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        
        .p2 {
            font-size: 8px;
            line-height: 1.0;
        }

        /* Estilo para centrar la información de la empresa */
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-info p {
            margin: 5px 0;
        }

        .h2{
            font-size: 20px; /* Tamaño de letra para el h3 */
            line-height: 1.5;
        }

        .logo-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }

        .logo {
            width: 100px;
            height: auto;
        }
        .p{
            font-size: 14px;
            line-height: 1.0;
            text-align: left;
        }
    </style>    
</head>
<body>
    <!-- Logo de la empresa -->
    <div class="logo-container">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
    </div>

    <!-- Información de la empresa centrada -->
    <div class="company-info">
        <h2>CONSTRUCTORA FDR</h2>
        <p class="p2">Callejón de Quijano #236, ZACATECAS</p>
        <p class="p2">Teléfono: 492 161 6835</p>
        <p class="p2">Email: constructora.fdr.cci@hotmail.com</p>
    </div>
    <div class="section">
        <h2 class="h2"><strong>LOS SAUCES</strong></h>
    </div>
   

    <p class="p"><strong>Cliente:</strong> {{ $venta->contacto->nombre }} {{ $venta->contacto->apellidos }} | 
        <strong>CURP:</strong> {{ $venta->contacto->curp_rfc }}</p>
    <p class="p"><strong>Manzana/Lote:</strong>  {{ $venta->lote->manzana ? $venta->lote->manzana->nombre : 'No disponible' }} - 
        {{ $venta->lote->lote }} </p>    
    <p class="p"><strong>Pagado:</strong> ${{ number_format($venta->enganche, 2) }} | 
        <strong>Total Enganche:</strong> ${{ number_format($venta->enganche, 2) }}</p>
    <p class="p"><strong>Total Crédito:</strong> ${{ number_format($venta->precio_venta_final - $venta->enganche, 2) }} | 
        <strong>Total Venta:</strong> ${{ number_format($venta->precio_venta_final, 2) }}</p>
    
    <h3>Pagos Realizados - Enganche</h3>
    <table border="1" cellspacing="0" cellpadding="5" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align: center; border: 1px solid black;">Nº</th>
                <th style="text-align: center; border: 1px solid black;">Fecha y Hora</th>
                <th style="text-align: center; border: 1px solid black;">Monto Recibido</th>
                <th style="text-align: center; border: 1px solid black;">Eqv. Cuotas</th>
                <th style="text-align: center; border: 1px solid black;">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @if($cuotas->isNotEmpty()) 
                @php
                    $cuota = $cuotas->first(); // Solo tomamos la primera cuota
                @endphp
                <tr>
                    <td style="text-align: center; border: 1px solid black;">1</td>
                    <td style="text-align: center; border: 1px solid black;">{{ \Carbon\Carbon::parse($cuota->fecha)->format('d/m/Y h:i A') }}</td>
                    <td style="text-align: center; border: 1px solid black;">${{ number_format($venta->enganche, 2) }}</td>
                    <td style="text-align: center;">{{ intval($cuota->cuotas) }}</td>
                    <td style="text-align: center; border: 1px solid black;">$0.00</td> <!-- Siempre saldo en 0 -->
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr style="background-color: #b5bac9; color: #00000F; font-weight: bold; border: 1px solid black;"> <!-- Fondo gris azulado -->
                <td colspan="2" style="text-align: center; border: 1px solid black;">Subtotal</td>
                <td style="text-align: center; border: 1px solid black;">${{ number_format($venta->enganche, 2) }}</td>
                <td style="text-align: center; border: 1px solid black;">1</td>
                <td style="text-align: center; border: 1px solid black;"></td> <!-- Celda con borde para alineación -->
            </tr>
        </tfoot>
    </table>

    <h3>Pagos Realizados - Total Venta</h3>
    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha y Hora</th>
                <th>Monto Recibido</th>
                <th>Eqv. Cuotas</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $saldoRestante = $venta->precio_venta_final - $venta->enganche; // Inicializa el saldo con el Total Crédito
                $totalMonto = 0;
                $totalCuotas = 0;
            @endphp

            @foreach($cuotas as $index => $cuota)
                @php
                    $totalMonto += $cuota->monto;
                    $totalCuotas += $cuota->cuotas;
                    $saldoRestante -= $cuota->monto; // Resta el monto antes de mostrar el saldo
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($cuota->fecha)->format('d/m/Y h:i A') }}</td>
                    <td>${{ number_format($cuota->monto, 2) }}</td>
                    <td style="text-align: center;">{{ intval($cuota->cuotas) }}</td>
                    <td>${{ number_format($saldoRestante, 2) }}</td> <!-- Muestra el saldo actualizado -->
                </tr>
            @endforeach

            <!-- Fila de subtotal -->
            <tr style="background-color: #b5bac9; color: #00000F; font-weight: bold;">
                <td colspan="2" style="text-align: center;">Subtotal</td>
                <td>${{ number_format($totalMonto, 2) }}</td>
                <td style="text-align: center;">{{ $totalCuotas }}</td>
                <td style="border: 1px solid black;"></td> <!-- Celda vacía para evitar desalineación -->
            </tr>
        </tbody>
    </table>

    <!-- Total General -->
    @php
        $totalGeneralMonto = $venta->enganche + $totalMonto;
        $totalGeneralCuotas = 1 + $totalCuotas;
    @endphp

    <h3>Total General</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr style="background-color: #b5bac9; color: #00000F; font-weight: bold;">
                <td colspan="2" style="text-align: center; border: 1px solid black; padding: 8px; width: 40%;">Total General</td>
                <td style="text-align: center; border: 1px solid black; padding: 8px; width: 20%;">${{ number_format($totalGeneralMonto, 2) }}</td>
                <td style="text-align: center; border: 1px solid black; padding: 8px; width: 20%;">{{ $totalGeneralCuotas }}</td>
                <td style="text-align: center; border: 1px solid black; padding: 8px; width: 20%;">${{ number_format($saldoRestante, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
