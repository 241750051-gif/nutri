<?php

namespace App\Services;

use App\Models\Cita;
use App\Models\Notificacion;

class CitaService
{
    public function crearCita(int $pacienteId, string $fechaHora, ?string $motivo = null): Cita
    {
        return Cita::create([
            'paciente_id' => $pacienteId,
            'fecha_hora'  => $fechaHora,
            'motivo'      => $motivo,
            'estado'      => 'pendiente',
        ]);
    }

    public function cambiarEstadoCita(Cita $cita, string $nuevoEstado): Cita
    {
        $cita->update(['estado' => $nuevoEstado]);

        Notificacion::create([
            'user_id' => $cita->paciente_id,
            'mensaje' => "El estado de su cita agendada para " . $cita->fecha_hora->format('d/m/Y H:i') . " ha sido actualizado a: " . strtoupper($nuevoEstado) . ".",
        ]);

        return $cita;
    }

    public function reprogramarCita(Cita $cita, string $nuevaFechaHora): Cita
    {
        $cita->update([
            'fecha_hora' => $nuevaFechaHora,
            'estado'     => 'reprogramada',
        ]);

        Notificacion::create([
            'user_id' => $cita->paciente_id,
            'mensaje' => "Su cita ha sido reprogramada para la fecha: " . $cita->fecha_hora->format('d/m/Y H:i') . ".",
        ]);

        return $cita;
    }
}