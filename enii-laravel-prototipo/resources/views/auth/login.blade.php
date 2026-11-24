@extends('layouts.app')
@section('title', 'Iniciar sesión')
@section('content')
<div class="card login">
  <h1>Mantenimiento de equipos ENII</h1>
  <form method="POST" action="{{ route('login') }}">@csrf
    <label for="email">Correo</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" required>
    <p><button class="btn">Entrar</button></p>
  </form>
  <p class="muted">Prototipo con datos ficticios.</p>
</div>
@endsection
