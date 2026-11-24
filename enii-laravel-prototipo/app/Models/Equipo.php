<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = ['codigo', 'descripcion', 'ubicacion', 'estado', 'fecha_registro'];
    protected $casts = ['fecha_registro' => 'date'];

    public function fallas() { return $this->hasMany(Falla::class); }
    public function mantenimientos() { return $this->hasMany(Mantenimiento::class); }
}
