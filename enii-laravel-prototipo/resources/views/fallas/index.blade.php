@extends('layouts.app')
@section('title', 'Fallas')
@section('content')
<div class="bar"><h1>Fallas reportadas</h1><a class="btn" href="{{ route('fallas.create') }}">Reportar falla</a></div>
<form class="filtros" method="GET">
  <select name="estado"><option value="">Todos los estados</option>
  @foreach(['abierta','en_atencion','resuelta'] as $e)<option value="{{ $e }}" @selected(request('estado')===$e)>{{ str_replace('_',' ',$e) }}</option>@endforeach</select>
  <select name="prioridad"><option value="">Toda prioridad</option>
  @foreach(['alta','media','baja'] as $p)<option value="{{ $p }}" @selected(request('prioridad')===$p)>{{ $p }}</option>@endforeach</select>
  <button class="btn sec">Filtrar</button>
</form>
<div class="tw"><table>
<tr><th>Fecha</th><th>Equipo</th><th>Descripción</th><th>Prioridad</th><th>Estado</th><th></th></tr>
@forelse($fallas as $f)
<tr><td>{{ $f->fecha->format('d/m/Y') }}</td><td><a href="{{ route('equipos.show', $f->equipo) }}">{{ $f->equipo->codigo }}</a></td><td>{{ $f->descripcion }}</td>
<td><span class="badge b-{{ $f->prioridad }}">{{ $f->prioridad }}</span></td><td><span class="badge b-{{ $f->estado }}">{{ str_replace('_',' ',$f->estado) }}</span></td>
<td>@if($f->estado !== 'resuelta')<a href="{{ route('fallas.atender', $f) }}">Atender</a>@endif</td></tr>
@empty<tr><td colspan="6" class="muted">No hay fallas registradas.</td></tr>@endforelse
</table></div>
<div class="pag">{{ $fallas->links() }}</div>
@endsection
