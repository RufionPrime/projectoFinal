<?php
class ValidacionesDatos
{

    public static function validarEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validarTelefono($telefono)
    {
        // Añadimos delimitadores (por ejemplo, '/')
        $patron = '/^[0-9]{9}$/'; // Expresión regular para 9 dígitos numéricos
        if (preg_match($patron, $telefono)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validarDNI($nif)
    {
        if (strlen($nif) == 9) {
            $numero = intval(substr($nif, 0, 8));
            $letra = substr($nif, 8, 1);
            $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
            $arrayLetras = str_split($letras);
            $posicion = $numero % 23;
            $letraCom = $letras[$posicion];
            if ($letra == $letraCom) {
                return true;
            } else {
                return false;
            }
        } else if (strlen($nif) == 10) {
            $extrangero = substr($nif, 0, 1);
            $numeroEx = 0;
            if ($extrangero == "X") {
                $numeroEx = 0;
            } elseif ($extrangero == "Y") {
                $numeroEx = 1;
            } elseif ($extrangero == "Z") {
                $numeroEx = 2;
            }
            $numero = intval(substr($nif, 1, 8));
            $numero = intval($numeroEx . $numero);
            $letra = substr($nif, 9, 1);
            $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
            $arrayLetras = str_split($letras);
            $posicion = $numero % 23;
            $letraCom = $letras[$posicion];
            if ($letra == $letraCom) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public static function validarFechaNacimiento($fecha)
    {
        $fechaNacimiento = strtotime($fecha);
        $edad = (int) ((time() - $fechaNacimiento) / (365.25 * 24 * 60 * 60));
        if ($edad >= 16) {
            return true;
        } else {
            return false;
        }
    }

    public static function validarContrasena($contrasena, $contrasena2)
    {
        $regex = '/^(?=.*[A-Z])(?=.*[a-z]).{8,}$/';
        return preg_match($regex, $contrasena) && preg_match($regex, $contrasena2) ? true : false;
    }

    public function subirImagen($imagen, $nombre)
    {
        // Verifica si se ha subido un archivo
        if (!empty($imagen['imagen']['tmp_name'])) {
            $tamañoLimite = 3145728; // 3 MB
            $mime = mime_content_type($imagen['imagen']['tmp_name']);
            $tiposMIME = ['image/jpg', 'image/png', 'image/jpeg'];
            $rutaMover = Config::$rutaAvatar . $nombre . ".png";
            // Comprueba el tipo MIME del archivo
            if (in_array($mime, $tiposMIME)) {
                // Verifica el tamaño del archivo
                if (filesize($imagen['imagen']['tmp_name']) <= $tamañoLimite) {
                    // Mueve el archivo a la ubicación deseada
                    move_uploaded_file($imagen['imagen']['tmp_name'], $rutaMover);
                    return "assets/images/" . $nombre . ".png";
                } else {
                    // echo "El archivo es demasiado grande. El tamaño máximo permitido es 3 MB.";
                    return false;
                }
            } else {
                // echo "Tipo de archivo no permitido. Solo se permiten JPG y PNG.";
                return false;
            }
        } else {
        }
    }
    public static function ValidarTodosDatos($array)
    {
        $error = [];
        $nombre = $array['nombre'] ?? '';
        $apellidos = $array['apellidos'] ?? '';
        $email = $array['email'] ?? '';
        $telefono = $array['telefono'] ?? '';
        $nif = $array['nif'] ?? '';
        $fecha = $array['fecha'] ?? '';
        $imagen = $array['imagen'] ?? '';
        $rol = $array['rol'] ?? '';
        $password = $array['password'] ?? '';
        $password2 = $array['password2'] ?? '';

        if (!ValidacionesDatos::validarEmail($email)) {
            array_push($error, "El email tiene un formato invalido");
        }
        if (Usuario::usuarioConfirmado($email)) {
            array_push($error, "El email ya existe en la base de datos");
        }
        if (!ValidacionesDatos::validarTelefono($telefono)) {
            array_push($error, "El telefono no es valido");
        }
        if (!ValidacionesDatos::validarDNI($nif)) {
            array_push($error, "El dni no es valido");
        }
        if (!ValidacionesDatos::validarFechaNacimiento($fecha)) {
            array_push($error, "La edad tiene que ser mayor a 16 años");
        }
        if (ValidacionesDatos::validarContrasena($password, $password2)) {
            array_push($error, "La contraseña no es valida");
        }
        if (!empty($_FILES['imagen']['name'])) {
            if (!self::validarImagen($_FILES['imagen'])) {
                array_push($error, "La imagen no tiene el formato correcto");
            }
        }
        if (Usuario::usuarioExiste($email)) {
            array_push($error, "El email ya esta registrado");
        }
        if (Usuario::dniExiste($nif)) {
            array_push($error, "El dni ya esta registrado");
        }

        if ($password != $password2) {
            array_push($error, "La contraseña no es la misma");
        }
        return $error;
    }
    public static function validarImagen($imagen, $tamanoMaximo = 2097152, $formatosPermitidos = ['image/jpeg', 'image/png', 'image/jpg'])
    {
        if (isset($imagen) && $imagen['error'] === UPLOAD_ERR_OK) { // Verifica que el archivo exista y no haya errores
            if ($imagen['size'] <= $tamanoMaximo) { // Verifica el tamaño
                $mime = mime_content_type($imagen['tmp_name']);
                if (in_array($mime, $formatosPermitidos)) { // Verifica el formato
                    return true;
                }
            }
        }
        return false; // Alguna validación falló
    }

    public static function validarDatosConciertos($datos) {}

    public static function confirmarToken($correo, $token)
    {
        try {
            $sql = "SELECT  `token`, `token_expira_a` FROM `usuarios` WHERE email= ? ";
            $instancia = Usuario::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $fecha = date('Y-m-d H:i:s');
            //validar el token 
            if (hash_equals($token, $usuario['token']) && $fecha < $usuario['token_expira_a']) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }


    public static function confirmarCuenta($correo)
    {
        try {
            $sql = "UPDATE `usuarios` SET `confirmado`= 1, `token`= NULL, `token_expira_a`= NULL WHERE email = ?";
            $instancia = Usuario::obtenerInstancia();
            $conexion = $instancia->obtenerConexion();
            $usuario = $conexion->prepare($sql);
            $usuario->execute([$correo]);

            // Verificar si se actualizó alguna fila
            if ($usuario->rowCount() > 0) {
                echo "Usuario actualizado correctamente.";
            } else {
                echo "No se encontró el usuario o no hubo cambios.";
            }
        } catch (PDOException $e) {
            echo "Se ha producido un error: " . $e->getMessage();
            include_once 'app/view/errorBD.php';
        }
    }

    public static function confirmarCorreo($correo, $token)
    {
        if (ValidacionesDatos::confirmarToken($correo, $token)) {
            ValidacionesDatos::confirmarCuenta($correo);
            $inicio = new SessionController;
            $inicio->index();
        } else {
            $inicio = new SessionController;
            $inicio->index();
        }
    }
}
