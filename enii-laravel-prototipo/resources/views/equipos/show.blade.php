@extends('layouts.app')
@section('title', $equipo->codigo)
@section('content')
<div class="bar"><h1>{{ $equipo->codigo }} <span class="badge b-{{ $equipo->estado }}">{{ str_replace('_',' ',$equipo->estado) }}</span></h1>
<div>
 <a class="btn sec" href="{{ route('fallas.create', ['equipo'=>$equipo->id]) }}">Reportar falla</a>
 <a class="btn sec" href="{{ route('mantenimientos.create', ['equipo'=>$equipo->id]) }}">Programar preventivo</a>
 @if(auth()->user()->esAdmin())
  <a class="btn" href="{{ route('equipos.edit', $equipo) }}">Editar</a>
 @endif
</div></div>
<div class="card">
  <p><b>Descripción:</b> {{ $equipo->descripcion }}</p>
  <p><b>Ubicación:</b> {{ $equipo->ubicacion }}</p>
  <p><b>Registrado:</b> {{ $equipo->fecha_registro->format('d/m/Y') }}</p>
</div>

<h2>Fallas reportadas</h2>
<div class="tw"><table>
<tr><th>Fecha</th><th>Descripción</th><th>Prioridad</th><th>Estado</th><th>Reportó</th></tr>
@forelse($equipo->fallas->sortByDesc('fecha') as $f)
<tr><td>{{ $f->fecha->format('d/m/Y') }}</td><td>{{ $f->descripcion }}</td><td><span class="badge b-{{ $f->prioridad }}">{{ $f->prioridad }}</span></td>
<td><span class="badge b-{{ $f->estado }}">{{ str_replace('_',' ',$f->estado) }}</span></td><td>{{ $f->usuario->name }}</td></tr>
@empty<tr><td colspan="5" class="muted">Este equipo no tiene fallas registradas.</td></tr>@endforelse
</table></div>

<h2>Historial de mantenimiento</h2>
<div class="tw"><table>
<tr><th>Fecha</th><th>Tipo</th><th>Actividad</th><th>Acciones realizadas</th><th>Estado</th></tr>
@forelse($equipo->mantenimientos->sortByDesc('fecha_programada') as $m)
<tr><td>{{ ($m->fecha_realizada ?? $m->fecha_programada)->format('d/m/Y') }}</td><td><span class="badge b-{{ $m->tipo }}">{{ $m->tipo }}</span></td>
<td>{{ $m->descripcion }}</td><td>{{ $m->acciones ?? '—' }}</td><td><span class="badge b-{{ $m->estado }}">{{ $m->estado }}</span></td></tr>
@empty<tr><td colspan="5" class="muted">Este equipo aún no tiene mantenimientos.</td></tr>@endforelse
</table></div>

@if(auth()->user()->esAdmin())
<form method="POST" action="{{ route('equipos.destroy', $equipo) }}" onsubmit="return confirm('¿Eliminar este equipo y todo su historial?')" style="margin-top:20px">
@csrf @method('DELETE')<button class="btn del">Eliminar equipo</button></form>
@endif
@endsection
