<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    public function index(Request $r)
    {
        $items = Mantenimiento::with(['equipo', 'usuario'])
            ->when($r->tipo, fn ($q, $t) => $q->where('tipo', $t))
            ->when($r->estado, fn ($q, $e) => $q->where('estado', $e))
            ->orderBy('fecha_programada', 'desc')->paginate(15)->withQueryString();
        return view('mantenimientos.index', ['items' => $items]);
    }

    public function create(Request $r)
    {
        return view('mantenimientos.create', ['equipos' => Equipo::orderBy('codigo')->get(), 'equipoId' => $r->equipo]);
    }

    public function store(Request $r)
    {
        $datos = $r->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'fecha_programada' => 'required|date|after_or_equal:today',
            'descripcion' => 'required|string|max:1000',
        ]);
        Mantenimiento::create($datos + ['user_id' => auth()->id(), 'tipo' => 'preventivo', 'estado' => 'programado']);
        return redirect()->route('mantenimientos.index')->with('ok', 'Mantenimiento preventivo programado.');
    }

    public function completar(Mantenimiento $mantenimiento)
    {
        abort_if($mantenimiento->estado !== 'programado', 404);
        $mantenimiento->load('equipo');
        return view('mantenimientos.completar', ['m' => $mantenimiento]);
    }

    public function registrarCierre(Request $r, Mantenimiento $mantenimiento)
    {
        abort_if($mantenimiento->estado !== 'programado', 404);
        $datos = $r->validate([
            'acciones' => 'required|string|max:2000',
            'fecha_realizada' => 'required|date|before_or_equal:today',
        ]);
        $mantenimiento->update($datos + ['estado' => 'realizado', 'user_id' => auth()->id()]);
        return redirect()->route('mantenimientos.index')->with('ok', 'Mantenimiento registrado como realizado.');
    }

    public function cancelar(Mantenimiento $mantenimiento)
    {
        abort_if($mantenimiento->estado !== 'programado', 404);
        $mantenimiento->update(['estado' => 'cancelado']);
        return back()->with('ok', 'Mantenimiento cancelado.');
    }
}
