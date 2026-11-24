<?php
namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Falla;
use App\Models\Mantenimiento;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Datos ficticios: no contienen información real de la ENII. */
    public function run(): void
    {
        $admin = User::create(['name' => 'Administrador Demo', 'email' => 'admin@enii.test', 'password' => 'password', 'rol' => 'admin']);
        $tec = User::create(['name' => 'Técnico Demo', 'email' => 'tecnico@enii.test', 'password' => 'password', 'rol' => 'tecnico']);

        $salas = ['Sala 1', 'Sala 2', 'Sala 3'];
        $problemas = ['No enciende', 'Pantalla sin señal', 'Teclado no responde', 'Lentitud extrema', 'Sin conexión de red', 'Ruido en el ventilador'];

        for ($i = 1; $i <= 20; $i++) {
            $equipo = Equipo::create([
                'codigo' => sprintf('PC-%03d', $i),
                'descripcion' => 'Computador de escritorio ' . fake()->randomElement(['Dell', 'HP', 'Lenovo']),
                'ubicacion' => $salas[$i % 3],
                'estado' => 'operativo',
                'fecha_registro' => now()->subDays(rand(30, 400)),
            ]);

            if ($i % 4 === 0) {
                $resuelta = (bool) rand(0, 1);
                $falla = Falla::create([
                    'equipo_id' => $equipo->id, 'user_id' => $tec->id,
                    'fecha' => now()->subDays(rand(1, 40)),
                    'descripcion' => fake()->randomElement($problemas),
                    'prioridad' => fake()->randomElement(['baja', 'media', 'alta']),
                    'estado' => $resuelta ? 'resuelta' : 'abierta',
                ]);
                if ($resuelta) {
                    Mantenimiento::create(['equipo_id' => $equipo->id, 'falla_id' => $falla->id, 'user_id' => $tec->id,
                        'tipo' => 'correctivo', 'fecha_programada' => $falla->fecha, 'fecha_realizada' => $falla->fecha,
                        'descripcion' => $falla->descripcion, 'acciones' => 'Revisión y reemplazo de componente.', 'estado' => 'realizado']);
                } else {
                    $equipo->update(['estado' => 'en_mantenimiento']);
                }
            }

            if ($i % 3 === 0) {
                Mantenimiento::create(['equipo_id' => $equipo->id, 'user_id' => $admin->id, 'tipo' => 'preventivo',
                    'fecha_programada' => now()->addDays(rand(2, 45)), 'descripcion' => 'Limpieza interna y actualización de software.',
                    'estado' => 'programado']);
            }
        }
    }
}
