<?php
class UsuarioController
{
    public static function index()
    {
        if (SessionController::validarSesion()) {
            require_once "app/view/header.php";
            require_once "app/view/home.php";
            require_once "app/view/footer.php";
        }
    }
}
