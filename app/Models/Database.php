<?php

namespace App\Models;

use PDO;
use PDOException;

// Incluir el archivo de configuración para usar las constantes
require_once realpath(__DIR__.'/../../config.php');

class Database
{
    private $pdo;
    protected $table = 'tareas';
    private static $instance = null;

    // Constructor privado para evitar instanciación directa
    public function __construct()
    {
        try {
            $host = DB_HOST;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASSWORD;
            $charset = 'utf8';

            $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    // Método estático para obtener la instancia (patrón Singleton)
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Método para obtener la conexión PDO
    public function getConnection()
    {
        return $this->pdo;
    }

    // Consultas relacionadas con usuarios
    public function getUserByUsername($username)
    {
        $db = $this->getConnection();
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usuario', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getTypeByUser($username)
    {
        $db = $this->getConnection();
        $sql = "SELECT tipo FROM usuarios WHERE usuario = :username";
        $stmt = $db->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarUser($usuario)
    {
        $db = $this->getConnection();
        $sql = "DELETE FROM usuarios WHERE usuario = :usuario";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertarUsuarios($data)
    {
        $pdo = $this->getConnection();
        $sql = "INSERT INTO usuarios (usuario, clave, tipo) VALUES (:usuario, :clave, :tipo)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':usuario', $data['usuario']);
        $stmt->bindValue(':clave', $data['clave']);
        $stmt->bindValue(':tipo', $data['tipo']);
        return $stmt->execute();
    }

    public function actualizarClave($usuario)
    {
        $pdo = $this->getConnection();
        $sql = 'UPDATE usuarios SET clave = :nueva_clave WHERE usuario = :usuario';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nueva_clave' => $_POST['nueva_clave'],
            'usuario' => $usuario
        ]);
    }

    public function getTareasPendientes($pagina = 1, $elementosPorPagina = 3)
    {
        $db = $this->getConnection(); 
        try {
            // Calcular el offset para la paginación
            $offset = ($pagina - 1) * $elementosPorPagina;
            
            // Consulta para obtener las tareas con estado 'P' en la columna 'tipo'
            $sql = "SELECT * FROM tareas WHERE estado = 'P' LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
    
            // Obtener las tareas
            $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Contar el total de tareas pendientes
            $sqlCount = "SELECT COUNT(*) FROM tareas WHERE estado = 'P'";  
            $stmtCount = $db->prepare($sqlCount);
            $stmtCount->execute();
            $totalRegistros = $stmtCount->fetchColumn();
            
            // Calcular el total de páginas
            $totalPaginas = ceil($totalRegistros / $elementosPorPagina);
    
            // Siempre retornar un arreglo con la clave 'tareas'
            return [
                'tareas' => $tareas,
                'totalRegistros' => $totalRegistros,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ];
    
        } catch (PDOException $e) {
            // Manejo de errores, retorna un arreglo vacío en caso de error
            return [
                'tareas' => [],
                'totalRegistros' => 0,
                'paginaActual' => $pagina,
                'totalPaginas' => 1
            ];
        }
    }
    
    // Consultas relacionadas con tareas
    public function getTareas($pagina = 1, $elementosPorPagina = 5)
    {
        $db = $this->getConnection(); 
        try {
            $offset = ($pagina - 1) * $elementosPorPagina;
            $sql = "SELECT * FROM tareas LIMIT :limit OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sqlCount = "SELECT COUNT(*) FROM tareas";  
            $stmtCount = $db->prepare($sqlCount);
            $stmtCount->execute();
            $totalRegistros = $stmtCount->fetchColumn();
            $totalPaginas = ceil($totalRegistros / $elementosPorPagina);

            return [
                'tareas' => $tareas,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'totalRegistros' => $totalRegistros
            ];
            
        } catch (PDOException $e) {
            echo "Error en la consulta SQL: " . $e->getMessage();
            return [];
        }
    }

    public function getTarea($id)
    {
        $pdo = $this->getConnection(); 
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function EliminarTareas($id)
    {
        $db = $this->getConnection();
        $sql = "DELETE FROM tareas WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function obtenerTareaPorId($id)
    {
        $db = $this->getConnection();
        $sql = "SELECT * FROM tareas WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarTareaPendiente($id, $data)
{
    // Obtener la conexión a la base de datos
    $db = $this->getConnection();
    
    try {
        // Consulta SQL para actualizar la tarea
        $sql = "UPDATE tareas SET
                    estado = :estado,
                    anotaciones_anteriores = :anotaciones_anteriores,
                    anotaciones_posteriores = :anotaciones_posteriores
                WHERE id = :id";

        // Preparar la consulta SQL
        $stmt = $db->prepare($sql);

        // Vincular los parámetros con los valores de los datos
        $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':anotaciones_anteriores', $data['anotaciones_anteriores'], PDO::PARAM_STR);
        $stmt->bindParam(':anotaciones_posteriores', $data['anotaciones_posteriores'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // Vincular el id de la tarea

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se actualizó algún registro (esto devolverá la cantidad de filas afectadas)
        return $stmt->rowCount() > 0;  // Retorna true si se actualizó la tarea, false en caso contrario

    } catch (PDOException $e) {
        // Si ocurre un error en la consulta SQL, se captura y se muestra
        echo "Error al actualizar la tarea: " . $e->getMessage();
        return false;
    }
}
    public function actualizarTarea($id, $data)
    {
        $pdo = $this->getConnection();
        $sql = "UPDATE " . $this->table . " SET 
                nif_cif = :nif_cif,
                persona_contacto = :persona_contacto,
                telefono_contacto = :telefono_contacto,
                descripcion = :descripcion,
                correo_contacto = :correo_contacto,
                direccion = :direccion,
                poblacion = :poblacion,
                codigo_postal = :codigo_postal,
                provincia = :provincia,
                estado = :estado,
                fecha_creacion = :fecha_creacion,
                operario_encargado = :operario_encargado,
                fecha_realizacion = :fecha_realizacion,
                anotaciones_anteriores = :anotaciones_anteriores,
                anotaciones_posteriores = :anotaciones_posteriores,
                fichero_resumen = :fichero_resumen,
                fotos = :fotos
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function insertarDatos($data)
    {
        $pdo = $this->getConnection();
        $sql = "INSERT INTO tareas (
                nif_cif, persona_contacto, telefono_contacto, descripcion, 
                correo_contacto, direccion, poblacion, codigo_postal, 
                provincia, estado, fecha_creacion, operario_encargado, 
                fecha_realizacion, anotaciones_anteriores, anotaciones_posteriores, 
                fichero_resumen, fotos
            ) 
            VALUES (
                :nif_cif, :persona_contacto, :telefono_contacto, :descripcion, 
                :correo_contacto, :direccion, :poblacion, :codigo_postal, 
                :provincia, :estado, :fecha_creacion, :operario_encargado, 
                :fecha_realizacion, :anotaciones_anteriores, :anotaciones_posteriores, 
                :fichero_resumen, :fotos
            )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nif_cif', $data['nif_cif']);
        $stmt->bindValue(':persona_contacto', $data['persona_contacto']);
        $stmt->bindValue(':telefono_contacto', $data['telefono_contacto']);
        $stmt->bindValue(':descripcion', $data['descripcion']);
        $stmt->bindValue(':correo_contacto', $data['correo_contacto']);
        $stmt->bindValue(':direccion', $data['direccion']);
        $stmt->bindValue(':poblacion', $data['poblacion']);
        $stmt->bindValue(':codigo_postal', $data['codigo_postal']);
        $stmt->bindValue(':provincia', $data['provincia']);
        $stmt->bindValue(':estado', $data['estado']);
        $stmt->bindValue(':fecha_creacion', date('Y-m-d H:i:s'));
        $stmt->bindValue(':operario_encargado', $data['operario_encargado']);
        $stmt->bindValue(':fecha_realizacion', $data['fecha_realizacion']);
        $stmt->bindValue(':anotaciones_anteriores', $data['anotaciones_anteriores']);
        $stmt->bindValue(':anotaciones_posteriores', $data['anotaciones_posteriores']);
        $stmt->bindValue(':fichero_resumen', $_FILES['fichero_resumen']['name'] ?? '');
        $stmt->bindValue(':fotos', $_FILES['fotos']['name'] ?? '');
        
        return $stmt->execute();
    }

    // Consultas generales
    public function getOperarios()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT usuario FROM usuarios WHERE tipo = 'operario'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProvincias()
    {
        $pdo = $this->getConnection();
        $sql = "SELECT nombre FROM tbl_provincias";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuarios($pagina = 1, $elementosPorPagina = 2)
    {
        $db = $this->getConnection(); 
        try {
            $offset = ($pagina - 1) * $elementosPorPagina;
            $sql = "SELECT * FROM usuarios LIMIT :limit OFFSET :offset";  
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':limit', $elementosPorPagina, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $sqlCount = "SELECT COUNT(*) FROM usuarios";  
            $stmtCount = $db->prepare($sqlCount);
            $stmtCount->execute();
            $totalRegistros = $stmtCount->fetchColumn();
            $totalPaginas = ceil($totalRegistros / $elementosPorPagina);

            return [
                'usuarios' => $usuarios,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'totalRegistros' => $totalRegistros
            ];
            
        } catch (PDOException $e) {
            echo "Error en la consulta SQL: " . $e->getMessage();
            return [];
        }
    }
}
?>
