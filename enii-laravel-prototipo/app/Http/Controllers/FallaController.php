<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Falla;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class FallaController extends Controller
{
    public function index(Request $r)
    {
        $fallas = Falla::with(['equipo', 'usuario'])
            ->when($r->estado, fn ($q, $e) => $q->where('estado', $e))
            ->when($r->prioridad, fn ($q, $p) => $q->where('prioridad', $p))
            ->latest('fecha')->latest('id')->paginate(15)->withQueryString();
        return view('fallas.index', compact('fallas'));
    }

    public function create(Request $r)
    {
        return view('fallas.create', ['equipos' => Equipo::orderBy('codigo')->get(), 'equipoId' => $r->equipo]);
    }

    public function store(Request $r)
    {
        $datos = $r->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'fecha' => 'required|date|before_or_equal:today',
            'descripcion' => 'required|string|max:1000',
            'prioridad' => 'required|in:baja,media,alta',
        ]);
        $falla = Falla::create($datos + ['user_id' => auth()->id(), 'estado' => 'abierta']);
        Equipo::whereKey($falla->equipo_id)->update(['estado' => 'en_mantenimiento']);
        return redirect()->route('fallas.index')->with('ok', 'Falla reportada.');
    }

    public function atender(Falla $falla)
    {
        $falla->load('equipo');
        return view('fallas.atender', compact('falla'));
    }

    public function registrarAtencion(Request $r, Falla $falla)
    {
        $datos = $r->validate([
            'acciones' => 'required|string|max:2000',
            'fecha_realizada' => 'required|date|before_or_equal:today',
            'resultado' => 'required|in:en_atencion,resuelta',
        ]);

        Mantenimiento::create([
            'equipo_id' => $falla->equipo_id,
            'falla_id' => $falla->id,
            'user_id' => auth()->id(),
            'tipo' => 'correctivo',
            'fecha_programada' => $datos['fecha_realizada'],
            'fecha_realizada' => $datos['fecha_realizada'],
            'descripcion' => $falla->descripcion,
            'acciones' => $datos['acciones'],
            'estado' => 'realizado',
        ]);

        $falla->update(['estado' => $datos['resultado']]);
        if ($datos['resultado'] === 'resuelta') {
            $falla->equipo->update(['estado' => 'operativo']);
        }
        return redirect()->route('fallas.index')->with('ok', 'Atención registrada en el historial.');
    }
}
