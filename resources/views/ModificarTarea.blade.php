<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tarea</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Modificar Tarea</h1>
        <div class="card" style="max-height: 70vh; overflow-y: auto;">
        <form action="{{ route('tareas.actualizar', $tarea['id']) }}" method="POST" onsubmit="return confirmarActualizacion()" enctype="multipart/form-data">                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nif_cif">NIF/CIF</label>
                    <input type="text" class="form-control" id="nif_cif" name="nif_cif" value="{{ old('nif_cif', $tarea['nif_cif']) }}">
                    {!! $gestorErrores->ErrorFormateado('nif_cif') !!}
                </div>

                <div class="form-group">
                    <label for="persona_contacto">Persona Contacto</label>
                    <input type="text" class="form-control" id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto', $tarea['persona_contacto']) }}">
                    {!! $gestorErrores->ErrorFormateado('persona_contacto') !!}
                </div>

                <div class="form-group">
                    <label for="telefono_contacto">Teléfonos Contacto</label>
                    <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto', $tarea['telefono_contacto']) }}">
                    {!! $gestorErrores->ErrorFormateado('telefono_contacto') !!}
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion">{{ old('descripcion', $tarea['descripcion']) }}</textarea>
                    {!! $gestorErrores->ErrorFormateado('descripcion') !!}
                </div>

                <div class="form-group">
                    <label for="correo_contacto">Correo Contacto</label>
                    <input type="text" class="form-control" id="correo_contacto" name="correo_contacto" value="{{ old('correo_contacto', $tarea['correo_contacto']) }}">
                    {!! $gestorErrores->ErrorFormateado('correo_contacto') !!}
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion', $tarea['direccion']) }}">
                    {!! $gestorErrores->ErrorFormateado('direccion') !!}
                </div>

                <div class="form-group">
                    <label for="poblacion">Población</label>
                    <input type="text" class="form-control" id="poblacion" name="poblacion" value="{{ old('poblacion', $tarea['poblacion']) }}">
                    {!! $gestorErrores->ErrorFormateado('poblacion') !!}
                </div>

                <div class="form-group">
                    <label for="codigo_postal">Código Postal</label>
                    <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $tarea['codigo_postal']) }}">
                    {!! $gestorErrores->ErrorFormateado('codigo_postal') !!}
                </div>

                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <input type="text" class="form-control" id="provincia" name="provincia" value="{{ old('provincia', $tarea['provincia']) }}">
                    {!! $gestorErrores->ErrorFormateado('provincia') !!}
                </div>

                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select class="form-control" name="estado" id="estado">
                        <option value="B" {{ $tarea['estado'] == 'B' ? 'selected' : '' }}>Esperando ser aprobada</option>
                        <option value="P" {{ $tarea['estado'] == 'P' ? 'selected' : '' }}>Pendiente</option>
                        <option value="R" {{ $tarea['estado'] == 'R' ? 'selected' : '' }}>Aprobada</option>
                        <option value="C" {{ $tarea['estado'] == 'C' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    {!! $gestorErrores->ErrorFormateado('estado') !!}
                </div>

                <div class="form-group">
                    <label for="fecha_creacion">Fecha Creación</label>
                    <input type="datetime-local" class="form-control" id="fecha_creacion" name="fecha_creacion" value="{{ old('fecha_creacion', $tarea['fecha_creacion']) }}">
                    {!! $gestorErrores->ErrorFormateado('fecha_creacion') !!}
                </div>

                <div class="form-group">
                    <label for="operario_encargado">Operario Encargado</label>
                    <input type="text" class="form-control" id="operario_encargado" name="operario_encargado" value="{{ old('operario_encargado', $tarea['operario_encargado']) }}">
                    {!! $gestorErrores->ErrorFormateado('operario_encargado') !!}
                </div>

                <div class="form-group">
                    <label for="fecha_realizacion">Fecha Realización</label>
                    <input type="date" class="form-control" id="fecha_realizacion" name="fecha_realizacion" value="{{ old('fecha_realizacion', $tarea['fecha_realizacion']) }}">
                    {!! $gestorErrores->ErrorFormateado('fecha_realizacion') !!}
                </div>

                <div class="form-group">
                    <label for="anotaciones_anteriores">Anotaciones Anteriores</label>
                    <textarea class="form-control" id="anotaciones_anteriores" name="anotaciones_anteriores">{{ old('anotaciones_anteriores', $tarea['anotaciones_anteriores']) }}</textarea>
                    {!! $gestorErrores->ErrorFormateado('anotaciones_anteriores') !!}
                </div>

                <div class="form-group">
                    <label for="anotaciones_posteriores">Anotaciones Posteriores</label>
                    <textarea class="form-control" id="anotaciones_posteriores" name="anotaciones_posteriores">{{ old('anotaciones_posteriores', $tarea['anotaciones_posteriores']) }}</textarea>
                    {!! $gestorErrores->ErrorFormateado('anotaciones_posteriores') !!}
                </div>

                <div class="form-group">
    <label for="fichero_resumen">Fichero Resumen</label>
    <input type="file" class="form-control" id="fichero_resumen" name="fichero_resumen" >
    {!! $gestorErrores->ErrorFormateado('fichero_resumen') !!}
</div>

                <div class="form-group">
                    <label for="fotos">Fotos</label>
                    <input type="file" class="form-control" id="fotos" name="fotos" value="{{ old('fotos', $tarea['fotos']) }}" >
                    {!! $gestorErrores->ErrorFormateado('fotos') !!}
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>

            <div class="form-group">
                <form action="{{ route('listamod') }}">
                    <button class="btn btn-primary">Atrás</button>
                </form>
            </div>
        </div>
    </div>
    <script>
    function confirmarActualizacion() {
        return confirm('¿Estás seguro de que deseas actualizar esta tarea?');
    }
</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
