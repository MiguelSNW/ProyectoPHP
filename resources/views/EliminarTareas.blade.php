<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Tareas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Persona Contacto</th>
                    <th>Descripción</th>
                    <th>Correo Contacto</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Operario Encargado</th>
                    <th>Fecha Realización</th>
                    <th>Anotaciones Anteriores</th>
                    <th>Anotaciones Posteriores</th>
                    <th>Fichero Resumen</th>
                    <th>Fotos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea['persona_contacto'] }}</td>
                        <td>{{ $tarea['descripcion'] }}</td>
                        <td>{{ $tarea['direccion'] }}</td>
                        <td>{{ $tarea['estado'] }}</td>
                        <td>{{ $tarea['fecha_creacion'] }}</td>
                        <td>{{ $tarea['operario_encargado'] }}</td>
                        <td>{{ $tarea['fecha_realizacion'] }}</td>
                        <td>{{ $tarea['anotaciones_anteriores'] }}</td>
                        <td>{{ $tarea['anotaciones_posteriores'] }}</td>
                        <td>{{ $tarea['fichero_resumen'] }}</td>
                        <td>{{ $tarea['fotos'] }}</td>
                        <td>
                            <form action="{{ route('tareas.eliminar', $tarea['id']) }}" method="POST" onsubmit="return confirmarActualizacion()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            @if ($paginaActual > 1)
                <a href="{{ route('tareas.listael', ['pagina' => $paginaActual - 1]) }}" class="btn btn-primary">Anterior</a>
            @endif

            @if ($paginaActual < $totalPaginas)
                <a href="{{ route('tareas.listael', ['pagina' => $paginaActual + 1]) }}" class="btn btn-primary">Siguiente</a>
            @endif
        </div>
    </div>

    <script>
    function confirmarActualizacion() {
        return confirm('¿Estás seguro de que deseas eliminar? esta tarea?');
    }
</script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
