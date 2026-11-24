<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    private const ESTADOS = ['operativo', 'en_mantenimiento', 'fuera_de_servicio'];

    private function soloAdmin(): void
    {
        abort_unless(auth()->user()->esAdmin(), 403, 'Solo el administrador puede realizar esta acción.');
    }

    private function reglas(?Equipo $equipo = null): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', 'unique:equipos,codigo' . ($equipo ? ',' . $equipo->id : '')],
            'descripcion' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:100',
            'estado' => 'required|in:' . implode(',', self::ESTADOS),
            'fecha_registro' => 'required|date',
        ];
    }

    public function index(Request $r)
    {
        $equipos = Equipo::query()
            ->when($r->q, fn ($q, $t) => $q->where(fn ($w) => $w->where('codigo', 'like', "%$t%")
                ->orWhere('descripcion', 'like', "%$t%")->orWhere('ubicacion', 'like', "%$t%")))
            ->when($r->estado, fn ($q, $e) => $q->where('estado', $e))
            ->orderBy('codigo')->paginate(15)->withQueryString();
        return view('equipos.index', ['equipos' => $equipos, 'estados' => self::ESTADOS]);
    }

    public function create()
    {
        $this->soloAdmin();
        return view('equipos.create', ['estados' => self::ESTADOS]);
    }

    public function store(Request $r)
    {
        $this->soloAdmin();
        $equipo = Equipo::create($r->validate($this->reglas()));
        return redirect()->route('equipos.show', $equipo)->with('ok', 'Equipo registrado.');
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['fallas.usuario', 'mantenimientos.usuario']);
        return view('equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $this->soloAdmin();
        return view('equipos.edit', ['equipo' => $equipo, 'estados' => self::ESTADOS]);
    }

    public function update(Request $r, Equipo $equipo)
    {
        $this->soloAdmin();
        $equipo->update($r->validate($this->reglas($equipo)));
        return redirect()->route('equipos.show', $equipo)->with('ok', 'Equipo actualizado.');
    }

    public function destroy(Equipo $equipo)
    {
        $this->soloAdmin();
        $equipo->delete();
        return redirect()->route('equipos.index')->with('ok', 'Equipo eliminado.');
    }
}
