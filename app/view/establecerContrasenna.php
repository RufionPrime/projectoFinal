<?php
$error = "Contraseña restablecida con éxito";
?>
<div class="form-container">
    <h2>Establecer nueva contraseña</h2>
    <div class="contenedor-estrecho">
        <form action="#" method="POST">

            <label for="nueva_contrasena">Nueva Contraseña</label>
            <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Nueva Contraseña">

            <label for="confirmar_contrasena">Confirmar Contraseña</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar Contraseña">

            <button type="submit">Restablecer contraseña</button>

        </form>
    </div>
    <div class="mesajesLogin">
        <?= $error ? '<div class="error">' . $error . '</div>' : '' ?>
        <p><a href="#">Volver al inicio de sesión</a></p>
    </div>
</div>