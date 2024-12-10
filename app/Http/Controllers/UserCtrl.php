<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\TareasModel;
use App\Models\GestorErrores;
class UserCtrl
{
    private $gestorErrores;
    public function __construct()
    {
        $this->model = new TareasCtrl();
    }

    public function index()
    {
        session_start();
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'operario' &&
            isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'operario') {
            return $this->model->Ver('Panel admin', view('operario.dashboard'), 'operario');
        } else {
            return view('Login', ['gestorErrores' => $this->gestorErrores]);
        }
    }

}