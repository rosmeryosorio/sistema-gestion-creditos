<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellidos',
        'dui',
        'telefono',
        'direccion',
    ];

    /**
     * Relación: Un cliente puede tener muchos créditos.
     */
    public function creditos()
    {
        return $this->hasMany(Credito::class, 'cliente_id');
    }
}