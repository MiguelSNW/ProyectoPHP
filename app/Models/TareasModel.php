<?php

namespace App\Models;

class TareasModel {

    private $db;

    // Constructor inicializa la base de datos
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function ListaTareas()
    {
        return $this->db->getTareas();
    }

    public function ListaTareasPendientes($pagina, $elementosPorPagina)
    {
        return $this->db->getTareasPendientes($pagina, $elementosPorPagina);
    }

    public function EliminarTareas($id)
    {
        return $this->db->EliminarTareas($id);
    }

    public function ModificarTareas($id)
    {
        return $this->db->getTareas();
    }

    public function InsertarTareas()
    {
        return $this->db->insertarTareas();
    }

    public function getOperarios()
    {
        return $this->db->getOperarios();
    }

    public function insertarDatos($data)
    {
        return $this->db->insertarDatos($data);
    }

    public function getProvincias()
    {
        return $this->db->getProvincias();
    }

    public function insertarUsuarios($data)
    {
        return $this->db->insertarUsuarios($data);
    }

    public function getUsuarios($pagina = 1, $elementosPorPagina = 5)
    {
        return $this->db->getUsuarios($pagina, $elementosPorPagina);
    }

    public function getUsuario($usuario)
    {
        return $this->db->getUserByUsername($usuario);
    }

    public function eliminarUser($usuario)
    {
        return $this->db->eliminarUser($usuario);
    }

    public function actualizarTarea($id, $datos)
    {
        return $this->db->actualizarTarea($id, $datos);
    }

    public function actualizarTareaPendiente($id, $datos)
    {
        return $this->db->actualizarTareaPendiente($id, $datos);
    }

    public function mostrarTareas(int $pagina = 1, int $elementosPorPagina = 5): array
    {
        return $this->db->getTareas($pagina, $elementosPorPagina);
    }

    public function actualizarClave($usuario)
    {
        return $this->db->actualizarClave($usuario);
    }

    public function tareaporid($id)
    {
        return $this->db->obtenerTareaPorId($id);
    }

    public function getTarea($id)
    {
        return $this->db->getTarea(1);
    }

    public function Update(int $id, array $tarea)
    {
        $tarea['id'] = $id;
        $tareas = $this->getTareas();
        $tareas[$id] = $tarea;
        $_SESSION[self::SESS_TAREAS] = $tareas; // Guardar las tareas actualizadas en la sesión
    }

    public function Add(array $tarea)
    {
        $id = $this->NextId();
        $tarea['id'] = $id;
        $tareas = $this->GetTareas();
        $tareas[$id] = $tarea;
        $_SESSION[self::SESS_TAREAS] = $tareas; // Guardar las tareas actualizadas en la sesión
    }

    protected function NextId(): int
    {
        $tareas = $this->GetTareas();
        return count($tareas) > 0 ? max(array_keys($tareas)) + 1 : 1; // Retorna el siguiente id
    }

    const SESS_TAREAS = 'tareas';
}
