<!DOCTYPE html>
<html>
<head>
    <title>Vista de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Vista de Usuarios</h2>
        
        <!-- Formulario para insertar un nuevo usuario -->
        <form action="{{ route('insertaruser') }}" method="POST" onsubmit="return confirmarActualizacion()">
            @csrf
            
            <!-- Campo de Usuario -->
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario">
                @if ($gestorErrores->HayError('usuario'))
                    <div class="text-danger">{{ $gestorErrores->Error('usuario') }}</div>
                @endif
            </div>

            <!-- Campo de Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="clave" id="password">
                @if ($gestorErrores->HayError('clave'))
                    <div class="text-danger">{{ $gestorErrores->Error('clave') }}</div>
                @endif
            </div>

            <!-- Campo de Tipo de Usuario -->
            <div class="form-group">
                <label for="tipo">Tipo de Usuario</label>
                <select class="form-control" name="tipo" id="tipo">
                    <option value="administrador">Administrador</option>
                    <option value="operario">Operario</option>
                </select>
                @if ($gestorErrores->HayError('tipo'))
                    <div class="text-danger">{{ $gestorErrores->Error('tipo') }}</div>
                @endif
            </div>

            <!-- Botón para insertar el usuario -->
            <button type="submit" class="btn btn-success">Insertar Nuevo Usuario</button>
        </form>
        
    <script>
        function confirmarActualizacion() {
            return confirm('¿Estás seguro de que deseas insertar este usuario?');
        }
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
