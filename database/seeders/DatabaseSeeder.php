<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Expediente;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Creacion del Nutriologo Super Usuario (Docente)
        User::create([
            'name'     => 'Nutriologo Docente',
            'email'    => 'docente@clinica.com',
            'password' => Hash::make('docente123'),
            'telefono' => '5551234567',
            'direccion'=> 'Consultorio Principal #101',
            'rol'      => 'nutriologo',
            'activo'   => true,
        ]);

        // Creacion de 20 Pacientes
        for ($i = 1; $i <= 20; $i++) {
            $paciente = User::create([
                'name'     => "Paciente Ejemplo $i",
                'email'    => "paciente$i@correo.com",
                'password' => Hash::make('paciente123'),
                'telefono' => "55500000$i",
                'direccion'=> "Calle Falsa #$i",
                'rol'      => 'paciente',
                'activo'   => true,
            ]);

            Expediente::create([
                'user_id'         => $paciente->id,
                'edad'            => rand(18, 60),
                'estatura_cm'     => rand(150, 190),
                'peso_kg'         => rand(50, 100),
                'alergias'        => 'Ninguna declarada',
                'antecedentes'    => 'Sin antecedentes relevantes',
                'diagnostico'     => 'Evaluacion inicial completada',
                'plan_alimenticio'=> 'Dieta balanceada estandar',
                'observaciones'   => 'Paciente en buen estado general',
            ]);
        }
    }
}