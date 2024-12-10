<!DOCTYPE html>
<html>
<head>
    <title>Modificar Clave</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modificar Clave para {{ $usuario }}</h2>
        
        <!-- Formulario para modificar la contraseña -->
        <form action="{{ route('actualizarclave', $usuario) }}" method="POST" onsubmit="return confirmarActualizacion()" >
    @csrf  <!-- Laravel aún necesita CSRF token -->
    <div class="form-group">
        <label for="nueva_clave">Nueva Contraseña</label>
        <input type="password" class="form-control" name="nueva_clave" id="nueva_clave" >
    </div>
    {!! $gestorErrores->ErrorFormateado('nueva_clave') !!}

    <div class="form-group">
        <label for="nueva_clave_confirmation">Confirmar Contraseña</label>
        <input type="password" class="form-control" name="nueva_clave_confirmation" id="nueva_clave_confirmation" >
    </div>
    {!! $gestorErrores->ErrorFormateado('nueva_clave_confirmation') !!}

    <br><button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
</form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function confirmarActualizacion() {
        return confirm('¿Estás seguro de que deseas actualizar la clave?');
    }
</script>
</body>
</html>
