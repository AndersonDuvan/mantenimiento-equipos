@extends('layouts.app')
@section('title', 'Mantenimientos')
@section('content')
<div class="bar"><h1>Mantenimientos</h1><a class="btn" href="{{ route('mantenimientos.create') }}">Programar preventivo</a></div>
<form class="filtros" method="GET">
  <select name="tipo"><option value="">Todos los tipos</option>
  @foreach(['preventivo','correctivo'] as $t)<option value="{{ $t }}" @selected(request('tipo')===$t)>{{ $t }}</option>@endforeach</select>
  <select name="estado"><option value="">Todos los estados</option>
  @foreach(['programado','realizado','cancelado'] as $e)<option value="{{ $e }}" @selected(request('estado')===$e)>{{ $e }}</option>@endforeach</select>
  <button class="btn sec">Filtrar</button>
</form>
<div class="tw"><table>
<tr><th>Fecha</th><th>Equipo</th><th>Tipo</th><th>Actividad</th><th>Estado</th><th></th></tr>
@forelse($items as $m)
<tr><td>{{ $m->fecha_programada->format('d/m/Y') }}</td><td><a href="{{ route('equipos.show', $m->equipo) }}">{{ $m->equipo->codigo }}</a></td>
<td><span class="badge b-{{ $m->tipo }}">{{ $m->tipo }}</span></td><td>{{ $m->descripcion }}</td><td><span class="badge b-{{ $m->estado }}">{{ $m->estado }}</span></td>
<td>@if($m->estado==='programado')
 <a href="{{ route('mantenimientos.completar', $m) }}">Registrar</a>
 <form method="POST" action="{{ route('mantenimientos.cancelar', $m) }}" style="display:inline">@csrf<button class="btn sec" style="padding:2px 8px">Cancelar</button></form>
@endif</td></tr>
@empty<tr><td colspan="6" class="muted">No hay mantenimientos registrados.</td></tr>@endforelse
</table></div>
<div class="pag">{{ $items->links() }}</div>
@endsection
