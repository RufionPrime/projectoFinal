<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/unaGuitarraT2.png" type="image/png" sizes="512x512">
    <title>Conciertos</title>
    <link rel="stylesheet" href="<?= Config::$estilo ?>">
</head>

<body>
    <header>
        <h1 class="header-title">
            <img src="assets/img/unaGuitarraT2.png" alt="Sonidos Cruzados" class="logo">
            <span class="title-part1">Sonidos</span> <span class="title-part2">Cruzados</span>
        </h1>
        <nav>
            <ul>
                <?php if (!isset($_SESSION['sid'])): ?>
                    <li><a href="?controlador=session&accion=login">Login</a></li>
                    <li><a href="?controlador=registro">Registro</a></li>
                <?php elseif ($_SESSION['rol'] == 'cliente'): ?>
                    <li><a href="?controlador=grupos&accion=mostrar">Grupos</a></li>
                    <li><a href="?controlador=calendario&accion=index">Calendario</a></li>
                    <li><a href="#">Entradas</a></li>
                    <li><a href="?controlador=session&accion=logout">Logout</a></li>
                <?php elseif ($_SESSION['rol']== 'promotor'): ?>
                    <li><a href="?controlador=grupos&accion=fRegistroGrupo">Grupos</a></li>
                    <li><a href="?controlador=conciertos&accion=rConciertos">Conciertos</a></li>
                    <li><a href="?controlador=session&accion=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="#">PDF</a></li>
                    <li><a href="#">Géneros</a></li>
                    <li><a href="?controlador=session&accion=logout">Logout</a></li>
                <?php endif; ?>
                <li><a href="?controlador=session&accion=home">Home</a></li>
            </ul>
            <?php if (isset($_SESSION['rol'])): ?>
                <div class="user-info">
                    <img src="<?= $_SESSION['imagen']?>" alt="Avatar" class="avatar">
                    <span><?= $_SESSION['nombre']?>(<?= $_SESSION['rol']; ?>)</span>
                </div>
            <?php endif; ?>
        </nav>
    </header>
    <main>