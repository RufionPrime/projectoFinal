<div class="form-container">
    <h2>Regístrate</h2>
    <form action="?controlador=registro&accion=registrar" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Datos personales</legend>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono">
            <label for="nif">NIF/NIE</label>
            <input type="text" id="nif" name="nif">
            <label for="fecha">Fecha de nacimiento</label>
            <input type="date" id="fecha" name="fecha">
        </fieldset>

        <div class="right-column">
            <fieldset id="imagen-rol">
                <legend>Imagen y rol</legend>
                <label for="imagen">Imagen de perfil</label>
                <input type="file" id="imagen" name="imagen">
                <label for="rol">Rol deseado</label>
                <select id="rol" name="rol">
                    <option value="cliente">Cliente</option>
                    <option value="promotor">Promotor</option>
                </select>
            </fieldset>

            <fieldset id="contraseña">
                <legend>Contraseña</legend>
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password">
                <label for="password2">Repetir Contraseña</label>
                <input type="password" id="password2" name="password2">
            </fieldset>
        </div>

        <button type="submit">Registrar</button>
    </form>

    <?php
    if (!empty($error)) {
        if (is_array($error)) {
    ?>
            <div class="error">
        <?php
            foreach ($error as $e) {
                echo "$e.</br>";
            }
        }
    }
        ?>
            </div>

</div>