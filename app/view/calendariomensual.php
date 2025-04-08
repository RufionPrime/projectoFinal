<div class="cabecera-calendario">
    <a href="?controlador=calendario&accion=index&mes=<?= $mes - 1 ?>&anio=<?= $anio ?>" class="mes-anterior">Mes Anterior</a>
    <h2><?= date('F Y', strtotime("$anio-$mes-01")) ?></h2>
    <a href="?controlador=calendario&accion=index&mes=<?= $mes + 1 ?>&anio=<?= $anio ?>" class="mes-siguiente">Mes Siguiente</a>
</div>

<div class="calendario">
    <div class="dias-semana">
        <?php 
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        foreach ($diasSemana as $dia) {
            echo "<div class='nombre-dia'>$dia</div>";
        }
        ?>
    </div>

    <div class="dias">
        <?php
        // Rellenar días vacíos antes del primer día del mes
        for ($i = 1; $i < $primerDia; $i++) {
            echo "<div class='dia vacio'></div>";
        }

        // Mostrar días del mes con conciertos
        for ($dia = 1; $dia <= $diasEnMes; $dia++) {
            echo "<div class='dia'>";
            echo "<h3>Día $dia</h3>";
            if (isset($conciertos[$dia])) {
                echo "<div class='concierto'><h4>Sala Acústica</h4>{$conciertos[$dia]['Sala Acústica']}</div>";
                echo "<div class='concierto'><h4>Sala Eléctrica</h4>{$conciertos[$dia]['Sala Eléctrica']}</div>";
            } else {
                echo "<div class='concierto'><h4>Sala Acústica</h4>Libre</div>";
                echo "<div class='concierto'><h4>Sala Eléctrica</h4>Libre</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>
