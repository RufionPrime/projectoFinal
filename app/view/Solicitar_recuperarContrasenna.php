 <?php
    $error = "Correo enviado con éxito";
    ?>
 <div class="form-container">
     <h2>Solicitud de recuperación de contraseña</h2>
     <div class="contenedor-estrecho">
         <form action="procesar_recuperacion.php" method="POST">
             <label for="email">Introduce tu correo electrónico</label>
             <input type="email" id="email" name="email" placeholder="Dirección de correo">
             <button type="submit">Enviar solicitud</button>
         </form>
     </div>
     <div class="mesajesLogin">
         <?= $error ? '<div class="error">' . $error . '</div>' : '' ?>
         <p>Revisa tu correo para recuperar tu contraseña.</p>
         <p><a href="#">Volver al inicio de sesión</a></p>
     </div>
 </div>