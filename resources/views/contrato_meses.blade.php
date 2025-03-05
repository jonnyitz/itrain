@php
    use Illuminate\Support\Str;

    $primer_nombre = strtoupper(explode(' ', trim($contacto->nombre))[0]);
    $primer_apellido = strtoupper(explode(' ', trim($contacto->apellidos))[0]);

    // Asumimos que si el primer nombre o apellido termina con una vocal comúnmente asociada con género femenino, es femenino.
    $es_femenino = in_array(substr($primer_nombre, -1), ['A', 'E', 'I', 'O', 'U']) || in_array(substr($primer_apellido, -1), ['A', 'E', 'I', 'O', 'U']);
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato Privado de Compra-Venta</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

        
        h1, h2 {
            text-align: center;
            font-size: 18px;
        }
        h3 {
            text-align: left;
            font-size: 16px;
        }
        h4 {
            text-align: center;
            font-size: 14px;
        }
        p {
            font-size: 12px;
            line-height: 1.15;
            text-align: justify;
        }
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
            text-align: center;
            font-size: 8px;
        }
        /* Salto de página antes de la firma del vendedor */
        .signature-vendedor {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Verifica si la modalidad de enganche es igual a 2 o si existe el campo 'credito' -->
    @if($venta->modalidad_enganche == 2 || $venta->credito)
    <div class="logo-container">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" class="logo">
    <p class="p2">Callejón de Quijano N. 236, Colonia Centro, Zacatecas, Zac., Tel: 492 161 6835</p>
</div>

        <h1>CONTRATO PRIVADO DE COMPRA-VENTA</h1>
        <p>
        QUE CELEBRAN POR UNA PARTE EL  <strong>ING. {{ $proyecto->propietario }}</strong> , A QUIEN EN LO SUCESIVO SE LE DENOMINARÁ <strong>“EL VENDEDOR”</strong> Y, POR OTRA PARTE, <strong>{{ $es_femenino ? 'LA C.' : 'EL C.' }} {{ strtoupper($contacto->nombre) }} {{ strtoupper($contacto->apellidos) }}</strong>, QUE EN ADELANTE SE LE DENOMINARÁ <strong>“EL COMPRADOR”</strong>, AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS:
    </p>

    <h2>D E C L A R A C I O N E S</h2>
    <h3>DECLARA “EL VENDEDOR”:</h3>
    <p>
    <strong> PRIMERA.- </strong>Ser de nacionalidad mexicana, mayor de edad, originario de Zacatecas, Zac.
    </p>
    <p>
    <strong> SEGUNDA.- </strong> Que tiene la capacidad para la venta del siguiente bien inmueble: <strong>{{ $venta->lote->lote }}</strong> de la <strong>{{ $venta->manzana->nombre }}</strong>, con una superficie de <strong>105</strong> metros cuadrados, del fraccionamiento <strong>“LOS {{ $proyecto->nombre }}”</strong>, rústico y sin servicios ubicado en Ejido de la Escondida, Zacatecas, Zac., dentro de un polígono ubicado en la <strong>PARCELA {{ $proyecto->parcela }}.</strong>
    </p>
    <p>
    <strong> TERCERA.- </strong>Que el inmueble descrito en la declaración anterior no lo tiene enajenado ni en promesa de compra-venta y se le adjudicará al comprador.
    </p>
    <p>
    <strong> CUARTA.- </strong> Que se compromete a dar seguimiento y apoyo en la conformación de la asociación de colonos y la urbanización.
    </p>
    <p>
    <strong> QUINTA.- </strong> Que tiene todos los papeles de dichos lotes en regla para la venta de los mismos y que, al finiquitar el lote, se le hará entrega al comprador de carta finiquito y se iniciará el proceso de escrituración en la Notaría correspondiente, cumpliendo con todos los requisitos que marca el <strong>Código Urbano del Estado de Zacatecas.</strong>
    </p>

    <h3>DECLARA “EL COMPRADOR”:</h3>
    <p>
    <strong>SEXTA.- </strong> Ser de nacionalidad mexicana, con domicilio en <strong>{{ $contacto->direccion }}, {{ $contacto->codigo_postal }}</strong>, con número de teléfono <strong>{{ $contacto->telefono }}</strong> y tener la capacidad legal para contratar y obligarse en los términos y condiciones respecto del clausulado del presente instrumento.
    </p>
    <p>
    <strong>SÉPTIMA.- </strong> Que conoce y desea adquirir el inmueble materia del presente contrato, tanto en superficie como en ubicación.
    </p>

    <h2>C L Á U S U L A S</h2>
    <p>
    <strong>PRIMERA.- </strong> <strong>“EL VENDEDOR”</strong> se compromete a vender a <strong>“EL COMPRADOR”</strong>, el bien inmueble descrito en la segunda de las declaraciones y cuyas características y datos de identificación se tiene aquí por reproducidos para todos los efectos legales a que haya lugar.
    </p>
    <p>
    <strong>SEGUNDA.- </strong> <strong>“EL COMPRADOR”</strong> está de acuerdo con el precio del lote mencionado, que es de <strong>${{ number_format($venta->precio_venta_final, 2) }} ({{ strtoupper( $precioEnLetras) }} PESOS 00/100 M.N.) </strong> de crédito.
    </p>
    <p>
    <strong>TERCERA.- </strong>En este acto se le reconoce a  <strong>“EL COMPRADOR”</strong> la cantidad de <strong>${{ number_format($venta->enganche, 2) }} ({{ strtoupper($engancheEnLetras ) }} PESOS 00/100 M.N.)</strong> por concepto de <strong>Enganche</strong>, quedando un saldo total de 
    <strong>
    <?php
    require_once base_path('vendor/autoload.php');  // Usar base_path() para evitar problemas de rutas
    
    $montoRestante = $venta->precio_venta_final - $venta->enganche;
    $numero = number_format($montoRestante, 2, '.', '');
    
    // Convertir el número a letras en español
    $numeroEnLetras = (new \Numbers_Words())->toWords($numero, 'es');  // 'es' para español
    
    // Mostrar el monto en número y luego la cantidad en letras
    echo "$" . number_format($montoRestante, 2) . " (" . strtoupper($numeroEnLetras) . " PESOS 00/100 M.N)";
?>


    <p>
        <strong>CUARTA.- </strong> El tiempo para pagar el total del lote mencionado es de {{$venta->meses}} meses máximo a partir de la fecha de firma de este contrato, quedando a pagar la cantidad mensual de <strong>{{ number_format($venta->monto_primer_pago, 2) }} ({{ strtoupper($montoEnLetras ) }}  PESOS 00/100 M.N.)</strong>
        , con pagos el día {{$venta->meses}} de cada mes, iniciando el {{ \Carbon\Carbon::parse($venta->fecha_hora_pago)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}. En caso de retraso se cobrará un interés del 5% por día sobre el monto de la mensualidad.
    </p>

    <p>
    <strong> QUINTA.- </strong> La falta de pago de tres mensualidades consecutivas dejará inexistente este contrato. Las partes contratantes acuerdan que, para la rescisión del presente contrato, bastará un simple comunicado dirigido a <strong>“EL COMPRADOR”</strong> en el que se señale y justifique la causal de incumplimiento.
    </p>

    <p>
    <strong> SEXTA.- </strong> Se conformará la Asociación Civil de colonos ante el notario al término del pago de todos los compradores, aportando cada uno de los colonos la cantidad que corresponda.
    </p>
    <p>
    <strong>SÉPTIMA.- </strong> <strong>“EL COMPRADOR”</strong>, llegado el momento, se hará responsable de la aportación correspondiente para servicios de urbanización, contando con el apoyo de <strong>“EL VENDEDOR”</strong> en cuanto a tramitación de los mismos.
    </p>
    <p>
    <strong>OCTAVA.- </strong> En la celebración del presente contrato no existe dolo, error, mala fe, o cualquier otro vicio del consentimiento que pudiese afectar la eficacia del presente contrato.
    </p>
    <p>
    <strong>NOVENA.- </strong>Para todo lo relacionado con la interpretación y cumplimiento del presente contrato las partes se someten a las leyes y tribunales de la ciudad de Zacatecas, renunciando a cualquier otro fuero que ahora o en lo futuro les pudiere corresponder.
    </p>
    <p>
    <strong>DÉCIMA.- </strong> En caso de rescisión de contrato por parte de <strong>“EL VENDEDOR”</strong> los pagos aportados serán entregados de la misma forma y plazo en que <strong>“EL COMPRADOR”</strong> los realizó. Si el contrato es rescindido por parte de “EL COMPRADOR” solo se le reembolsará el 20% de lo aportado, quedando ambas partes en común acuerdo.
    </p>
    <p>
    <strong>Ambas partes convienen que en el caso de que alguna de ellas incumpliera el contrato en alguna de sus cláusulas, estará obligado a indemnizar a la otra por los daños y perjuicios causados, o bien su cumplimiento de contrato.</strong>
    </p>

    <p>
    <?php
        // Establecer el idioma para las fechas
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252'); 

        // Formatear y mostrar la fecha
        echo "Leído que fue el presente contrato por las partes contratantes y enteradas de su contenido y alcance legal, lo firman por duplicado en todas y cada una de sus hojas, en la Ciudad de Zacatecas, Zacatecas, a los " . strftime('%d días del mes de %B del año %Y') . ".";
    ?>
    </p>
<br>
<br>
<br><br><br>

        <!-- Continúa con el contrato -->

      <!-- Salto de página antes de las firmas -->
<div class="signature-page-break">
    <div class="signature-vendedor">
    <h4><strong>“EL VENDEDOR”</strong></h4>
        <br><br> 
        <span class="line"></span>
        <a><strong>ING. {{ $proyecto->propietario }}</strong></a>
    </div>

    <div class="signature-comprador">
        <h4><strong>“EL COMPRADOR”</strong></h4>
        <br><br> 
        <span class="line"></span>
        <a><strong>C. {{ $contacto->nombre }} {{$contacto->apellidos}} </strong></a>
    </div>
    @endif
</body>
</html>
