<!DOCTYPE html>
<html>
<head>
    <title>Modificar Tarea</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modificar Tarea</h2>
        <form action="{{ route('tareas.aprobar', $tarea['id']) }}" method="POST" onsubmit="return confirmarActualizacion()">
            @csrf
            @method('PUT') <!-- método PUT para actualización -->

            <div class="form-group">
                <label for="estado">Estado</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="R">Realizada</option>
                    <option value="C">Cancelada</option>
                </select>
            </div>

            <div class="form-group">
                <label for="anotaciones_anteriores">Anotaciones Anteriores</label>
                <textarea class="form-control" id="anotaciones_anteriores" name="anotaciones_anteriores">{{ old('anotaciones_anteriores', $tarea['anotaciones_anteriores']) }}</textarea>
            </div>

            <div class="form-group">
                <label for="anotaciones_posteriores">Anotaciones Posteriores</label>
                <textarea class="form-control" id="anotaciones_posteriores" name="anotaciones_posteriores">{{ old('anotaciones_posteriores', $tarea['anotaciones_posteriores']) }}</textarea>
            </div>

           

            <div class="form-group">
                <button type="submit" class="btn btn-primary" >Aprobar Tarea</button>
            </div>
        </form>
        <a href="{{ route('tareas.pendientes') }}" class="btn btn-primary">Atrás</a>
    </div>
    
    <script>
    function confirmarActualizacion() {
        return confirm('¿Estás seguro de que deseas eliminar? esta tarea?');
    }
</script>
</body>
</html>
