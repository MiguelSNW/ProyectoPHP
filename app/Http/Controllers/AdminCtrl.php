<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\TareasModel;

use App\Models\GestorErrores;



class AdminCtrl
{
    private $gestorErrores;
    private $model;

    public function __construct()
    {
        $this->model = new TareasCtrl();
        $this->gestorErrores = new GestorErrores();
    }

    public function Inicio()
    {
        session_start();
        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'administrador' &&
            isset($_COOKIE['user_role']) && $_COOKIE['user_role'] == 'administrador') {
            return $this->model->Ver('Panel admin', view('admin.dashboard'), 'administrador');
        } else {
            return view('Login', ['gestorErrores' => $this->gestorErrores]);
        }
    }

}
