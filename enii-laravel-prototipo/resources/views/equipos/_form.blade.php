<label for="codigo">Código / identificador</label>
<input id="codigo" name="codigo" value="{{ old('codigo', $equipo->codigo ?? '') }}" required maxlength="30">
<label for="descripcion">Descripción</label>
<input id="descripcion" name="descripcion" value="{{ old('descripcion', $equipo->descripcion ?? '') }}" required>
<label for="ubicacion">Ubicación (sala)</label>
<input id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $equipo->ubicacion ?? '') }}" required>
<label for="estado">Estado</label>
<select id="estado" name="estado">
@foreach($estados as $e)<option value="{{ $e }}" @selected(old('estado', $equipo->estado ?? 'operativo') === $e)>{{ str_replace('_',' ',$e) }}</option>@endforeach
</select>
<label for="fecha_registro">Fecha de registro</label>
<input id="fecha_registro" type="date" name="fecha_registro" value="{{ old('fecha_registro', isset($equipo) ? $equipo->fecha_registro->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
