<?php
//Quitar esta variable cuando se implemente la funcionalidad de login
// $error = "Error en las credenciales";
// $error = NULL;
?>
<div class="login-container">
    <h2>Inicio de sesión</h2>
    <!-- Revisa action de form, si no se especifica se envía a la misma página -->
    <form action="?controlador=session&accion=validarSesion" method="POST">
        <label for="nombre">Introduce el correo</label>
        <input type="email" id="email" name="email" placeholder="Dirección de correo">

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="password" name="contrasena" placeholder="Contraseña">

        <button type="submit">Acceder</button>
        <div class="mesajesLogin">
            <?php if (empty($error)): ?>
                <p>¿No tienes una cuenta? <a href="?controlador=registro&accion=formulario">Regístrate aquí</a></p>
            <?php else: ?>
                <?= $error ? '<div class="error">' . $error . '</div>' : '' ?>
                <p><a href="#">Recupera tu contraseña aquí</a>
                </p>
            <?php endif; ?>
        </div>
    </form>

</div>