@extends('layouts.app')
@section('title', 'Equipos')
@section('content')
<div class="bar"><h1>Equipos</h1>
@if(auth()->user()->esAdmin())<a class="btn" href="{{ route('equipos.create') }}">Registrar equipo</a>@endif</div>
<form class="filtros" method="GET">
  <input name="q" value="{{ request('q') }}" placeholder="Buscar código, descripción o sala">
  <select name="estado"><option value="">Todos los estados</option>
  @foreach($estados as $e)<option value="{{ $e }}" @selected(request('estado')===$e)>{{ str_replace('_',' ',$e) }}</option>@endforeach</select>
  <button class="btn sec">Filtrar</button>
</form>
<div class="tw"><table>
<tr><th>Código</th><th>Descripción</th><th>Ubicación</th><th>Estado</th><th></th></tr>
@forelse($equipos as $e)
<tr><td><a href="{{ route('equipos.show', $e) }}">{{ $e->codigo }}</a></td><td>{{ $e->descripcion }}</td><td>{{ $e->ubicacion }}</td>
<td><span class="badge b-{{ $e->estado }}">{{ str_replace('_',' ',$e->estado) }}</span></td>
<td><a href="{{ route('fallas.create', ['equipo' => $e->id]) }}">Reportar falla</a></td></tr>
@empty<tr><td colspan="5" class="muted">No hay equipos que coincidan con la búsqueda.</td></tr>@endforelse
</table></div>
<div class="pag">{{ $equipos->links() }}</div>
@endsection
