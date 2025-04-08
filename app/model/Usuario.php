<?php
class Usuario
{
    private $conexion;
    private static $instancia;
    private $cursor;

    private function __construct()
    {
        $this->conectar();
    }

    public static function obtenerInstancia()
    {
        return self::$instancia ?? (self::$instancia = new self());
    }

    private function conectar()
    {
        $dsn = "mysql:host=" . Config::HOST . ";dbname=" . Config::DATABASE . ";port=" . Config::PORT . ";charset=" . Config::CHARSET;
        try {
            $this->conexion = new PDO($dsn, Config::USERNAME, Config::PASSWORD);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->manejarError($e);
        }
    }

    public function obtenerConexion()
    {
        return $this->conexion;
    }




    private static function manejarError($e)
    {
        file_exists(Config::LOGFILE) ? unlink(Config::LOGFILE) : null;
        $separador = str_repeat("=", 100) . "\n\n";
        $detallesError = sprintf(
            "%sError: %s\n\nFichero: %s\n\nLinea: %d\n\n%sTrace:\n\n%s",
            $separador,
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $separador,
            print_r($e->getTrace(), true)
        );
        error_log($detallesError, 3, Config::LOGFILE);
        ob_clean();
        include 'app/view/errorBD.php';
        exit();
    }

    public function __destruct()
    {
        isset($this->cursor) ? $this->cursor->closeCursor() : null;
        $this->conexion = null;
    }

    public static function pedirDatosUsuario($correo)
    {
        try {
            $sql = "SELECT * FROM `usuarios` WHERE email=? ";
            $instancia = self::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }
    public static function usuarioConfirmado($correo)
    {
        try {
            $sql = "SELECT * FROM `usuarios` WHERE email=? AND confirmado";
            $instancia = self::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            if ($stmt->fetch(PDO::FETCH_ASSOC)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }
    public static function correoValidado($correo)
    {
        try {
            // Prepara la consulta SQL
            $sql = "UPDATE usuarios SET confirmado = 1, token = NULL WHERE email = :email";
            $instancia = self::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
        } catch (PDOException $e) {
            // Manejo de errores en caso de que falle la consulta
            error_log("Error al actualizar el usuario: " . $e->getMessage());
            return false;
        }
    }
    public static function registrarUsuarioNuevo($datos)
    {
        $sql = "INSERT INTO `usuarios` 
        (`email`, `hashp`, `nombre`, `apellidos`, `imagen`, `token`, `token_expira_a`, `telefono`, `nif_nie`, `fecha_nacimiento`, `rol`, `creado_a`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $instancia = self::obtenerInstancia();
        $conexion = $instancia->obtenerConexion();
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            $datos['email'],
            $datos['hash'],
            $datos['nombre'],
            $datos['apellidos'],
            $datos['imagen'],
            $datos['token'],
            $datos['fechaExpira'],
            $datos['telefono'],
            $datos['nif'],
            $datos['fechaNacimiento'],
            $datos['rol'],
            $datos['fechaCreacion']
        ]);
    }
    
    public static function usuarioExiste($correo)
    {
        try {
            $sql = "SELECT * FROM `usuarios` WHERE email = ?";
            $instancia = self::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Usando if-else para devolver el resultado
            if ($usuario) {
                return true; // El usuario existe
            } else {
                return false; // El usuario no existe
            }
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }
    public static function dniExiste($correo)
    {
        try {
            $sql = "SELECT * FROM `usuarios` WHERE nif_nie = ?";
            $instancia = self::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $dni = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
            if ($dni) {
                return true; 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }
    

    public static  function hashContrasena($contraseña)
    {
        $hash = password_hash($contraseña, PASSWORD_DEFAULT);
        return $hash;
    }
    public static function generarToken()
    {
        return bin2hex(random_bytes(32));
    }
}
