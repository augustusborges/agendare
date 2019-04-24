<?php

    //define('DIRETORIO_PADRAO', '/xampp/htdocs/u415482967/public_html/aplicativos/agenda/diretorio/');

    define('DS', DIRECTORY_SEPARATOR);
    define('BASE_DIR', dirname(__FILE__).DS);

    //define("DB_HOST", "153.92.6.66");
    //define("DB_USER", "u415482967_daab");
    //define("DB_PASS", "Carol0608");
    //define("DB_NAME", "u415482967_teste");
    //define("DB_PORT", "3306");

    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "861748");
    define("DB_NAME", "agenda");
    define("DB_PORT", "3306");

    //Definição de dados para apresentação de erros na tela
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
    error_reporting(E_ERROR);
    error_reporting(E_CORE_ERROR);
    error_reporting(E_COMPILE_ERROR);
    error_reporting(E_USER_ERROR);
    error_reporting(E_RECOVERABLE_ERROR);
    error_reporting(E_STRICT);
    //error_reporting(E_WARNING);

?>