@extends('layouts.app')
@section('title', 'Registrar mantenimiento')
@section('content')
<h1>Registrar mantenimiento en {{ $m->equipo->codigo }}</h1>
<div class="card"><b>Actividad programada ({{ $m->fecha_programada->format('d/m/Y') }}):</b> {{ $m->descripcion }}</div>
<form class="card" method="POST" action="{{ route('mantenimientos.cierre', $m) }}">@csrf
  <label for="fecha_realizada">Fecha en que se realizó</label>
  <input id="fecha_realizada" type="date" name="fecha_realizada" value="{{ old('fecha_realizada', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
  <label for="acciones">Acciones realizadas</label>
  <textarea id="acciones" name="acciones" required>{{ old('acciones') }}</textarea>
  <p><button class="btn">Guardar</button> <a class="btn sec" href="{{ route('mantenimientos.index') }}">Cancelar</a></p>
</form>
@endsection
