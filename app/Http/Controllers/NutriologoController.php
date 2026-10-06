<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cita;
use App\Models\Expediente;
use App\Services\ExpedienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NutriologoController extends Controller
{
    public function dashboard()
    {
        $citas = Cita::with('paciente')->orderBy('fecha_hora', 'asc')->get();
        $pacientes = User::where('rol', 'paciente')->where('activo', true)->get();
        return view('nutriologo.dashboard', compact('citas', 'pacientes'));
    }

    public function pacientes()
    {
        $pacientes = User::where('rol', 'paciente')->with('expediente')->get();
        return view('nutriologo.pacientes', compact('pacientes'));
    }

    public function crearPaciente(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'telefono'  => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $paciente = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make('paciente123'),
            'telefono'  => $data['telefono'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'rol'       => 'paciente',
            'activo'    => true,
        ]);

        Expediente::create(['user_id' => $paciente->id]);

        return back()->with('success', 'Paciente registrado exitosamente.');
    }

    public function cargaMasiva(Request $request, ExpedienteService $expedienteService)
    {
        $request->validate(['archivo' => 'required|file|mimes:txt,csv']);
        $lineas = file($request->file('archivo')->getRealPath());
        $procesados = $expedienteService->cargaMasivaPacientes($lineas);

        return back()->with('success', "Se cargaron $procesados pacientes exitosamente.");
    }

    public function toggleEstadoPaciente(User $paciente)
    {
        $paciente->update(['activo' => !$paciente->activo]);
        return back()->with('success', 'Estado del paciente actualizado.');
    }
}