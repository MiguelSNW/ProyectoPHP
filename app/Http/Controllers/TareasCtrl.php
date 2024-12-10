<?php
namespace App\Http\Controllers;

use App\Models\TareasModel;
use App\Models\GestorErrores;
use App\Models\type;
use Illuminate\Support\Facades\View;    
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tareas
 *
 * @author santi
 */
class TareasCtrl
{

    protected $table = 'tareas';
    protected $model = NULL;
    private $gestorErrores;

    public function __construct()
    {
        $this->model = new TareasModel();


        // El gestor solo sería necesario crearlo si editamos o insertamos
        // Inicializamos el gestor de errores que utilizaremos en la vista
        $this->gestorErrores = new GestorErrores(
            '<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">',
            '</span>'
        );
    }

    /**
     * Vamos a la página de inicio igualmente
     */
    public function Index()
    {
        return $this->Inicio();
    }



    public function eliminar($id)
    {
        // Llama al modelo para eliminar la tarea con el id
        $this->model->EliminarTareas($id);
        $elementosPorPagina = 5;
        $pagina = 1;
        // Llamamos al método mostrarTareas() pasándole la página y los elementos por página
        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);


        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de tareas y la información de la paginación
        return $this->Ver('Lista', view('ModificarTareas', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }

    public function mostrarFormularioClave($usuario)
    {
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');
        return $this->Ver('Modificar Clave', view('FormularioClave', ['usuario' => $usuario], ['gestorErrores' => $gestorErrores]), 'administrador');
    }

    public function actualizarClave($usuario)
    {
        $gestorErrores = new GestorErrores('<div class="text-danger">', '</div>');

        // Validación manual usando $_POST
        if (empty($_POST['nueva_clave'])) {
            $gestorErrores->AnotaError('nueva_clave', 'La nueva contraseña es obligatoria');
        }

        // Asegurarse de que el campo "nueva_clave_confirmation" esté presente
        if (empty($_POST['nueva_clave_confirmation'])) {
            $gestorErrores->AnotaError('nueva_clave_confirmation', 'Debes confirmar la nueva contraseña');
        }

        if ($_POST['nueva_clave'] !== $_POST['nueva_clave_confirmation']) {
            $gestorErrores->AnotaError('nueva_clave_confirmation', 'Las contraseñas no coinciden');
        }

        if ($gestorErrores->HayErrores()) {
            // Si hay errores, redirigimos de nuevo al formulario con los errores
            return $this->Ver('Modificar Clave', view('FormularioClave', [
                'usuario' => $usuario,
                'gestorErrores' => $gestorErrores
            ]), 'administrador');
        }

        // Si no hay errores, actualizamos la contraseña
        $this->model->actualizarClave($usuario);

        // Redirigir a la vista de usuarios con un mensaje de éxito
        $resultados = $this->model->getUsuarios($pagina = 1, $elementosPorPagina = 3);

        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $usuarios = $resultados['usuarios'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de usuarios y la información de la paginación
        return $this->Ver('Lista de Usuarios', view('VistaUsuarios', [
            'usuarios' => $usuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }



    public function mostrarFormularioTipo($usuario)
    {
        return $this->Ver('Modificar Tipo', view('FormularioTipo', ['usuario' => $usuario]), 'administrador');

    }



    public function VistaUsuarios($pagina = 1)
    {
        // Número de elementos por página
        $elementosPorPagina = 3;

        // Llamamos al método getUsuarios() pasándole la página y los elementos por página
        $resultados = $this->model->getUsuarios($pagina, $elementosPorPagina);

        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $usuarios = $resultados['usuarios'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de usuarios y la información de la paginación
        return $this->Ver('Lista de Usuarios', view('VistaUsuarios', [
            'usuarios' => $usuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }

    public function eliminarUsuario($usuario)
    {
        $this->model->eliminarUser($usuario);

        $pagina = 1;
        $elementosPorPagina = 3;
        $resultados = $this->model->getUsuarios($pagina, $elementosPorPagina);

        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $usuarios = $resultados['usuarios'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];



        return $this->Ver('Lista de Usuarios', view('VistaUsuarios', [
            'usuarios' => $usuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }




    public function VistaTareas($pagina = 1)
    {
        $elementosPorPagina = 5;

        // Llamamos al método mostrarTareas() pasándole la página y los elementos por página
        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);


        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de tareas y la información de la paginación
        return $this->Ver('Lista', view('EliminarTareas', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }


    public function ListaTareas($pagina = 1)
    {
        // Número de elementos por página (puedes ajustarlo a lo que necesites)
        $elementosPorPagina = 5;

        // Llamamos al método mostrarTareas() pasándole la página y los elementos por página
        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);


        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de tareas y la información de la paginación
        return $this->Ver('Lista', view('ListaTareas', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'operario');
    }

    public function ListaTareasAdmin($pagina = 1)
    {
        // Número de elementos por página (puedes ajustarlo a lo que necesites)
        $elementosPorPagina = 5;

        // Llamamos al método mostrarTareas() pasándole la página y los elementos por página
        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);


        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de tareas y la información de la paginación
        return $this->Ver('Lista', view('ListaTareas', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }

    public function ListaTareasUser($pagina = 1)
    {
        // Número de elementos por página (puedes ajustarlo a lo que necesites)
        $elementosPorPagina = 5;

        // Llamamos al método mostrarTareas() pasándole la página y los elementos por página
        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);


        // Asegúrate de que $resultados contiene los datos paginados y la información adicional
        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Retorna la vista con la lista de tareas y la información de la paginación
        return $this->Ver('Lista', view('ListaTareasUser', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'operario');
    }


    public function Inicio()
    {
        // En un controlador real esto haría más cosas
        return $this->Ver('Página de inicio', view('InicioAdmin'), 'administrador');
    }

    public function EliminarTareas()
    {

        return $this->Ver('Eliminar Tareas', view('EliminarTareas'));
    }

    public function ModificarTareas($pagina = 1)
    {
        $elementosPorPagina = 5;

        $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);

        $tareas = $resultados['tareas'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        return $this->Ver('Lista', view('ModificarTareas', [
            'tareas' => $tareas,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }




    public function mostrarFormularioModificar($id)
    {
        $tarea = $this->model->tareaporid($id); // Obtén la tarea específica por su ID
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        return $this->Ver('Formulario', view('ModificarTarea', ['tarea' => $tarea], ['gestorErrores' => $gestorErrores]), 'administrador'); // Pasa la tarea a la vista
    }

    public function mostrarFormularioInsertar()
    {
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        return $this->Ver('Formulario Inserción', view('InsertarUser', ['gestorErrores' => $gestorErrores]), 'administrador');
    }

    public function FormularioAprobarTareas($id)
    {

        $tarea = $this->model->tareaporid($id);
        return $this->Ver('Formulario para aprobar tareas', view('FormularioAprobarTareas', ['tarea' => $tarea]), 'operario');
    }


    public function ListaTareasPendientes($pagina = 1)
    {
        // Número de elementos por página
        $elementosPorPagina = 5;
    
        // Obtener las tareas pendientes y el total de registros
        $resultados = $this->model->ListaTareasPendientes($pagina, $elementosPorPagina);
    
        // Verificar si las claves 'tareas' y 'totalPaginas' existen
        if (isset($resultados['tareas']) && isset($resultados['totalPaginas'])) {
            $tareas = $resultados['tareas'];
            $totalPaginas = $resultados['totalPaginas'];
        } else {
            // Si no existen, asignar valores por defecto
            $tareas = [];
            $totalPaginas = 1;
        }
    
        // Retornar la vista con las tareas y la paginación
        return $this->Ver('Lista de Tareas Pendientes', view('ListaTareasPendientes', [
            'tareas' => $tareas,
            'paginaActual' => $pagina,
            'totalPaginas' => $totalPaginas
        ]), 'operario');
    }
    




    public function actualizarTarea($id)
    {
        // Crear un objeto GestorErrores para manejar los errores
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        // Obtener los datos enviados desde el formulario
        $data = [
            'nif_cif' => $_POST['nif_cif'],
            'persona_contacto' => $_POST['persona_contacto'],
            'telefono_contacto' => $_POST['telefono_contacto'],
            'descripcion' => $_POST['descripcion'],
            'correo_contacto' => $_POST['correo_contacto'],
            'direccion' => $_POST['direccion'],
            'poblacion' => $_POST['poblacion'],
            'codigo_postal' => $_POST['codigo_postal'],
            'provincia' => $_POST['provincia'],
            'estado' => $_POST['estado'],
            'fecha_creacion' => $_POST['fecha_creacion'],
            'operario_encargado' => $_POST['operario_encargado'],
            'fecha_realizacion' => $_POST['fecha_realizacion'],
            'anotaciones_anteriores' => $_POST['anotaciones_anteriores'],
            'anotaciones_posteriores' => $_POST['anotaciones_posteriores'],
            'fichero_resumen' => $_FILES['fichero_resumen']['name'],
            'fotos' => $_FILES['fotos']['name']
        ];

        $actualizado = $this->model->actualizarTarea($id, $data);

        // Validación
        if (empty($data['descripcion'])) {
            $gestorErrores->AnotaError('descripcion', 'La descripción es obligatoria.');
        }

        if (empty($data['persona_contacto'])) {
            $gestorErrores->AnotaError('persona_contacto', 'La persona de contacto es obligatoria.');
        }

        if (!preg_match("/^[A-Z0-9]{8}[A-Z]$/", $data['nif_cif'])) {
            $gestorErrores->AnotaError('nif_cif', 'El NIF/CIF no es válido.');
        }

        if (!empty($data['telefono_contacto']) && !preg_match("/^(\+?\d{1,3}[\s-])?(\(?\d{1,4}\)?[\s-]?)?[\d\s\-]{5,}$/", $data['telefono_contacto'])) {
            $gestorErrores->AnotaError('telefono_contacto', 'El teléfono no tiene un formato válido.');
        }

        if (!empty($data['codigo_postal']) && !preg_match("/^\d{5}$/", $data['codigo_postal'])) {
            $gestorErrores->AnotaError('codigo_postal', 'El código postal debe tener 5 números.');
        }

        if (!filter_var($data['correo_contacto'], FILTER_VALIDATE_EMAIL)) {
            $gestorErrores->AnotaError('correo_contacto', 'El correo electrónico no es válido.');
        }

        if (strtotime($data['fecha_realizacion']) <= time()) {
            $gestorErrores->AnotaError('fecha_realizacion', 'La fecha de realización debe ser posterior a la fecha actual.');
        }

        // Si hay errores, mostrar los errores con los datos previos
        if ($gestorErrores->HayErrores()) {
            $operarios = $this->model->getOperarios();
            $provincias = $this->model->getProvincias();
            $tarea = $this->model->tareaporid($id); // Obtén la tarea específica por su ID
            return $this->Ver('Modificar', view('ModificarTarea', [
                'tarea' => $tarea,
                'gestorErrores' => $gestorErrores,
                'data' => $data,
                'provincias' => $provincias,
                'operarios' => $operarios
            ]), 'administrador');
        }

        // Si no hay errores, actualizar la tarea


        if ($actualizado) {
            $elementosPorPagina = 5;
            $pagina = 1;
            $resultados = $this->model->mostrarTareas($pagina, $elementosPorPagina);

            $tareas = $resultados['tareas'];
            $totalPaginas = $resultados['totalPaginas'];
            $paginaActual = $resultados['paginaActual'];

            return $this->Ver('Lista', view('ModificarTareas', [
                'gestorErrores' => $gestorErrores,
                'tareas' => $tareas,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $paginaActual
            ]), 'administrador');
        } else {
            // Si la actualización falla, devolver con mensaje de error
            return $this->Ver('Modificar', view('ModificarTareas', [
                'gestorErrores' => $gestorErrores,
                'error' => 'Hubo un problema al actualizar la tarea.',
                'data' => $data,
                'provincias' => $this->model->getProvincias(),
                'operarios' => $this->model->getOperarios()
            ]), 'administrador');
        }
    }


    public function aprobarTarea($id)
    {
        $datos = [
            'estado' => $_POST['estado'],
            'anotaciones_anteriores' => $_POST['anotaciones_anteriores'],
            'anotaciones_posteriores' => $_POST['anotaciones_posteriores'],
        ];

        $actualizado = $this->model->actualizarTareaPendiente($id, $datos);
        if ($actualizado) {
            $elementosPorPagina = 5;
            $pagina = 1;
        // Obtener las tareas pendientes y el total de registros
        $resultados = $this->model->ListaTareasPendientes($pagina, $elementosPorPagina);
    
        // Verificar si las claves 'tareas' y 'totalPaginas' existen
        if (isset($resultados['tareas']) && isset($resultados['totalPaginas'])) {
            $tareas = $resultados['tareas'];
            $totalPaginas = $resultados['totalPaginas'];
        } else {
            // Si no existen, asignar valores por defecto
            $tareas = [];
            $totalPaginas = 1;
        }
    
        // Retornar la vista con las tareas y la paginación
        return $this->Ver('Lista de Tareas Pendientes', view('ListaTareasPendientes', [
            'tareas' => $tareas,
            'paginaActual' => $pagina,
            'totalPaginas' => $totalPaginas
        ]), 'operario');
        } else {
            $tareas = $this->model->tareaporid($id); // Obtener la tarea actualizada
            return view('ModificarTareas', ['tarea' => $tareas, 'error' => 'Hubo un problema al actualizar la tarea.']);
        }
    }



    public function insertarUser()
    {
        // Crear el gestor de errores con el formato personalizado
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        // Obtener los datos del formulario
        $data = [
            'usuario' => $_POST['usuario'] ?? '',
            'clave' => $_POST['clave'] ?? '',
            'tipo' => $_POST['tipo'] ?? ''
        ];

        // Validar si el campo usuario está vacío
        if (empty($data['usuario'])) {
            $gestorErrores->AnotaError('usuario', 'El campo de usuario es obligatorio.');
        } else {
            // Validar la existencia del usuario en la base de datos solo si el usuario no está vacío
            $usuarioExistente = $this->model->getUsuario($data['usuario']);
            if ($usuarioExistente) {
                $gestorErrores->AnotaError('usuario', 'El usuario ya existe en la base de datos.');
            }
        }

        // Validar si la clave está vacía o si es demasiado corta
        if (empty($data['clave'])) {
            $gestorErrores->AnotaError('clave', 'La clave no debe estar vacía.');
        }

        // Validar tipo de usuario
        if (!in_array($data['tipo'], ['administrador', 'operario'])) {
            $gestorErrores->AnotaError('tipo', 'El tipo de usuario no es válido.');
        }

        // Si hay errores, devolver la vista con los errores
        // Si hay errores, devolver la vista con los errores y los datos ingresados
        if ($gestorErrores->HayErrores()) {
            return $this->Ver('Lista de Usuarios', view('InsertarUser', [
                'gestorErrores' => $gestorErrores,
                'usuario' => $data['usuario'],
                'clave' => $data['clave'],
                'tipo' => $data['tipo']
            ]), 'administrador');
        }

        // Si no hay errores, insertar el usuario
        $this->model->insertarUsuarios($data);

        // Obtener los usuarios paginados después de la inserción
        $pagina = 1;
        $elementosPorPagina = 3;
        $resultados = $this->model->getUsuarios($pagina, $elementosPorPagina);
        $usuarios = $resultados['usuarios'];
        $totalPaginas = $resultados['totalPaginas'];
        $paginaActual = $resultados['paginaActual'];

        // Redirigir a la vista de usuarios
        return $this->Ver('Lista de Usuarios', view('VistaUsuarios', [
            'gestorErrores' => $gestorErrores,
            'usuarios' => $usuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $paginaActual
        ]), 'administrador');
    }



    public function Alta()
    {
        // En un controlador real esto haría más cosas
        return $this->Ver('Alta', view('alta'));
    }

    public function Insertar()
    {
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        return $this->Ver('Insertar', view('InsertarTareas', [
            'gestorErrores' => $gestorErrores,
            'provincias' => $this->model->getProvincias(),
            'operarios' => $this->model->getOperarios()
        ]), 'administrador');
    }

    public function insertarTarea()
    {
        // Recoger los datos del formulario
        $data = [
            'nif_cif' => $_POST['nif_cif'] ?? '',
            'persona_contacto' => $_POST['persona_contacto'] ?? '',
            'telefono_contacto' => $_POST['telefono_contacto'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'correo_contacto' => $_POST['correo_contacto'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'poblacion' => $_POST['poblacion'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'provincia' => $_POST['provincia'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'operario_encargado' => $_POST['operario_encargado'] ?? '',
            'fecha_realizacion' => $_POST['fecha_realizacion'] ?? '',
            'anotaciones_anteriores' => $_POST['anotaciones_anteriores'] ?? '',
            'anotaciones_posteriores' => $_POST['anotaciones_posteriores'] ?? '',
            'fichero_resumen' => $_FILES['fichero_resumen'] ?? null,
            'fotos_trabajo' => $_FILES['fotos_trabajo'] ?? null
        ];

        // Inicializar GestorErrores
        $gestorErrores = new GestorErrores('<span style="color:red; background:#EEE; padding:.2em 1em; margin:1em">', '</span>');

        // Validación
        if (empty($data['descripcion'])) {
            $gestorErrores->AnotaError('descripcion', 'La descripción es obligatoria.');
        }

        if (empty($data['persona_contacto'])) {
            $gestorErrores->AnotaError('persona_contacto', 'La persona de contacto es obligatoria.');
        }

        // Validación del NIF/CIF (se debe usar una expresión regular)
        if (!preg_match("/^[A-Z0-9]{8}[A-Z]$/", $data['nif_cif'])) {
            $gestorErrores->AnotaError('nif_cif', 'El NIF/CIF no es válido.');
        }

        // Validación del teléfono de contacto (solo números y caracteres de separación)
        if (!empty($data['telefono_contacto']) && !preg_match("/^(\+?\d{1,3}[\s-])?(\(?\d{1,4}\)?[\s-]?)?[\d\s\-]{5,}$/", $data['telefono_contacto'])) {
            $gestorErrores->AnotaError('telefono_contacto', 'El teléfono no tiene un formato válido.');
        }

        // Validación del código postal (debe ser 5 números)
        if (!empty($data['codigo_postal']) && !preg_match("/^\d{5}$/", $data['codigo_postal'])) {
            $gestorErrores->AnotaError('codigo_postal', 'El código postal debe tener 5 números.');
        }

        // Validación del correo electrónico
        if (!filter_var($data['correo_contacto'], FILTER_VALIDATE_EMAIL)) {
            $gestorErrores->AnotaError('correo_contacto', 'El correo electrónico no es válido.');
        }

        // Validación de la fecha de realización (debe ser posterior a la fecha actual)
        if (strtotime($data['fecha_realizacion']) <= time()) {
            $gestorErrores->AnotaError('fecha_realizacion', 'La fecha de realización debe ser posterior a la fecha actual.');
        }

        // Si hay errores, redirigir con los datos previos
        if ($gestorErrores->HayErrores()) {
            // Obtener los operarios y provincias
            $operarios = $this->model->getOperarios();
            $provincias = $this->model->getProvincias();

            // Mostrar la vista con errores y valores anteriores
            return $this->Ver('Insertar', view('InsertarTareas', [
                'gestorErrores' => $gestorErrores,
                'data' => $data,
                'provincias' => $provincias,
                'operarios' => $operarios
            ]), 'administrador');
        }

        // Si no hay errores, llamar al modelo para insertar la tarea
        $insertado = $this->model->insertarDatos($data);

        if ($insertado) {
            // Redirigir a la vista de tareas o mostrar un mensaje de éxito
            return $this->Ver('Insertar', view('InsertarTareas', [
                'gestorErrores' => $gestorErrores,
                'provincias' => $this->model->getProvincias(),
                'operarios' => $this->model->getOperarios()
            ]), 'administrador');
        } else {
            // Si no se pudo insertar, redirigir a la vista con un mensaje de error
            return $this->Ver('Insertar', view('InsertarTareas', [
                'provincias' => $this->model->getProvincias(),
                'operarios' => $this->model->getOperarios()
            ]), 'administrador');
        }
    }



    public function Edit()
    {
        if (!isset($_GET['id'])) {
            // No existe la tarea, error
            return $this->Ver(
                'Error en edición',
                view('edit_error', array(
                    'descripcion_error' => 'No existe la tarea seleccionada'
                ))
            );
            return;
        }

        // Han indicado el id
        $id = $_GET['id'];


        if (!$_POST) {
            // Primera vez.
            // Leo el regitro y muestro los datos
            $tarea = $this->model->GetTarea($id);
            if (!$tarea) {
                // No existe la tarea, error
                return $this->Ver(
                    'Error en edición',
                    view('edit_error', array(
                        'descripcion_error' => 'No existe la tarea seleccionada'
                    ))
                );
                return;
            } else {
                // Mostramos los datos
                return $this->Ver(
                    'Edición',
                    view('edit', array(
                        'operacion' => 'Edición',
                        'tarea' => $tarea,
                        'errores' => $this->errores
                    ))
                );
            }
        } else {
            // Filtrar datos
            $this->FiltraCamposPost();

            // Creamos el objeto tarea que es el que se utiliza en el formulario
            // Lo creamos a partir de los datos recibidos del POST
            $tarea = array(
                'nombre' => VPost('nombre'),
                'prioridad' => VPost('prioridad')
            );

            if ($this->errores->HayErrores()) {
                // Mostrar ventana de nuevo
                return $this->Ver('Edición', view('edit', array(
                    'operacion' => 'Edición',
                    'tarea' => $tarea,
                    'errores' => $this->errores
                )));
            } else {
                // Guardamos la tarea
                $this->model->Update($id, $tarea);
                return $this->Ver('Edición', "<p>Se ha guardado la tarea ....</p>");
            }

        }
    }

    /**
     * Añade una nueva tarea
     * @return type
     */
    public function Add()
    {
        if (!$_POST) {
            // Primera vez.
            $tarea = array(
                'nombre' => '',
                'prioridad' => ''
            );
        } else {
            // Filtrar datos
            $this->FiltraCamposPost();

            // Creamos el objeto tarea que es el que se utiliza en el formulario
            // Lo creamos a partir de los datos recibidos del POST
            $tarea = array(
                'nombre' => VPost('nombre'),
                'prioridad' => VPost('prioridad')
            );

            if (!$this->errores->HayErrores()) {
                // Guardamos la tarea y finalizamos
                $this->model->Add($tarea);
                return $this->Ver('Insertar', "<p>Se ha guardado la tarea ....</p>");
                return;
            }
        }
        // Mostramos los datos
        return $this->Ver(
            'Añadir',
            view('edit', array(
                'operacion' => 'Insertar',
                'tarea' => $tarea,
                'errores' => $this->errores
            ))
        );

    }

    /**
     * Muestra el resultado del controlador dentro de la plantilla
     * @param type $html
     */
    public function Ver($titulo, $html, $tipouser)
    {

        if ($tipouser == 'administrador') {


            return view('plantilla/layout', array(
                'titulo' => $titulo,
                'menu' => view('plantilla/menu')->render(),
                'cuerpo' => $html,
            ));
        } else if ($tipouser == 'operario') {
            return view('plantilla/layout', array(
                'titulo' => $titulo,
                'menu' => view('plantilla/menuuser')->render(),
                'cuerpo' => $html,
            ));
        } else if ($tipouser == '') {

            return view('plantilla/layout', array(
                'titulo' => $titulo,
                'menu' => view('plantilla/menuuser')->render(),
                'cuerpo' => $html,
            ));

        }


    }
    /**
     * Realiza el filtrado de campos y almacena los errores en el gestor de errores
     * @param GestorErrores $this->errores
     */
    function FiltraCamposPost()
    {
        // Filtramos el nombre
        if (VPost('nombre') == '') {
            $this->errores->AnotaError('nombre', 'Se debe introducir texto');
        } else if (strlen(VPost('nombre')) < 5) {
            $this->errores->AnotaError('nombre', 'El nombre debe tener al menos 5 letras');
        }

        // Filtramos la prioridad
        $prioridad = VPost('prioridad');
        if ($prioridad == '') {
            $this->errores->AnotaError('prioridad', 'Se debe introducir texto');
        } else if (!is_numeric($prioridad) || ($prioridad < 1 || $prioridad > 5)) {
            $this->errores->AnotaError('prioridad', 'La prioridad debe ser un número entre 1 y 5');
        }
    }
}
