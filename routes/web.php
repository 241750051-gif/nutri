<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NutriologoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ExpedienteController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de Nutriologo (Super usuario)
Route::middleware(['auth', 'role:nutriologo'])->prefix('nutriologo')->group(function () {
    Route::get('/dashboard', [NutriologoController::class, 'dashboard'])->name('nutriologo.dashboard');
    Route::get('/pacientes', [NutriologoController::class, 'pacientes'])->name('nutriologo.pacientes');
    Route::post('/pacientes/crear', [NutriologoController::class, 'crearPaciente'])->name('nutriologo.pacientes.crear');
    Route::post('/pacientes/carga-masiva', [NutriologoController::class, 'cargaMasiva'])->name('nutriologo.pacientes.cargamasiva');
    Route::post('/pacientes/{paciente}/toggle', [NutriologoController::class, 'toggleEstadoPaciente'])->name('nutriologo.pacientes.toggle');

    Route::get('/expediente/{paciente}', [ExpedienteController::class, 'show'])->name('expediente.ver');
    Route::post('/expediente/{paciente}', [ExpedienteController::class, 'update'])->name('expediente.actualizar');
    Route::get('/expediente/{paciente}/descargar', [ExpedienteController::class, 'descargarTxt'])->name('expediente.txt');
});

// Rutas del Paciente
Route::middleware(['auth', 'role:paciente'])->prefix('paciente')->group(function () {
    Route::get('/dashboard', [PacienteController::class, 'dashboard'])->name('paciente.dashboard');
    Route::get('/perfil', [PacienteController::class, 'perfil'])->name('paciente.perfil');
    Route::post('/perfil', [PacienteController::class, 'actualizarPerfil'])->name('paciente.perfil.actualizar');
});

// Rutas Generales de Citas
Route::middleware(['auth'])->group(function () {
    Route::post('/citas/crear', [CitaController::class, 'store'])->name('citas.store');
    Route::post('/citas/{cita}/estado', [CitaController::class, 'cambiarEstado'])->name('citas.estado');
    Route::post('/citas/{cita}/reprogramar', [CitaController::class, 'reprogramar'])->name('citas.reprogramar');
});