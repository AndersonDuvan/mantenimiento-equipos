<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipos', function (Blueprint $t) {
            $t->id();
            $t->string('codigo', 30)->unique();
            $t->string('descripcion');
            $t->string('ubicacion', 100);
            $t->enum('estado', ['operativo', 'en_mantenimiento', 'fuera_de_servicio'])->default('operativo');
            $t->date('fecha_registro');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('equipos'); }
};
