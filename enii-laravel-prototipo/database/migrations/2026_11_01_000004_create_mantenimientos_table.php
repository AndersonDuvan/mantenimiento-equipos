<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mantenimientos', function (Blueprint $t) {
            $t->id();
            $t->foreignId('equipo_id')->constrained()->cascadeOnDelete();
            $t->foreignId('falla_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('user_id')->constrained();
            $t->enum('tipo', ['preventivo', 'correctivo']);
            $t->date('fecha_programada');
            $t->date('fecha_realizada')->nullable();
            $t->text('descripcion');
            $t->text('acciones')->nullable();
            $t->enum('estado', ['programado', 'realizado', 'cancelado'])->default('programado');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('mantenimientos'); }
};
