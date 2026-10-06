<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Services\CitaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    protected CitaService $citaService;

    public function __construct(CitaService $citaService)
    {
        $this->citaService = $citaService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_hora' => 'required|date',
            'motivo'     => 'nullable|string',
            'paciente_id'=> 'nullable|exists:users,id',
        ]);

        $pacienteId = Auth::user()->esNutriologo() 
            ? $request->input('paciente_id') 
            : Auth::id();

        $this->citaService->crearCita($pacienteId, $request->input('fecha_hora'), $request->input('motivo'));

        return back()->with('success', 'Cita agendada correctamente.');
    }

    public function cambiarEstado(Request $request, Cita $cita)
    {
        $request->validate(['estado' => 'required|in:confirmada,cancelada,pendiente']);
        $this->citaService->cambiarEstadoCita($cita, $request->input('estado'));

        return back()->with('success', 'Estado de la cita modificado.');
    }

    public function reprogramar(Request $request, Cita $cita)
    {
        $request->validate(['fecha_hora' => 'required|date']);
        $this->citaService->reprogramarCita($cita, $request->input('fecha_hora'));

        return back()->with('success', 'Cita reprogramada correctamente.');
    }
}