<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function dashboard()
    {
        $paciente = Auth::user();
        $citas = Cita::where('paciente_id', $paciente->id)->orderBy('fecha_hora', 'asc')->get();
        $notificaciones = Notificacion::where('user_id', $paciente->id)->orderBy('created_at', 'desc')->get();
        
        return view('paciente.dashboard', compact('paciente', 'citas', 'notificaciones'));
    }

    public function perfil()
    {
        $paciente = Auth::user()->load('expediente');
        return view('paciente.perfil', compact('paciente'));
    }

    public function actualizarPerfil(Request $request)
    {
        $paciente = Auth::user();
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'telefono'  => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $paciente->update($data);

        return back()->with('success', 'Informacion personal actualizada correctamente.');
    }
}