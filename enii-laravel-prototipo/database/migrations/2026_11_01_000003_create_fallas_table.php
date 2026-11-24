<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fallas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('equipo_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained();
            $t->date('fecha');
            $t->text('descripcion');
            $t->enum('prioridad', ['baja', 'media', 'alta'])->default('media');
            $t->enum('estado', ['abierta', 'en_atencion', 'resuelta'])->default('abierta');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('fallas'); }
};
