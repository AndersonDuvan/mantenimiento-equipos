@extends('layouts.app')
@section('title', 'Atender falla')
@section('content')
<h1>Atender falla en {{ $falla->equipo->codigo }}</h1>
<div class="card"><b>Falla reportada:</b> {{ $falla->descripcion }}
 <span class="badge b-{{ $falla->prioridad }}">{{ $falla->prioridad }}</span></div>
<form class="card" method="POST" action="{{ route('fallas.registrar', $falla) }}">@csrf
  <label for="fecha_realizada">Fecha de la intervención</label>
  <input id="fecha_realizada" type="date" name="fecha_realizada" value="{{ old('fecha_realizada', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" required>
  <label for="acciones">Acciones realizadas</label>
  <textarea id="acciones" name="acciones" required>{{ old('acciones') }}</textarea>
  <label for="resultado">Resultado</label>
  <select id="resultado" name="resultado">
    <option value="resuelta">Resuelta (el equipo vuelve a operativo)</option>
    <option value="en_atencion">Sigue en atención</option>
  </select>
  <p><button class="btn">Guardar atención</button> <a class="btn sec" href="{{ route('fallas.index') }}">Cancelar</a></p>
</form>
@endsection
