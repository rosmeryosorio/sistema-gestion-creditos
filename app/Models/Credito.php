<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'monto',          // Nombre en la base de datos
        'saldo',          // Nombre en la base de datos
        'tasa_interes',
        'plazo_meses',
        'fecha_inicio',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}