<!DOCTYPE html>
<html>
<head>
    <title>Modificar Tareas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modificar Tareas</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NIF/CIF</th>
                    <th>Persona Contacto</th>
                    <th>Teléfonos Contacto</th>
                    <th>Correo Contacto</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Operario Encargado</th>
                    <th>Fecha Realización</th>
                    <th>Anotaciones Anteriores</th>
                    <th>Anotaciones Posteriores</th>
                    <th>Fichero Resumen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea['nif_cif'] }}</td>
                        <td>{{ $tarea['persona_contacto'] }}</td>
                        <td>{{ $tarea['telefono_contacto'] }}</td>
                        <td>{{ $tarea['correo_contacto'] }}</td>
                        <td>{{ $tarea['estado'] }}</td>
                        <td>{{ $tarea['fecha_creacion'] }}</td>
                        <td>{{ $tarea['operario_encargado'] }}</td>
                        <td>{{ $tarea['fecha_realizacion'] }}</td>
                        <td>{{ $tarea['anotaciones_anteriores'] }}</td>
                        <td>{{ $tarea['anotaciones_posteriores'] }}</td>
                        <td>{{ $tarea['fichero_resumen'] }}</td>
                        <td>
                        <a href="{{ route('tareas.modificar', $tarea['id']) }}" class="btn btn-warning">Modificar</a>
                       
                        <form action="{{ route('tareas.eliminar', $tarea['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>sdgtnuythb
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="pagination">
            @if ($paginaActual > 1)
                <a href="{{ route('listamod', ['pagina' => $paginaActual - 1]) }}" class="btn btn-primary">Anterior</a>
            @endif

            @if ($paginaActual < $totalPaginas)
                <a href="{{ route('listamod', ['pagina' => $paginaActual + 1]) }}" class="btn btn-primary">Siguiente</a>
            @endif
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
