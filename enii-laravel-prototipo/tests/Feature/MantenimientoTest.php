<?php
namespace Tests\Feature;

use App\Models\Equipo;
use App\Models\Falla;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MantenimientoTest extends TestCase
{
    use RefreshDatabase;

    private function equipo(): Equipo
    {
        return Equipo::create(['codigo' => 'PC-001', 'descripcion' => 'Prueba', 'ubicacion' => 'Sala 1',
            'estado' => 'operativo', 'fecha_registro' => now()]);
    }

    public function test_invitado_es_redirigido_al_login(): void
    {
        $this->get('/equipos')->assertRedirect('/login');
    }

    public function test_admin_registra_equipo(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $this->actingAs($admin)->post('/equipos', ['codigo' => 'PC-009', 'descripcion' => 'X', 'ubicacion' => 'Sala 2',
            'estado' => 'operativo', 'fecha_registro' => now()->format('Y-m-d')])->assertRedirect();
        $this->assertDatabaseHas('equipos', ['codigo' => 'PC-009']);
    }

    public function test_tecnico_no_puede_registrar_equipo(): void
    {
        $tec = User::factory()->create(['rol' => 'tecnico']);
        $this->actingAs($tec)->post('/equipos', ['codigo' => 'PC-009', 'descripcion' => 'X', 'ubicacion' => 'Sala 2',
            'estado' => 'operativo', 'fecha_registro' => now()->format('Y-m-d')])->assertForbidden();
    }

    public function test_codigo_duplicado_es_rechazado(): void
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        $this->equipo();
        $this->actingAs($admin)->post('/equipos', ['codigo' => 'PC-001', 'descripcion' => 'X', 'ubicacion' => 'S',
            'estado' => 'operativo', 'fecha_registro' => now()->format('Y-m-d')])->assertSessionHasErrors('codigo');
    }

    public function test_reportar_falla_pone_equipo_en_mantenimiento(): void
    {
        $tec = User::factory()->create(['rol' => 'tecnico']);
        $e = $this->equipo();
        $this->actingAs($tec)->post('/fallas', ['equipo_id' => $e->id, 'fecha' => now()->format('Y-m-d'),
            'descripcion' => 'No enciende', 'prioridad' => 'alta'])->assertRedirect();
        $this->assertSame('en_mantenimiento', $e->fresh()->estado);
    }

    public function test_atender_falla_crea_historial_y_restaura_equipo(): void
    {
        $tec = User::factory()->create(['rol' => 'tecnico']);
        $e = $this->equipo();
        $f = Falla::create(['equipo_id' => $e->id, 'user_id' => $tec->id, 'fecha' => now(), 'descripcion' => 'Falla',
            'prioridad' => 'media', 'estado' => 'abierta']);
        $this->actingAs($tec)->post("/fallas/{$f->id}/atender", ['acciones' => 'Cambio de fuente',
            'fecha_realizada' => now()->format('Y-m-d'), 'resultado' => 'resuelta'])->assertRedirect();
        $this->assertDatabaseHas('mantenimientos', ['equipo_id' => $e->id, 'tipo' => 'correctivo', 'estado' => 'realizado']);
        $this->assertSame('operativo', $e->fresh()->estado);
    }

    public function test_programar_preventivo_con_fecha_pasada_es_rechazado(): void
    {
        $tec = User::factory()->create(['rol' => 'tecnico']);
        $e = $this->equipo();
        $this->actingAs($tec)->post('/mantenimientos', ['equipo_id' => $e->id,
            'fecha_programada' => now()->subDay()->format('Y-m-d'), 'descripcion' => 'Limpieza'])
            ->assertSessionHasErrors('fecha_programada');
    }
}
