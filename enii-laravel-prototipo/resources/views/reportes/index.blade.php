@extends('layouts.app')
@section('title', 'Reportes')
@section('content')
<h1>Reporte de mantenimientos</h1>
<form class="filtros" method="GET">
  <select name="equipo_id"><option value="">Todos los equipos</option>
  @foreach($equipos as $e)<option value="{{ $e->id }}" @selected(request('equipo_id')==$e->id)>{{ $e->codigo }}</option>@endforeach</select>
  <select name="estado_equipo"><option value="">Cualquier estado de equipo</option>
  @foreach(['operativo','en_mantenimiento','fuera_de_servicio'] as $s)<option value="{{ $s }}" @selected(request('estado_equipo')===$s)>{{ str_replace('_',' ',$s) }}</option>@endforeach</select>
  <div><label for="desde" style="margin:0">Desde</label><input id="desde" type="date" name="desde" value="{{ request('desde') }}"></div>
  <div><label for="hasta" style="margin:0">Hasta</label><input id="hasta" type="date" name="hasta" value="{{ request('hasta') }}"></div>
  <button class="btn sec">Generar</button>
  <a class="btn" href="{{ route('reportes.csv', request()->query()) }}">Descargar CSV</a>
</form>
<div class="grid">
  <div class="card stat"><b>{{ $filas->count() }}</b><small>Registros en el reporte</small></div>
  <div class="card stat"><b>{{ $resumen['preventivo'] ?? 0 }}</b><small>Preventivos</small></div>
  <div class="card stat"><b>{{ $resumen['correctivo'] ?? 0 }}</b><small>Correctivos</small></div>
</div>
<div class="tw"><table>
<tr><th>Fecha</th><th>Equipo</th><th>Tipo</th><th>Estado</th><th>Actividad</th><th>Acciones</th><th>Responsable</th></tr>
@forelse($filas as $m)
<tr><td>{{ $m->fecha_programada->format('d/m/Y') }}</td><td>{{ $m->equipo->codigo }}</td><td>{{ $m->tipo }}</td><td>{{ $m->estado }}</td>
<td>{{ $m->descripcion }}</td><td>{{ $m->acciones ?? '—' }}</td><td>{{ $m->usuario->name }}</td></tr>
@empty<tr><td colspan="7" class="muted">Ningún mantenimiento coincide con los filtros.</td></tr>@endforelse
</table></div>
@endsection
