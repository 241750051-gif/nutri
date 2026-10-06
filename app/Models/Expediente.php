<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $fillable = [
        'user_id',
        'edad',
        'estatura_cm',
        'peso_kg',
        'alergias',
        'antecedentes',
        'diagnostico',
        'plan_alimenticio',
        'observaciones',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}