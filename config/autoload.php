<?php namespace config;
	
    class Autoload {
        
        public static function Start() {
            spl_autoload_register(function($className){
                
                //echo 'ESTOY EN EL AUTOLOAD LLEGO:  '.$className.'<br>';

                $classPath = strtolower(str_replace("\\", "/", ROOT.$className).".php"); // ROOT es la RAIZ del proyecto , a partir de ahi concateno con la clase requerida y cammbio las \ por /
                
                //echo 'ESTOY EN EL AUTOLOAD TE DEVUELVO:  '.$classPath.'<br>';

				include_once($classPath);
			});
        }
    }
?>