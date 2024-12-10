<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Illuminate\Support\Facades\Session;
use App\Models\GestorErrores;

class AuthCtrl
{
    private $db;
    private $model;
    private $gestorErrores;

    public function __construct()
    {
       
        $this->db = new Database();
        $this->model = new TareasCtrl();
        $this->gestorErrores = new GestorErrores();
    }

    public function showLoginForm()
    {
        // Verificar si las cookies existen y restaurar la sesión
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_role'])) {
            session_start();
            $_SESSION['user_id'] = $_COOKIE['user_id'];
            $_SESSION['user_role'] = $_COOKIE['user_role'];
            
            // Redirigir según el tipo de usuario
            if ($_SESSION['user_role'] == 'administrador') {
                return $this->model->Ver('Panel Administrador', view('admin.dashboard'),'administrador');
            } elseif ($_SESSION['user_role'] == 'operario') {
                return $this->model->Ver('Panel Operario', view('operario.dashboard'),'operario');
            }
        }

        return view('Login', ['gestorErrores' => $this->gestorErrores]);
    }

    public function PanelLog()
    {
        return $this->showLoginForm();
    }

    public function login()
    {

        
        // Obtener los datos del formulario
        $username = $_POST['usuario'] ?? null;
        $password = $_POST['password'] ?? null;

        // Verificar que los datos existen
        if ($username && $password) {
            // Obtener el usuario desde la base de datos
            $user = $this->db->getUserByUsername($username);
            
            // Verificar si el usuario existe y la contraseña es correcta
            if ($user) {
                if ($password == $user['clave']) {
                    session_start();  // Iniciar la sesión manualmente
                    
                    // Guardar en la sesión usando $_SESSION
                    $_SESSION['user_id'] = $user['usuario'];
                    $_SESSION['user_role'] = $user['tipo'];
                     // Guardar cookies para mantener la sesión
                     if (isset($_POST['remember'])) {
                        setcookie('user_id', $user['usuario'], time() + (86400 * 30), "/");  // 30 días
                        setcookie('user_role', $user['tipo'], time() + (86400 * 30), "/");
                    }
                   

                    if ($user['tipo'] == 'administrador') {
                        return $this->model->Ver('Panel Admin', view('admin.dashboard'),'administrador');
                       
                    } elseif ($user['tipo'] == 'operario') {
                        return $this->model->Ver('Panel Admin', view('operario.dashboard'),'operario');
                    } else {
                        $this->gestorErrores->AnotaError('usuario', 'Tipo de usuario desconocido.');
                    }
                } else {
                    $this->gestorErrores->AnotaError('password', 'La contraseña es incorrecta.');
                }
            } else {
                $this->gestorErrores->AnotaError('usuario', 'El usuario no existe.');
            }
        } else {
            $this->gestorErrores->AnotaError('usuario', 'Por favor, ingrese un usuario.');
            $this->gestorErrores->AnotaError('password', 'Por favor, ingrese una contraseña.');
        }

        // Si hay errores, devolver la vista de login con los mensajes de error
        return view('Login', ['gestorErrores' => $this->gestorErrores]);
    }

    public function logout()
    {
        session_start(); 
        session_unset();
        session_destroy();

        // Eliminar cookies
        setcookie('user_id', '', time() - 3600, "/");
        setcookie('user_role', '', time() - 3600, "/");

        // Redirigir al formulario de login
        return view('Login', ['gestorErrores' => $this->gestorErrores]);
    }
}
