@extends('layouts.app')

@section('content')
<h2>Expediente Clinico: {{ $paciente->name }}</h2>

<div style="margin-bottom: 1rem;">
    <a href="{{ route('expediente.txt', $paciente->id) }}" class="btn">Descargar Informe (.TXT)</a>
</div>

<div class="card">
    <form action="{{ route('expediente.actualizar', $paciente->id) }}" method="POST">
        @csrf
        <div class="grid-2">
            <div>
                <label>Edad</label>
                <input type="number" name="edad" value="{{ $paciente->expediente->edad ?? '' }}">

                <label>Estatura (cm)</label>
                <input type="number" step="0.01" name="estatura_cm" value="{{ $paciente->expediente->estatura_cm ?? '' }}">

                <label>Peso (kg)</label>
                <input type="number" step="0.01" name="peso_kg" value="{{ $paciente->expediente->peso_kg ?? '' }}">
            </div>
            <div>
                <label>Alergias</label>
                <textarea name="alergias" rows="2">{{ $paciente->expediente->alergias ?? '' }}</textarea>

                <label>Antecedentes Medicos</label>
                <textarea name="antecedentes" rows="2">{{ $paciente->expediente->antecedentes ?? '' }}</textarea>
            </div>
        </div>

        <label>Diagnostico Nutricional</label>
        <textarea name="diagnostico" rows="3">{{ $paciente->expediente->diagnostico ?? '' }}</textarea>

        <label>Plan Alimenticio</label>
        <textarea name="plan_alimenticio" rows="4">{{ $paciente->expediente->plan_alimenticio ?? '' }}</textarea>

        <label>Observaciones</label>
        <textarea name="observaciones" rows="2">{{ $paciente->expediente->observaciones ?? '' }}</textarea>

        <button type="submit" style="margin-top: 1rem;">Guardar Expediente Clinico</button>
    </form>
</div>
@endsection