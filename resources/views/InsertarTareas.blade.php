<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Formulario para Agregar Nueva Tarea</h1>
        <div class="card" style="max-height: 70vh; overflow-y: auto;">
        <form method="POST" action="{{ route('tareas.insertar') }}" enctype="multipart/form-data"  onsubmit="return confirmarActualizacion()" enctype="multipart/form-data">
            @csrf

            <!-- NIF o CIF -->
            <div class="form-group">
                <label for="nif_cif">NIF o CIF</label>
                <input type="text" class="form-control" name="nif_cif" id="nif_cif" value="{{ old('nif_cif', $data['nif_cif'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('nif_cif') !!}
            </div>

            <!-- Persona de contacto -->
            <div class="form-group">
                <label for="persona_contacto">Persona de Contacto</label>
                <input type="text" class="form-control" name="persona_contacto" id="persona_contacto" value="{{ old('persona_contacto', $data['persona_contacto'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('persona_contacto') !!}
            </div>

            <!-- Teléfonos de contacto -->
            <div class="form-group">
                <label for="telefono_contacto">Teléfonos de Contacto</label>
                <input type="text" class="form-control" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto', $data['telefono_contacto'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('telefono_contacto') !!}
            </div>

            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion">{{ old('descripcion', $data['descripcion'] ?? '') }}</textarea>
                {!! $gestorErrores->ErrorFormateado('descripcion') !!}
            </div>

            <!-- Correo electrónico -->
            <div class="form-group">
                <label for="correo_contacto">Correo Electrónico</label>
                <input type="text" class="form-control" name="correo_contacto" id="correo_contacto" value="{{ old('correo_contacto', $data['correo_contacto'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('correo_contacto') !!}
            </div>

            <!-- Dirección -->
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', $data['direccion'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('direccion') !!}
            </div>

            <!-- Población -->
            <div class="form-group">
                <label for="poblacion">Población</label>
                <input type="text" class="form-control" name="poblacion" id="poblacion" value="{{ old('poblacion', $data['poblacion'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('poblacion') !!}
            </div>

            <!-- Código postal -->
            <div class="form-group">
                <label for="codigo_postal">Código Postal</label>
                <input type="text" class="form-control" name="codigo_postal" id="codigo_postal" value="{{ old('codigo_postal', $data['codigo_postal'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('codigo_postal') !!}
            </div>

            <!-- Provincia -->
            <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" name="provincia" id="provincia">
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia['nombre'] }}" {{ (old('provincia', $data['provincia'] ?? '') == $provincia['nombre']) ? 'selected' : '' }}>{{ $provincia['nombre'] }}</option>
                    @endforeach
                </select>
                {!! $gestorErrores->ErrorFormateado('provincia') !!}
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="B" {{ (old('estado', $data['estado'] ?? '') == 'B') ? 'selected' : '' }}>Esperando ser aprobada</option>
                    <option value="P" {{ (old('estado', $data['estado'] ?? '') == 'P') ? 'selected' : '' }}>Pendiente</option>
                    <option value="R" {{ (old('estado', $data['estado'] ?? '') == 'R') ? 'selected' : '' }}>Aprobada</option>
                    <option value="C" {{ (old('estado', $data['estado'] ?? '') == 'C') ? 'selected' : '' }}>Cancelada</option>
                </select>
                {!! $gestorErrores->ErrorFormateado('estado') !!}
            </div>

            <!-- Fecha de creación (generada automáticamente) -->
            <div class="form-group">
                <label for="fecha_creacion">Fecha de Creación</label>
                <input type="text" class="form-control" name="fecha_creacion" id="fecha_creacion" value="{{ now()->format('Y-m-d H:i:s') }}" disabled>
            </div>

            <!-- Operario encargado -->
            <div class="form-group">
                <label for="operario_encargado">Operario Encargado</label>
                <select class="form-control" name="operario_encargado" id="operario_encargado">
                    @foreach ($operarios as $operario)
                        <option value="{{ $operario['usuario'] }}" {{ (old('operario_encargado', $data['operario_encargado'] ?? '') == $operario['usuario']) ? 'selected' : '' }}>{{ $operario['usuario'] }}</option>
                    @endforeach
                </select>
                {!! $gestorErrores->ErrorFormateado('operario_encargado') !!}
            </div>

            <!-- Fecha de realización -->
            <div class="form-group">
                <label for="fecha_realizacion">Fecha de Realización</label>
                <input type="date" class="form-control" name="fecha_realizacion" id="fecha_realizacion" value="{{ old('fecha_realizacion', $data['fecha_realizacion'] ?? '') }}">
                {!! $gestorErrores->ErrorFormateado('fecha_realizacion') !!}
            </div>

            <!-- Anotaciones anteriores -->
            <div class="form-group">
                <label for="anotaciones_anteriores">Anotaciones Anteriores</label>
                <textarea class="form-control" name="anotaciones_anteriores" id="anotaciones_anteriores">{{ old('anotaciones_anteriores', $data['anotaciones_anteriores'] ?? '') }}</textarea>
                {!! $gestorErrores->ErrorFormateado('anotaciones_anteriores') !!}
            </div>

            <!-- Anotaciones posteriores -->
            <div class="form-group">
                <label for="anotaciones_posteriores">Anotaciones Posteriores</label>
                <textarea class="form-control" name="anotaciones_posteriores" id="anotaciones_posteriores">{{ old('anotaciones_posteriores', $data['anotaciones_posteriores'] ?? '') }}</textarea>
                {!! $gestorErrores->ErrorFormateado('anotaciones_posteriores') !!}
            </div>

            <!-- Fichero resumen de tareas -->
            <div class="form-group">
                <label for="fichero_resumen">Fichero Resumen de Tareas Realizadas</label>
                <input type="file" class="form-control" name="fichero_resumen" id="fichero_resumen" >
                {!! $gestorErrores->ErrorFormateado('fichero_resumen') !!}
            </div>

            <!-- Fotos del trabajo realizado -->
            <div class="form-group">
                <label for="fotos">Fotos del Trabajo Realizado</label>
                <input type="file" class="form-control" name="fotos" id="fotos">
                {!! $gestorErrores->ErrorFormateado('fotos') !!}
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-success">Registrar Tarea</button>
            </div>
        </form>
        </div>
    </div>

 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
