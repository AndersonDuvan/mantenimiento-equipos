<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $fillable = ['equipo_id', 'falla_id', 'user_id', 'tipo', 'fecha_programada',
        'fecha_realizada', 'descripcion', 'acciones', 'estado'];
    protected $casts = ['fecha_programada' => 'date', 'fecha_realizada' => 'date'];

    public function equipo() { return $this->belongsTo(Equipo::class); }
    public function falla() { return $this->belongsTo(Falla::class); }
    public function usuario() { return $this->belongsTo(User::class, 'user_id'); }
}
