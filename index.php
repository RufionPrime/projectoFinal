<?php
require_once __DIR__ . '/config/autoloadP.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

 $frontController = new FrontController;
 $frontController->manejarPeticion();

//include 'app/view/header.php';
// include 'app/view/home.php';
// include 'app/view/login.php';
// include 'app/view/registro.php';
// include 'app/view/Solicitar_recuperarContrasenna.php';
// include 'app/view/establecerContrasenna.php';
// include 'app/view/footer.php';
