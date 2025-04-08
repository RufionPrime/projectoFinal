<?php
class SessionController
{
    public function index()
    {
        include 'app/view/header.php';
        include 'app/view/home.php';
        include 'app/view/footer.php';
    }

    public function login($error = "")
    {
        include 'app/view/header.php';
        include 'app/view/login.php';
        include 'app/view/footer.php';
    }

    private function datosUsuario($usuario)
    {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['sid'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email'];
        $_SESSION['imagen'] = isset($usuario['imagen']) ? Config::$rutaAvatar . $usuario['imagen'] : Config::$rutaImg . 'avartar_default.png';
    }
    public static function logout()
    {
        $_SESSION = [];
        session_destroy();
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        header("Location:index.php");
        exit();
    }

    public static function validarSesion()
    {
        if (!empty($_POST['email']) && !empty($_POST['contrasena'])) {
            if ($datos = Usuario::pedirDatosUsuario($_POST['email'])) {
                if (self::validarContraseña($datos['hashp'], $_POST['contrasena'])) {
                    if (Usuario::usuarioConfirmado($_POST['email'])) {
                        //mostrar el perfil
                        $Se = new SessionController();
                        $Se->datosUsuario($datos);
                         $Se->index($datos['nombre'], $datos['imagen']);
                    } else {
                        $error = "email no validado.Valide su correo";
                        $con = new SessionController();
                        $con->login($error);
                        // EnviarCorreo::enviarCorreo("arceus.morales@gmail.com");
                    }
                } else {
                    $error = "datos no valios";
                    $con = new SessionController();
                    $con->login($error);
                }
            } else {
                $error = "datos no valios";
                $con = new SessionController();
                $con->login($error);
            }
        } else {
            $error = "rellene los campos";
            $con = new SessionController();
            $con->login($error);
        }
    }
    public static function validarContraseña($hash, $contraseña = "")
    {
        if (password_verify($contraseña, $hash)) {
            return true;
        } else {
            return false;
        }
    }



    private function limpiar($input)
    {
        return is_array($input)
            ? array_map([$this, 'limpiar'], $input)
            : (htmlspecialchars(trim(strip_tags($input))) ?? null);
    }
}
