<?php

namespace Database\Seeders;

use App\Models\Telefono;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $telefono_id = DB::table('telefonos')->insertGetId( [
            'numero' => '+59170015157'
        ]); 
        $persona_id =  DB::table('personas')->insertGetId([
                'nombre' => 'Armando', 
                'apellido' => 'Paredes',
                'carnet' => '7859806',
                'telefono_id' => $telefono_id, 
                // 'password' => bcrypt('123'),
        ]);
        DB::table('usuarios')->insert([
            'username' => 'admin',
            'password' => bcrypt('123'),
            'persona_id' => $persona_id
        ]);
    }
}
