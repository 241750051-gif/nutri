<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expediente;
use App\Services\ExpedienteService;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function show(User $paciente)
    {
        $paciente->load('expediente');
        return view('nutriologo.expediente', compact('paciente'));
    }

    public function update(Request $request, User $paciente)
    {
        $data = $request->validate([
            'edad'             => 'nullable|integer',
            'estatura_cm'      => 'nullable|numeric',
            'peso_kg'          => 'nullable|numeric',
            'alergias'         => 'nullable|string',
            'antecedentes'     => 'nullable|string',
            'diagnostico'      => 'nullable|string',
            'plan_alimenticio' => 'nullable|string',
            'observaciones'    => 'nullable|string',
        ]);

        $paciente->expediente()->updateOrCreate(['user_id' => $paciente->id], $data);

        return back()->with('success', 'Expediente clinico actualizado correctamente.');
    }

    public function descargarTxt(User $paciente, ExpedienteService $expedienteService)
    {
        $contenido = $expedienteService->generarInformeTxt($paciente);
        $fileName = 'expediente_' . $paciente->id . '_' . date('Ymd') . '.txt';

        return response($contenido)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}