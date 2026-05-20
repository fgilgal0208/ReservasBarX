<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // 1. Los campos que permitimos guardar en la base de datos
    protected $fillable = [
        'nombre_huesped',
        'fecha_entrada',
        'fecha_salida',
        'habitacion',
        'precio',
        'origen',
        'telefono',
        'email',
        'observaciones',
    ];

    // 2. Convertimos automáticamente las fechas a objetos Carbon (nos salvará la vida en el calendario)
    protected $casts = [
        'fecha_entrada' => 'date',
        'fecha_salida' => 'date',
    ];
}