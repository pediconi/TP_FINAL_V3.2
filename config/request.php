<?php 
    namespace config;

    class Request
    {
        private $controller;
        private $method;
        private $parameters = array();
        
        // ESTO ES PARA OBTENER CONTROLADORA(CLASE) METODO Y PARAMETROS QUE LLEGAN EN LA URL Y GUARDARLOS EN LAS VARIABLES DE ARRIBA

        public function __construct()
        {   

            

            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);  // agarra todo a la der de .com/

            $urlArray = explode("/", $url);  // guardo en arreglo la urle separada x las / osea, controller, method y los parametros 
          
            $urlArray = array_filter($urlArray);   // elimina espacios vacios 

            if(empty($urlArray))     
                $this->controller = 'Home';    // controladora x defecto si viene vacio        
            else
                $this->controller = ucwords(array_shift($urlArray));   //guardo la controladora. arrayshift agarra el primer elem del array y lo quita , ucword convierte la primer letra en mayusc 

            if(empty($urlArray))   // aca urlArray ya esta sin el primer elemento  
                $this->method = 'index';   // metodo index x defecto si el array esta vacio
            else
                $this->method = array_shift($urlArray); // si no agarro el metodo que trajo


            $methodRequest = $this->getMethodRequest();   // guardo el metodo si es post o get   
            
            if($methodRequest == 'GET')  
            {
                unset($_GET["url"]);  // quita controladora/metodo dejo las ? clave = valor

                /*Determines if GET is sent with Controller/Method/Value1/ValueN 
                or Controller/Method?Param1=value1&ParamN=valueN format*/
                if(!empty($_GET))  // si no esta vacio quiere decir que tengo algo como Controller/Method?Param1=value1&ParamN=valueN  
                {
                    foreach($_GET as $key => $value)                    
                        array_push($this->parameters, $value);   //agrego los parametros q faltan (los que tienen el formato ?) 
                }
                else
                    $this->parameters = $urlArray; // si no lo guardo derecho xq ya tendria formate de array
            }
            else if ($_POST)
                $this->parameters = $_POST;

               
        }

        private static function getMethodRequest()
        {
            return $_SERVER['REQUEST_METHOD'];
        }            

        public function getController() {
            return $this->controller;
        }

        public function getMethod() {
            return $this->method;
        }

        public function getparameters() {
            return $this->parameters;
        }
    }

?>