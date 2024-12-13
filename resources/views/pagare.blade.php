<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Pagaré</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
            margin-bottom: 20px;
            padding: 10px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #000;
        }
        .pagaré {
            margin-bottom: 40px;
        }
        .pagaré td {
            text-align: left;
            vertical-align: top;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
        }
        .firma {
            margin-top: 50px;
            text-align: center;
        }
        .logo {
            width: 150px; /* Ajusta el tamaño de la imagen */
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>

        <!-- Generar 24 Pagarés -->
        @for ($i = 1; $i <= 24; $i++)
            @php
                $fechaVencimiento = \Carbon\Carbon::parse($venta->fecha_venta)->addMonths($i);
            @endphp

            <!-- Pagaré 1 de 24, Pagaré 2 de 24, etc. -->
            <div class="pagaré">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
            <table>
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align: center;">Pagaré {{ $i }} de 24</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td>{{ $contacto->nombre }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Venta:</strong></td>
                            <td>{{ $venta->fecha_venta }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Vencimiento:</strong></td>
                            <td>{{ $fechaVencimiento->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Monto:</strong></td>
                            <td>${{ number_format($venta->enganche, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Contrato N°:</strong></td>
                            <td>{{ $venta->numero_contrato }}</td>
                        </tr>
                        <tr>
                            <td><strong>Asesor:</strong></td>
                            <td>{{ $venta->asesor }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height: 50px;">Firma del Cliente: _________________________________</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endfor

        <!-- Footer -->
        <div class="footer">
            <p>Fecha de Emisión: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
