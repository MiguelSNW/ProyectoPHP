<!DOCTYPE html>
<html>
<head>
    <title>Vista de Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Vista de Tareas Pendientes</h2>
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
                    <th>Acción</th>
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
                        <td> <a href="{{ route('tareas.confirmar', $tarea['id']) }}" class="btn btn-success">Aprobar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
    @if ($paginaActual > 1)
        <a href="{{ route('tareas.pendientes', ['pagina' => $paginaActual - 1]) }}" class="btn btn-primary">Anterior</a>
    @endif

    @if ($paginaActual < $totalPaginas)
        <a href="{{ route('tareas.pendientes', ['pagina' => $paginaActual + 1]) }}" class="btn btn-primary">Siguiente</a>
    @endif
</div>

    </div>

  

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
