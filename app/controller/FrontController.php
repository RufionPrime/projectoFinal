<?php
class FrontController
{
    // Establece un controlador por defecto por si la URL no especifica ninguno o no es válida
    private function cargarControladorDefecto()
    {
        $controlador = new SessionController();
        $controlador->index(); // Método que muestra la página de login
    }

    // Maneja la petición HTTP (URL recibida) y carga el controlador correspondiente o el controlador por defecto si no se específica ninguno
    public function manejarPeticion()
    {
        if (isset($_REQUEST["controlador"])) {
            $this->cargarControlador($_REQUEST["controlador"]);
        } else {
            $this->cargarControladorDefecto();
        }
    }

    // Carga el controlador correspondiente según la URL recibida
    // Si la URL no específica un controlador válido, se carga el controlador por defecto
    public function cargarControlador($nombreControlador)
    {
        $controlador = null;

        switch ($nombreControlador) {
            case "usuario":
                $controlador = new UsuarioController();
                break;
            case "registro":
                $controlador = new RegistroController();
                break;
            case "session":
                $controlador = new SessionController();
                break;
            case "grupos":
                $controlador = new GruposController();
                break;
            case "conciertos":
                $controlador = new ConciertosController();
                break;     
                case "calendario":
                    $controlador = new CalendarioController();
                    break;      
            default:
                $this->cargarControladorDefecto();
                return;
        }

        if (isset($_REQUEST["accion"]) && method_exists($controlador, $_REQUEST["accion"])) {
            $accion = $_REQUEST["accion"];
            $controlador->$accion();
        } else {
            $controlador->index($_REQUEST["accion"] ?? null); // Método por defecto de cada controlador
        }
    }
}
