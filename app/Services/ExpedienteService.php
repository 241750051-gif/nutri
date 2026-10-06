<?php

namespace App\Services;

use App\Models\User;
use App\Models\Expediente;
use Illuminate\Support\Facades\Hash;

class ExpedienteService
{
    public function generarInformeTxt(User $paciente): string
    {
        $exp = $paciente->expediente;

        $contenido = "==================================================\n";
        $contenido .= "         EXPEDIENTE CLINICO NUTRICIONAL          \n";
        $contenido .= "==================================================\n\n";
        $contenido .= "Nombre del Paciente: " . $paciente->name . "\n";
        $contenido .= "Correo Electronico: " . $paciente->email . "\n";
        $contenido .= "Telefono: " . ($paciente->telefono ?? 'N/A') . "\n";
        $contenido .= "Direccion: " . ($paciente->direccion ?? 'N/A') . "\n";
        $contenido .= "--------------------------------------------------\n";
        $contenido .= "DATOS ANTROPOMETRICOS Y CLINICOS:\n";
        $contenido .= "Edad: " . ($exp->edad ?? 'N/A') . " anos\n";
        $contenido .= "Estatura: " . ($exp->estatura_cm ?? 'N/A') . " cm\n";
        $contenido .= "Peso: " . ($exp->peso_kg ?? 'N/A') . " kg\n";
        $contenido .= "Alergias: " . ($exp->alergias ?? 'Ninguna') . "\n";
        $contenido .= "Antecedentes: " . ($exp->antecedentes ?? 'Sin antecedentes registrados') . "\n";
        $contenido .= "--------------------------------------------------\n";
        $contenido .= "DIAGNOSTICO NUTRICIONAL:\n";
        $contenido .= ($exp->diagnostico ?? 'Sin diagnostico actual') . "\n\n";
        $contenido .= "PLAN ALIMENTICIO:\n";
        $contenido .= ($exp->plan_alimenticio ?? 'Sin plan asignado') . "\n\n";
        $contenido .= "OBSERVACIONES:\n";
        $contenido .= ($exp->observaciones ?? 'Sin observaciones') . "\n";
        $contenido .= "==================================================\n";

        return $contenido;
    }

    public function cargaMasivaPacientes(array $filas): int
    {
        $procesados = 0;
        foreach ($filas as $linea) {
            $datos = str_getcsv($linea);
            if (count($datos) >= 2) {
                $nombre = trim($datos[0]);
                $email = trim($datos[1]);
                $telefono = isset($datos[2]) ? trim($datos[2]) : null;

                if (!User::where('email', $email)->exists()) {
                    $usuario = User::create([
                        'name'     => $nombre,
                        'email'    => $email,
                        'password' => Hash::make('paciente123'),
                        'telefono' => $telefono,
                        'rol'      => 'paciente',
                        'activo'   => true,
                    ]);

                    Expediente::create(['user_id' => $usuario->id]);
                    $procesados++;
                }
            }
        }
        return $procesados;
    }
}