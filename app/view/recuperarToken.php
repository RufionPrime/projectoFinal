<?php
//Quitar esta variable cuando se implemente la funcionalidad de recuperar token
//Cambiar el email por el email del usuario que se está recuperando el token
//Cambiar el href del botón por la ruta correcta
$email = "pepito@gmail.com";
?>
<div class="containerToken">
    <h1>El token ha caducado</h1>
    <p>Tu token de validación ya no es válido. Esto puede deberse a que ha expirado o ya ha sido utilizado.</p>
    <p>Si necesitas un nuevo token, puedes generarlo haciendo clic en el botón a continuación.</p>
    <a href="?controlador=recuperarToken&email=<?= urlencode($email) ?>" class="btn">Solicitar nuevo token</a>
</div>