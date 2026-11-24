@extends('layouts.app')
@section('title', 'Editar equipo')
@section('content')
<h1>Editar {{ $equipo->codigo }}</h1>
<form class="card" method="POST" action="{{ route('equipos.update', $equipo) }}">@csrf @method('PUT')
  @include('equipos._form')
  <p><button class="btn">Guardar cambios</button> <a class="btn sec" href="{{ route('equipos.show', $equipo) }}">Cancelar</a></p>
</form>
@endsection
