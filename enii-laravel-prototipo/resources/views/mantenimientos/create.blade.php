@extends('layouts.app')
@section('title', 'Programar mantenimiento')
@section('content')
<h1>Programar mantenimiento preventivo</h1>
<form class="card" method="POST" action="{{ route('mantenimientos.store') }}">@csrf
  <label for="equipo_id">Equipo</label>
  <select id="equipo_id" name="equipo_id" required>
    <option value="">Selecciona un equipo</option>
    @foreach($equipos as $e)<option value="{{ $e->id }}" @selected(old('equipo_id', $equipoId) == $e->id)>{{ $e->codigo }} — {{ $e->ubicacion }}</option>@endforeach
  </select>
  <label for="fecha_programada">Fecha prevista</label>
  <input id="fecha_programada" type="date" name="fecha_programada" value="{{ old('fecha_programada') }}" min="{{ now()->format('Y-m-d') }}" required>
  <label for="descripcion">Actividad a realizar</label>
  <textarea id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>
  <p><button class="btn">Programar</button> <a class="btn sec" href="{{ route('mantenimientos.index') }}">Cancelar</a></p>
</form>
@endsection
