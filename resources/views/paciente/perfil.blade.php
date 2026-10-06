@extends('layouts.app')

@section('content')
<h2>Mi Perfil y Datos Personal</h2>

<div class="grid-2">
    <div class="card">
        <h3>Actualizar Informacion Personal</h3>
        <form action="{{ route('paciente.perfil.actualizar') }}" method="POST">
            @csrf
            <label>Nombre Completo</label>
            <input type="text" name="name" value="{{ $paciente->name }}" required>

            <label>Telefono</label>
            <input type="text" name="telefono" value="{{ $paciente->telefono }}">

            <label>Direccion de Domicilio</label>
            <input type="text" name="direccion" value="{{ $paciente->direccion }}">

            <button type="submit">Actualizar Mis Datos</button>
        </form>
    </div>

    <div class="card">
        <h3>Mi Expediente Nutricional (Solo Lectura)</h3>
        <p><strong>Edad:</strong> {{ $paciente->expediente->edad ?? 'N/A' }} anos</p>
        <p><strong>Estatura:</strong> {{ $paciente->expediente->estatura_cm ?? 'N/A' }} cm</p>
        <p><strong>Peso:</strong> {{ $paciente->expediente->peso_kg ?? 'N/A' }} kg</p>
        <p><strong>Alergias:</strong> {{ $paciente->expediente->alergias ?? 'Ninguna' }}</p>
        <p><strong>Diagnostico:</strong> {{ $paciente->expediente->diagnostico ?? 'Sin datos' }}</p>
        <p><strong>Plan Alimenticio:</strong> {{ $paciente->expediente->plan_alimenticio ?? 'Sin datos' }}</p>
    </div>
</div>
@endsection