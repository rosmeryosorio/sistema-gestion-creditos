<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Pago extends Model
{
protected $table = 'pagos';
protected $fillable = [
'credito_id',
'fecha_pago',
'monto',
'referencia',
'observaciones'
];

public function credito()
{
return $this->belongsTo(Credito::class);
}
}
