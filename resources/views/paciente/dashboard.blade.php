@extends('layouts.app')

@section('content')
<h2>Panel del Paciente: {{ $paciente->name }}</h2>

<div class="grid-2">
    <div class="card">
        <h3>Agendar / Solicitar Cita</h3>
        <form action="{{ route('citas.store') }}" method="POST">
            @csrf
            <label for="fecha_hora">Seleccionar Fecha y Hora Disponible</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" required>

            <label for="motivo">Motivo de Consulta</label>
            <input type="text" name="motivo" id="motivo">

            <button type="submit">Solicitar Cita</button>
        </form>
    </div>

    <div class="card">
        <h3>Notificaciones Recientes</h3>
        @forelse($notificaciones as $n)
            <div style="border-bottom: 1px dashed var(--border-color); padding: 0.5rem 0;">
                <p>{{ $n->mensaje }}</p>
                <small>{{ $n->created_at->format('d/m/Y H:i') }}</small>
            </div>
        @empty
            <p>No tiene notificaciones pendientes.</p>
        @endforelse
    </div>
</div>

<div class="card">
    <h3>Mis Citas Programadas</h3>
    <table class="bordered-table">
        <thead>
            <tr>
                <th>Fecha / Hora</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $c)
            <tr>
                <td>{{ $c->fecha_hora->format('d/m/Y H:i') }}</td>
                <td>{{ $c->motivo ?? 'Consulta General' }}</td>
                <td>{{ strtoupper($c->estado) }}</td>
                <td>
                    @if($c->estado !== 'cancelada')
                        <form action="{{ route('citas.estado', $c->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="estado" value="cancelada">
                            <button type="submit">Cancelar Cita</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection