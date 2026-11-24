<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Falla;
use App\Models\Mantenimiento;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'porEstado' => Equipo::selectRaw('estado, count(*) as total')->groupBy('estado')->pluck('total', 'estado'),
            'totalEquipos' => Equipo::count(),
            'fallasAbiertas' => Falla::with('equipo')->where('estado', '!=', 'resuelta')
                ->orderByRaw("CASE prioridad WHEN 'alta' THEN 1 WHEN 'media' THEN 2 ELSE 3 END")->take(8)->get(),
            'proximos' => Mantenimiento::with('equipo')->where('estado', 'programado')
                ->orderBy('fecha_programada')->take(8)->get(),
        ]);
    }
}
