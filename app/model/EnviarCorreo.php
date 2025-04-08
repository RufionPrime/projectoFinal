<?php
//Espacios de nombres
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Cargamos el Composer autoload para poder utilizar las clases
//Poned la ruta correcta a esta carpeta
require 'vendor/autoload.php';

class EnviarCorreo
{
    //Método para enviar un correo
    //Recibe como parámetro la dirección de correo del receptor
    public static function enviarCorreo($receptor,$token)
    {
        //Creamos el contenido del asunto 
        $subject = "Aquí va el asunto del mensaje. Cuídado con las ñ y tíldes";
        //Cuerpo del mensaje       
        $message = self::crearMensaje($receptor,$token);


        try {
            // Creando una nueva instancia de PHPMailer
            $mail = new PHPMailer(true);

            // Indicando el uso de SMTP
            //SMTP –Simple Mail Transfer Protocol, o protocolo simple de transferencia de correo
            //Protocolo básico que permite que los emails viajen a través de internet.
            $mail->isSMTP();

            // Habilitando SMTP debugging
            // 0 = apagado (para producción)
            // 1 = mensajes del cliente
            // 2 = mensajes del cliente y servidor
            $mail->SMTPDebug = 0;

            // Agregando compatibilidad con HTML
            $mail->Debugoutput = 'html';

            // Estableciendo el nombre del servidor de email
            $mail->Host = 'smtp.gmail.com';

            // Estableciendo el puerto
            // Se utilizan los puertos 25 o 587.
            // Gmail utiliza el 587
            $mail->Port = 587;

            // Estableciendo el sistema de encriptación
            $mail->SMTPSecure = 'tls';

            // Para utilizar la autenticación SMTP
            $mail->SMTPAuth = true;

            // Nombre de usuario para la autenticación SMTP - usar dirección de gmail

            //!IMPORTANTE: Colocad aquí vuestra dirección de correo
            $mail->Username = "antonio.mostazo1234@gmail.com";

            // Password para la autenticación SMTP de aplicaciones de GMAIL               
            //TODO: Cambiad la contraseña por la vuestra     
            $mail->Password = "egmfliksdjhvpzot";

            // Estableciendo como quién se va a enviar el mail
            //!IMPORTANTE: Colocad aquí vuestra dirección de correo
            $emisor = 'antonio.mostazo1234@gmail.com';
            $mail->setFrom($emisor);

            //Nombre del emisor que aparece en el mensaje
            $mail->FromName = 'Pepito Grillo';


            // Estableciendo a quién se va a enviar el correo   
            $mail->addAddress($receptor);

            //Establecemos el juego de caracteres 
            //Que se utilizará para enviar el mensaje (tíldes, ñ) 
            $mail->CharSet = 'UTF-8';

            // El asunto del mail
            $mail->Subject = $subject;

            // Estableciendo el mensaje a enviar
            // Cuerpo del mensaje es HTML
            $mail->MsgHTML($message);


            // Adjuntando unos archivos si fuese necesario, hay que colocar la ruta completa al archivo
            // $mail->addAttachment('img/mafalda.png');

            // Tiempo máximo de espera en segundos para establecer una conexión con el servidor SMTP
            // Después de este tiempo, si no conecta con el servidor de correo, se generará un error
            $mail->Timeout = 7;

            // Vaciar el buffer de salida
            ob_end_clean();

            //Esta instrucción envía el mensaje
            //Debemos establecer las condiciones necesarias       
            //El método send devuelve true si el mensaje se ha podido enviar y false en caso contrario
            $mail->send();
            //Este mensaje se mostrará si el correo se ha enviado correctamente
            //Borrarlo, solo para pruebas
            echo <<<HTML
            <div style='text-align: center; margin-top: 20px;'>
                <h2 style='color: green;'>Mensaje enviado correctamente</h2>
                <p><strong>Desde la dirección:</strong></p>
                <p style='color: blue;'>$emisor</p>
                <p><strong>A la dirección:</strong></p>
                <p style='color: blue;'>$receptor</p>
            </div>
HTML;
        } catch (Exception $e) {
            echo "En la línea "  . $e->getLine() . ' en el archivo ' . $e->getFile() . ': <br>';
            echo "<br>Mensaje de error:" . $e->getMessage();
        }
    }

    //Método para generar un enlace de verificación
    public static function generarEnlaceVerificacion($correo,$token)
    {
        // Hashear el correo usando password_hash()
        // $hash_correo = password_hash($correo, PASSWORD_DEFAULT);

        // Generar el enlace con el hash para enviar al usuario, que redirige a index1.php
        $enlaceGenerico = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
        $enlaceConParametros = $enlaceGenerico . '?controlador=registro&accion=validar&correo=' . $correo . '&token=' . $token;

        return $enlaceConParametros;
    }


    //La mayoría de los clientes de correo electrónico solo admiten CSS en línea
    //Por lo que es mejor utilizar tablas en lugar de divs

    public static function crearMensaje($correo,$token)
    {
        //Generamos el enlace de verificación
        $enlace = self::generarEnlaceVerificacion($correo,$token);

        //Creamos el contenido del asunto 
        $subject = "Verificación de correo en nuestra web";
        //Fecha de envío
        $fechaEnvio = date("d-m-Y H:i:s");

        // Cuerpo del mensaje en HTML utilizando heredoc
        $message = <<<HTML
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0;">
            <div style="background-color: #f4f4f9; padding: 20px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; padding: 0;">
                    <tr>
                        <td>
                            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; padding: 20px; border: 1px solid #ddd; margin: 0 auto; display: block;">
                                <tr>
                                    <td style="text-align: center; padding-bottom: 20px;">
                                        <h2 style="color: #28a745; font-size: 24px; margin: 0;">$subject</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                                        <p>Para verificar su correo haga clic en el siguiente enlace:</p>
                                        <p><a href="$enlace" style="color: #007bff; text-decoration: none;">Verificar correo</a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; padding-top: 10px; font-size: 14px; color: #666;">
                                        <p>Enviado el día: $fechaEnvio</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </body>
        </html>
HTML;

        return $message;
    }
}
