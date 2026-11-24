<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Falla extends Model
{
    protected $fillable = ['equipo_id', 'user_id', 'fecha', 'descripcion', 'prioridad', 'estado'];
    protected $casts = ['fecha' => 'date'];

    public function equipo() { return $this->belongsTo(Equipo::class); }
    public function usuario() { return $this->belongsTo(User::class, 'user_id'); }
    public function mantenimientos() { return $this->hasMany(Mantenimiento::class); }
}
