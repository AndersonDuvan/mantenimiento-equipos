@extends('layouts.app')
@section('title', 'Registrar equipo')
@section('content')
<h1>Registrar equipo</h1>
<form class="card" method="POST" action="{{ route('equipos.store') }}">@csrf
  @include('equipos._form')
  <p><button class="btn">Guardar equipo</button> <a class="btn sec" href="{{ route('equipos.index') }}">Cancelar</a></p>
</form>
@endsection
