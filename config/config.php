<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");   // raiz del proyecto definido como ROOT

	
// Cambiar Valor del FRONT_ROOT por el Root Directory de su propio Proyecto
define("FRONT_ROOT", "/TP_FINAL_V3.2/");   
define("VIEWS_PATH", "views/");
define("CSS_PATH", FRONT_ROOT. "assets/css/");
define("JS_PATH", FRONT_ROOT. "assets/js/");
define("IMG_PATH", FRONT_ROOT. "assets/img/");


/* DATABASE */
define('DB_HOST', 'localhost');   // url o servidor
define('DB_NAME', 'tp');    // nombre de la base de datos
define('DB_USER', 'root');
define('DB_PASS', '');
