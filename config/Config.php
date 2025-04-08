<?php
class Config
{
    const HOST = 'localhost';
    const DATABASE  = 'registro';
    const USERNAME = 'root';
    const PASSWORD = '';
    const CHARSET = 'utf8mb4';
    const PORT = '3306';

    // const HOST = '143.47.39.127';
    // const DATABASE  = 'pabloms_db';
    // const USERNAME = 'pabloms';
    // const PASSWORD = '8fGaMHMGmg5V';
    // const CHARSET = 'utf8mb4';
    // const PORT = '9906';
    
    const LOGFILE = 'miFicheroErrores.log';
    const ARTICULOS_POR_PAGINA=2;
    const ELEMENTOS_POR_PAGINA = 2;

    static public $estilo = 'assets/css/conciertos.css';
    static public $rutaImg = 'assets/img/';
    static public $rutaAvatar = 'uploads/img/avatar/';
    static public $rutaGrupos = 'uploads/grupos/';
    static public $tamannoImagen = 2 * 1024 * 1024; // 2 megas en bytes

    private static $url = NULL;
    public static function getUrl()
    {
        return self::$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . self::LOGFILE;
    }
}
