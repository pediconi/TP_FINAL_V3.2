<?php namespace dao\session;

use interfaces\crud as CRUD;
use session\Session;
use config\Singleton as Singleton;

use Exception;   // ?

class Event extends Singleton implements CRUD {

    private $events;

		function __construct(){
        
            Session::start();    
            
		if (isset($_SESSION['events'])) {		
            $this->events= $_SESSION['events'];
            		
		}	else{
			$this->events = array();
		}
	}

    public function create($newEvent) {

        try {
			
			//$this->validateArtist($newArtist);
            if (!empty($this->events)){
                $newEvent->setId(end($this->events)->getId()+1);
            }else 
                $newEvent->setId(1);

			array_push($this->events, $newEvent);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['events']= $this->events;
			

		}

    }

    public function read($id) { //busca por id o por arreglo de ids

        if (!empty($this->events)){

            foreach ($this->events as $key => $value) {

                if($value->getId() == $id){

                    return $value;
                }
            }
        }
        
     }


    public function update($id, $object){

        try{
			
			$position= $this->getIdPosition($id);      // posicion en el arreglo del id que quiero modificar

			
            $this->events[$position]->setName($object->getName());
            $this->events[$position]->setCategory($object->getCategory());
		
		}	catch(Exception $e){
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['events']= $this->events;
			
		}

    }

    public function delete($id){

        try {

			$position = $this->getIdPosition($id);
			unset($this->events[$position]);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['events']= $this->events;

		}

    }  // elimina por id o por arreglo de ids

    public function readAll() {
        
        return $this->events;
    }

    
    public function validateEvent($newEvent){

        if (!empty($this->events)) {

            foreach ($this->events as $key => $value) {

                if($value->getId() == $newEvent->getId()){
                
                    throw new Exception("Ya hay un Evento cargado con el ID '" . $newEvent->getId() . "'.");

                }
            }
        }   
    }


    public function getIdPosition($idModif){
    
        foreach ($this->events as $key => $value) {

            if ($value->getId() == $idModif) {
                
                return $key;

            }
        }
        throw new Exception("No hay ningun Evento con ID '" . $idModif . "'.");
    }

    /*public function getByIdCalendar($_id) {
        $sql = "SELECT IdArtist FROM CalendarXArtist WHERE IdCalendar = :id";
          
        $parameters['id'] = $_id;

        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }

        return $resultSet;
   }*/

   
		

}