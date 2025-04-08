<?php
spl_autoload_register(function ($clase) {
    $directorios = [
        __DIR__ . '/../app/model/',
        __DIR__ . '/../app/controller/',
        __DIR__ . '/'


    ];
    foreach ($directorios as $directorio) {
        $archivo = $directorio . $clase . '.php';
        if (file_exists($archivo)) {
            require_once $archivo;
            return;
        }
    }
});
