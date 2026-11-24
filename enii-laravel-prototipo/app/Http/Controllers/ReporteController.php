<?php
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    private function consulta(Request $r)
    {
        return Mantenimiento::with(['equipo', 'usuario'])
            ->when($r->equipo_id, fn ($q, $v) => $q->where('equipo_id', $v))
            ->when($r->estado_equipo, fn ($q, $v) => $q->whereHas('equipo', fn ($e) => $e->where('estado', $v)))
            ->when($r->desde, fn ($q, $v) => $q->whereDate('fecha_programada', '>=', $v))
            ->when($r->hasta, fn ($q, $v) => $q->whereDate('fecha_programada', '<=', $v))
            ->orderBy('fecha_programada', 'desc');
    }

    public function index(Request $r)
    {
        $filas = $this->consulta($r)->get();
        return view('reportes.index', [
            'filas' => $filas,
            'equipos' => Equipo::orderBy('codigo')->get(),
            'resumen' => $filas->groupBy('tipo')->map->count(),
        ]);
    }

    public function csv(Request $r)
    {
        $filas = $this->consulta($r)->get();
        return response()->streamDownload(function () use ($filas) {
            $f = fopen('php://output', 'w');
            fwrite($f, "\xEF\xBB\xBF");
            fputcsv($f, ['Equipo', 'Tipo', 'Fecha programada', 'Fecha realizada', 'Estado', 'Descripción', 'Acciones', 'Responsable']);
            foreach ($filas as $m) {
                fputcsv($f, [$m->equipo->codigo, $m->tipo, $m->fecha_programada->format('Y-m-d'),
                    optional($m->fecha_realizada)->format('Y-m-d'), $m->estado, $m->descripcion, $m->acciones, $m->usuario->name]);
            }
            fclose($f);
        }, 'reporte_mantenimientos.csv', ['Content-Type' => 'text/csv']);
    }
}
