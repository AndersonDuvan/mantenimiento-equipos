@extends('layouts.app')
@section('title', 'Inicio')
@section('content')
<h1>Estado general</h1>
<div class="grid">
  <div class="card stat"><b>{{ $totalEquipos }}</b><small>Equipos registrados</small></div>
  <div class="card stat"><b>{{ $porEstado['operativo'] ?? 0 }}</b><small>Operativos</small></div>
  <div class="card stat"><b>{{ $porEstado['en_mantenimiento'] ?? 0 }}</b><small>En mantenimiento</small></div>
  <div class="card stat"><b>{{ $porEstado['fuera_de_servicio'] ?? 0 }}</b><small>Fuera de servicio</small></div>
</div>

<h2>Fallas pendientes</h2>
<div class="tw"><table>
<tr><th>Equipo</th><th>Falla</th><th>Prioridad</th><th>Estado</th><th></th></tr>
@forelse($fallasAbiertas as $f)
<tr><td><a href="{{ route('equipos.show', $f->equipo) }}">{{ $f->equipo->codigo }}</a></td><td>{{ $f->descripcion }}</td>
<td><span class="badge b-{{ $f->prioridad }}">{{ $f->prioridad }}</span></td>
<td><span class="badge b-{{ $f->estado }}">{{ str_replace('_',' ',$f->estado) }}</span></td>
<td><a href="{{ route('fallas.atender', $f) }}">Atender</a></td></tr>
@empty<tr><td colspan="5" class="muted">No hay fallas pendientes.</td></tr>@endforelse
</table></div>

<h2>Próximos mantenimientos preventivos</h2>
<div class="tw"><table>
<tr><th>Fecha</th><th>Equipo</th><th>Actividad</th><th></th></tr>
@forelse($proximos as $m)
<tr><td>{{ $m->fecha_programada->format('d/m/Y') }}</td><td>{{ $m->equipo->codigo }}</td><td>{{ $m->descripcion }}</td>
<td><a href="{{ route('mantenimientos.completar', $m) }}">Registrar</a></td></tr>
@empty<tr><td colspan="4" class="muted">No hay mantenimientos programados.</td></tr>@endforelse
</table></div>
@endsection
