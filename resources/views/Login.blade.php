<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .btn-block {
            margin-top: 20px;
        }

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="login-container">
            <h2 class="text-center">Login</h2>
            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Usuario -->
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" required>
                    @if ($gestorErrores->HayError('usuario'))
                        <div class="text-danger">{{ $gestorErrores->Error('usuario') }}</div>
                    @endif
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                    @if ($gestorErrores->HayError('password'))
                        <div class="text-danger">{{ $gestorErrores->Error('password') }}</div>
                    @endif
                </div>


                <!-- Mantener sesión iniciada -->
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Mantener sesión iniciada</label>
                </div>


                <!-- Botón de Login -->
                <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>