@extends('layouts.app')

@section('content')
<div class="auth-container card">
    <h3 style="text-align: center; margin-bottom: 1rem;">Inicio de Sesion</h3>
    
    @if($errors->any())
        <div style="color: red; margin-bottom: 1rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label for="email">Correo Electronico</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contrasena</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" style="width: 100%; margin-top: 1rem;">Ingresar al Sistema</button>
    </form>
</div>
@endsection