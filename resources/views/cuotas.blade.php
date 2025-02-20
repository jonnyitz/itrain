<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Cuotas</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
@if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

<div class="container mt-5">
    <h2 class="mb-4">Lista de Cobros</h2>
    <div class="mb-4">
        <input 
            type="text" 
            id="searchBar" 
            class="form-control" 
            placeholder="Buscar por contacto, lote o tipo..."
        >
    </div>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCuotaModal">Nuevo</button>
    
    <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>Lote/Manzana</th>
            <th>Comprobante</th>
            <th>N Cts</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>R.D</th>
            <th>Voucher</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cuotas as $index => $cuota)
            @foreach ($cuota->contacto->ventas as $venta)
                @if ($venta->modalidad_enganche == 2) <!-- Solo mostrar ventas a crédito -->
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $cuota->contacto->nombre }}</td>
                        <td>
                            @if($venta->lote)
                                <div>Lote: {{ $venta->lote->lote }}</div>
                                <div>Manzana: {{ $venta->lote->manzana ? $venta->lote->manzana->nombre : 'No disponible' }}</div>
                            @else
                                <div>No asignado</div>
                            @endif
                        </td>
                        <td>{{ $cuota->comprobante }}</td>
                        <td>{{ $cuota->n_cts }}</td>
                        <td>{{ $cuota->tipo }}</td>
                        <td>{{ $cuota->fecha }}</td>
                        <td>
                            <!-- Botón para PDF -->
                            <a href="{{ route('cuota.pdf', ['id' => $cuota->id]) }}" target="_blank">
                                <i class="fas fa-money-bill-wave"></i> <!-- Icono de cobro -->
                            </a>
                        </td>
                        <td>
                            <!-- Enlace para ver voucher -->
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#voucherModal" data-voucher="{{ asset($cuota->voucher) }}">
                                Ver Voucher
                            </a>
                        </td>
                        <td>
                            <!-- Aquí puedes agregar botones para editar o eliminar -->
                            <!-- Botón Editar -->
                            <button 
                                class="btn btn-primary btn-sm" 
                                data-toggle="modal" 
                                data-target="#editarClienteModal{{ $cuota->contacto->id }}" 
                                onclick="cargarDatosEditar({{ $cuota->contacto->id }}, '{{ $cuota->contacto->nombre }}', '{{ $cuota->contacto->apellidos }}', '{{ $cuota->contacto->curp_rfc }}', '{{ $cuota->contacto->telefono }}', '{{ $cuota->contacto->direccion }}', '{{ $cuota->contacto->observacion }}')"
                            >
                                Editar
                            </button>

                            <!-- Formulario Eliminar -->
                            <form 
                                action="{{ route('contactos.destroy', $cuota->contacto->id) }}" 
                                method="POST" 
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este contacto?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
    </table>
</div>

<!-- Modal para agregar una nueva cuota -->
<div class="modal fade" id="addCuotaModal" tabindex="-1" aria-labelledby="addCuotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('cuotas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCuotaModalLabel">Nueva Cuota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="tipo">Tipo Financiación</label>
                    <select class="form-control" id="tipo" name="tipo">
                        <option value="">Seleccionar...</option>
                        <option value="INICIAL">INICIAL</option>
                        <option value="PRINCIPAL">PRINCIPAL</option>
                        <option value="ADICIONAL">ADICIONAL</option>
                    </select>
                </div>
                    <div class="form-group">
                        <label for="contacto_search">Buscar Contacto:</label>
                        <input type="text" id="contacto_search" class="form-control" placeholder="Escribe el nombre del contacto...">
                        <input type="hidden" id="contacto_id" name="contacto_id">
                        <ul id="contacto_results" class="list-group mt-2 d-none"></ul>
                    </div>
                    <div id="venta_info" class="mt-3 d-none">
                        <h5>Detalles de Venta:</h5>
                        <p><strong>Lote:</strong> <span id="lote"></span></p>
                        <p><strong>Manzana:</strong> <span id="manzana"></span></p>
                        <p><strong>Precio Final:</strong><span id="precio_final"></span></p>
                    </div>
                    <div class="form-group">
                        <label for="banco_id">Banco/Caja Interna, Destino:</label>
                        <select name="banco_id" id="banco_id" class="form-control" required>
                            <option value="">Seleccione un banco</option>
                            @foreach ($bancos as $banco)
                                <option value="{{ $banco->id }}">
                                    {{ $banco->nombre_banco }} / {{ $banco->tipo_cuenta }} - {{ $banco->nombre_responsable }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comprobante">Comprobante</label>
                        <select name="comprobante" id="comprobante" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            <option value="RECIBO">RECIBO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="forma_de_pago">Forma de Pago</label>
                        <select class="form-control" id="forma_de_pago" name="forma_de_pago">
                            <option value="">Seleccionar...</option>
                            <option value="Deposito en Efectivo (Bancario)">Deposito en Efectivo (Bancario)</option>
                            <option value="Transferencia Bancaria">Transferencia Bancaria</option>
                            <option value="Pagon en Efectivo">Pago en Efectivo</option>
                            <option value="Tarjeta de Crédito">Tarjeta de Crédito</option>
                            <option value="Tarjeta de Débito">Tarjeta de Débito</option>
                            <option value="Pago con Cheque">Pago con Cheque</option>
                            <option value="Money Order">Money Order</option>
                            <option value="Paypal">Paypal</option>
                            <option value="Vale a la Vista">Vale a la Vista</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="n_cts">N°. Comprobante</label>
                        <input type="text" class="form-control" id="n_cts" name="n_cts" value="auto-generated-value" readonly>
                    </div>
                    <div class="form-group">
                        <label for="concep">Concepto</label>
                        <input type="text" id="concep" name="concep" class="form-control" value="{{ old('concep') }}">
                    </div>
                    <div class="form-group">
                        <label for="cuotas">Cuotas</label>
                        <input type="number" id="cuotas" name="cuotas" class="form-control" value="{{ old('cuotas') }}">
                    </div>
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                  
                    <div class="form-group">
                        <label for="voucher">Voucher</label>
                        <input type="file" class="form-control" id="voucher" name="voucher" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voucherModalLabel">Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="voucherImage" class="img-fluid" alt="Voucher">
            </div>
        </div>
    </div>
</div>


<!-- Enlace a jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#searchBar').on('keyup', function () {
            let value = $(this).val().toLowerCase(); // Captura el texto ingresado
            $('#cuotasTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1); // Filtra las filas
            });
        });
    });
</script>
<script>
  document.getElementById('contacto_search').addEventListener('input', function () {
    const query = this.value;
    const resultsList = document.getElementById('contacto_results');

    if (query.length < 2) {
        resultsList.classList.add('d-none');
        return;
    }

    fetch(`/buscar-contacto?q=${query}`)
        .then(response => response.json())
        .then(data => {
            resultsList.innerHTML = '';
            if (data.length > 0) {
                resultsList.classList.remove('d-none');
                data.forEach(contacto => {
                    const nombreCompleto = `${contacto.nombre || ''} ${contacto.apellidos || ''}`.trim();
                    const item = document.createElement('li');
                    item.textContent = nombreCompleto;
                    item.className = 'list-group-item list-group-item-action';
                    item.addEventListener('click', function () {
                        // Solo actualiza los campos relevantes al seleccionar un contacto
                        document.getElementById('contacto_search').value = nombreCompleto;
                        document.getElementById('contacto_id').value = contacto.id;

                        // Limpia los datos previos de la venta
                        document.getElementById('lote').textContent = '';
                        document.getElementById('manzana').textContent = '';
                        document.getElementById('precio_final').textContent = '';

                        // Verifica si tiene ventas
                        if (contacto.ventas && contacto.ventas.length > 0) {
                            const venta = contacto.ventas[0]; // Tomamos la primera venta
                            const lote = venta.lote ? venta.lote.lote : 'No disponible';  // Lote
                            const manzana = venta.lote && venta.lote.manzana ? venta.lote.manzana.nombre : 'No disponible'; // Manzana
                            const precioFinal = venta.precio_venta_final || 'No disponible'; // Precio final de la venta
                            
                            // Muestra el lote, manzana y precio final
                            document.getElementById('lote').textContent = lote;
                            document.getElementById('manzana').textContent = manzana;
                            document.getElementById('precio_final').textContent = `$${precioFinal}`;

                            // Muestra la información de la venta
                            document.getElementById('venta_info').classList.remove('d-none');
                        } else {
                            // Si no tiene venta, oculta la sección de venta
                            document.getElementById('venta_info').classList.add('d-none');
                        }

                        // Oculta los resultados de búsqueda
                        resultsList.classList.add('d-none');
                    });
                    resultsList.appendChild(item);
                });
            } else {
                resultsList.classList.add('d-none');
            }
        })
        .catch(error => console.error('Error al buscar contactos:', error));
});


</script>

<script>
    window.onload = function() {
        // Genera un número aleatorio entre 1000 y 9999 (puedes ajustar el rango si es necesario)
        let randomNumber = Math.floor(Math.random() * (9999 - 1000 + 1)) + 1000;

        // Asignar el número al campo
        document.getElementById('n_cts').value = randomNumber;
    };
</script>

<script>
    $('#voucherModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var imageUrl = button.data('voucher'); // Obtiene la URL de la imagen
        var modal = $(this);
        modal.find('#voucherImage').attr('src', imageUrl); // Asigna la URL de la imagen al modal
    });
</script>
</body>
</html>
