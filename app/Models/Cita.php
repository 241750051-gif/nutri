<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha_hora',
        'estado',
        'motivo',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}