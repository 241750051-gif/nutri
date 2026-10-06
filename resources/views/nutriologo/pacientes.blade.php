@extends('layouts.app')

@section('content')
<h2>Gestion de Pacientes</h2>

<div class="grid-2">
    <div class="card">
        <h3>Registro Individual de Paciente</h3>
        <form action="{{ route('nutriologo.pacientes.crear') }}" method="POST">
            @csrf
            <label>Nombre Completo</label>
            <input type="text" name="name" required>

            <label>Correo Electronico</label>
            <input type="email" name="email" required>

            <label>Telefono</label>
            <input type="text" name="telefono">

            <label>Direccion</label>
            <input type="text" name="direccion">

            <button type="submit">Guardar Paciente</button>
        </form>
    </div>

    <div class="card">
        <h3>Carga Masiva (TXT / CSV)</h3>
        <p style="font-size: 0.85rem; margin-bottom: 1rem;">Formato: nombre,correo,telefono</p>
        <form action="{{ route('nutriologo.pacientes.cargamasiva') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="archivo" accept=".csv,.txt" required>
            <button type="submit">Procesar Archivo</button>
        </form>
    </div>
</div>

<div class="card">
    <h3>Lista de Pacientes Registrados</h3>
    <table class="bordered-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->email }}</td>
                <td>{{ $p->activo ? 'ACTIVO' : 'INACTIVO' }}</td>
                <td>
                    <a href="{{ route('expediente.ver', $p->id) }}" class="btn">Expediente</a>
                    <form action="{{ route('nutriologo.pacientes.toggle', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">{{ $p->activo ? 'Desactivar' : 'Activar' }}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection