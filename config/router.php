<?php
    namespace config;

    use config\Request as Request;

    class Router
    {
        public static function Route(Request $request)   // le llega un new request x parametro
        {

            $controllerName = $request->getcontroller() .'Controller'; // concateno con "Controller" xq asi se llaman las controladoras en el archivo xxController

            $methodName = $request->getmethod();

            $methodParameters = $request->getparameters();

            $controllerClassName = "controllers\\". $controllerName;    // lo concateno con "controllers" que es la carpeta donde se encuentra la clase controladora solicitada           

            $controller = new $controllerClassName;   // instancio la clase
       
            if(!isset($methodParameters) || empty($methodParameters))       // instancio los metodos
                call_user_func(array($controller, $methodName));
            else
                call_user_func_array(array($controller, $methodName), $methodParameters);


                
        }
    }

?>
