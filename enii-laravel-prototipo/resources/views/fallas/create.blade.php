@extends('layouts.app')
@section('title', 'Reportar falla')
@section('content')
<h1>Reportar falla</h1>
<form class="card" method="POST" action="{{ route('fallas.store') }}">@csrf
  <label for="equipo_id">Equipo</label>
  <select id="equipo_id" name="equipo_id" required>
    <option value="">Selecciona un equipo</option>
    @foreach($equipos as $e)<option value="{{ $e->id }}" @selected(old('equipo_id', $equipoId) == $e->id)>{{ $e->codigo }} — {{ $e->ubicacion }}</option>@endforeach
  </select>
  <label for="fecha">Fecha de la falla</label>
  <input id="fecha" type="date" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
  <label for="prioridad">Prioridad</label>
  <select id="prioridad" name="prioridad">
    @foreach(['baja','media','alta'] as $p)<option value="{{ $p }}" @selected(old('prioridad','media')===$p)>{{ $p }}</option>@endforeach
  </select>
  <label for="descripcion">¿Qué está fallando?</label>
  <textarea id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>
  <p><button class="btn">Reportar falla</button> <a class="btn sec" href="{{ route('fallas.index') }}">Cancelar</a></p>
</form>
@endsection
