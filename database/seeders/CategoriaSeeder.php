<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Sin categoria', 'descripcion' => 'Transacciones sin categoria'],
            ['nombre' => 'Alquiler', 'descripcion' => 'ingresos de alquileres'],
            ['nombre' => 'Saldo', 'descripcion' => 'Saldo de alquileres, confecciones, etc'],
            ['nombre' => 'Comida', 'descripcion' => 'almuerzo del dia'],
            ['nombre' => 'Trasferencia', 'descripcion' => 'Transferencia de efectivo a Qr o viceversa'],
        ]);
    }
}
