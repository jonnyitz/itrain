<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Venta; // Asegúrate de tener el modelo de Venta

class PagosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos para banco_caja_interna
        $bancos = [
            'SANTANDER (ROBLES) - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'BBVA BANCOMER - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'BBVA BANAMEX - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'BANORTE - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'BANCOMER - CUENTA DE AHORROS - OSBALDO FERNANDEZ DEL REAL',
            'BANORTE-OSB - CUENTA DE AHORROS - OSBALDO FERNANDEZ DEL REAL',
            'SANTANDER (FRESNOS II) - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'BBVA BANCOMER (LOS SAUCE) - CUENTA DE AHORROS - HANSELL OMAR LOPEZ CAZARES',
            'CAJA OFICINA - CAJA INTERNA - HANSELL OMAR LOPEZ CAZARES'
        ];

        // Datos para forma_pago
        $formasPago = [
            'DEPOSITO EN EFECTIVO (BANCARIO)',
            'TRANSFERENCIA BANCARIA',
            'PAGO EN EFECTIVO',
            'TARJETA DE CRÉDITO',
            'TARJETA DE DÉBITO',
            'PAGO CON CHEQUE',
            'MONEY ORDER',
            'PAYPAL',
            'VALE A LA VISTA'
        ];

        // Asegurarse de que existe al menos una venta en la tabla ventas
        $venta = Venta::first(); // Obtiene la primera venta para utilizar su id

        if (!$venta) {
            // Si no hay ventas, puedes crear una nueva venta
            $venta = Venta::create([
                'contacto' => 'Cliente Ejemplo', // Cambia esto según tus necesidades
                'fecha_venta' => now()->toDateString(), // Usar la fecha actual
                'tipo_venta' => 'Tipo Ejemplo', // Cambia esto según tus necesidades
                'asesor' => 'Asesor Ejemplo', // Cambia esto según tus necesidades
                'numero_contrato' => 'CONTRATO123', // Cambia esto según tus necesidades
                'aval' => null, // O un valor válido
            ]);
        }

        // Insertar datos en la tabla pagos
        foreach ($bancos as $banco) {
            foreach ($formasPago as $forma) {
                DB::table('pagos')->insert([
                    'banco_caja_interna' => $banco,
                    'forma_pago' => $forma,
                    'venta_id' => $venta->id, // Usar el ID de la venta encontrada o creada
                    'comprobante' => 'N/A',
                    'numero_comprobante' => '0000',
                    'monto_primer_pago' => 0,
                    'fecha_hora_pago' => now(),
                    'codigo_operacion' => uniqid('op_'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
