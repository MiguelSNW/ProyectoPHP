<!DOCTYPE html>
<html>
<head>
    <title>Vista de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Vista de Usuarios</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Tipo de Usuario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario['usuario'] }}</td>
                        <td>{{ $usuario['clave'] }}</td>
                        <td>{{ $usuario['tipo'] }}</td>
                        <td>
                            <form action="{{ route('tareas.eliminaruser', $usuario['usuario']) }}" method="POST" onsubmit="return confirmarActualizacion()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                            <form action="{{ route('modificaruser', $usuario['usuario']) }}" method="POST">
                                @csrf
                               
                                <button type="submit" class="btn btn-warning">Cambiar Contraseña</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <!-- Paginación -->
        <div class="pagination mt-4">
            @if ($paginaActual > 1)
                <a href="{{ route('vistauser', ['pagina' => $paginaActual - 1]) }}" class="btn btn-primary">Anterior</a>
            @endif

            @if ($paginaActual < $totalPaginas)
                <a href="{{ route('vistauser', ['pagina' => $paginaActual + 1]) }}" class="btn btn-primary">Siguiente</a>
            @endif
        </div><br>

         <!-- Botón para insertar nuevo usuario -->
         <form action="{{ route('tareas.insertaruser') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Insertar Nuevo Usuario</button>
        </form>
        
    </div>

    <script>
        function confirmarActualizacion() {
            return confirm('¿Estás seguro de que deseas eliminar este usuario?');
        }
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
