<?php
class RegistroController
{
    public function index($error = "")
    {
        include 'app/view/header.php';
        require 'app/view/registro.php';
        include 'app/view/footer.php';
    }

    public function registrar()
    {
        $error = [];
        //miramos que haya contenido en los campos obligatorios
        if (
            !empty($_POST['nombre']) && !empty($_POST['apellidos'] && !empty($_POST['email']) && !empty($_POST['nif'])) && !empty($_POST['fecha'])
            && !empty($_POST['password']) && !empty($_POST['password2'])
        ) {
           $error = ValidacionesDatos::ValidarTodosDatos($_POST);
            if (!empty($error)) {
                RegistroController::index($error);
            } else {
                $fecha=new DateTime();
                $fechaCreado=$fecha->format('Y-m-d H:i:s');
                $fecha->modify('+1 day');
                $datos = [
                    'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS),
                    'apellidos' => filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS),
                    'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
                    'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS),
                    'nif' => filter_input(INPUT_POST, 'nif', FILTER_SANITIZE_SPECIAL_CHARS),
                    'fechaNacimiento' => filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS),
                    'rol' => filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_SPECIAL_CHARS),
                    'hash' => Usuario::hashContrasena(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS)),
                    'imagen' => isset($_FILES['imagen']['name']) && !empty($_FILES['imagen']['name']) ? strtolower($_POST['nombre'] . ".png") : 'avatar_default.png',
                    'token'=> Usuario::generarToken(),
                    'fechaExpira'=> $fecha->format('Y-m-d H:i:s'),
                    'fechaCreacion'=>$fechaCreado
                ];
                Usuario::registrarUsuarioNuevo($datos);
                EnviarCorreo::enviarCorreo($datos['email'],$datos['token']);
                if($datos['imagen']!="avatar_default.png"){
                    $archivoTemporal = $_FILES['imagen']['tmp_name'];
                    $rutaDestino= Config::$rutaAvatar;
                    move_uploaded_file($archivoTemporal, $rutaDestino. "/".$datos['imagen'] );
                }
            }
        } else {
            RegistroController::index();
        }
    }
    public  function validar(){
        ValidacionesDatos::confirmarCorreo($_GET['correo'],$_GET['token']);
    }
}
