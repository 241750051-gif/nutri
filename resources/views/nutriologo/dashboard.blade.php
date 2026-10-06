@extends('layouts.app')

@section('content')
<h2>Panel de Control del Nutriologo</h2>

<div class="grid-2">
    <div class="card">
        <h3>Agendar Nueva Cita</h3>
        <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            <label for="paciente_id">Seleccionar Paciente</label>
            <select name="paciente_id" id="paciente_id" required>
                @foreach($pacientes as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>

            <label for="fecha_hora">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" required>

            <label for="motivo">Motivo de Consulta</label>
            <input type="text" name="motivo" id="motivo">

            <button type="submit">Agendar Cita</button>
        </form>
    </div>

    <div class="card">
        <h3>Calendario y Agenda Global</h3>
        <table class="bordered-table">
            <thead>
                <tr>
                    <th>Fecha / Hora</th>
                    <th>Paciente</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $c)
                <tr>
                    <td>{{ $c->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td>{{ $c->paciente->name }}</td>
                    <td>{{ strtoupper($c->estado) }}</td>
                    <td>
                        <form action="{{ route('citas.estado', $c->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <select name="estado" onchange="this.form.submit()" style="margin:0; width:auto;">
                                <option value="pendiente" {{ $c->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ $c->estado === 'confirmada' ? 'selected' : '' }}>Confirmar</option>
                                <option value="cancelada" {{ $c->estado === 'cancelada' ? 'selected' : '' }}>Cancelar</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection