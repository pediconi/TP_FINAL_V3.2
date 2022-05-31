<?php namespace dao\session;

use interfaces\crud as CRUD;
use session\Session;
use config\Singleton as Singleton;

use Exception;   // ?

class Artist extends Singleton implements CRUD {

    private $artists;
	
		
	function __construct(){
        
        Session::start();
        
		if (isset($_SESSION['artists'])) {		
            $this->artists= $_SESSION['artists'];
            		
		}	else{
			$this->artists = array();
		}
	}

    public function create($newArtist) {

        try {
			
			//$this->validateArtist($newArtist);
            if (!empty($this->artists)){
                $newArtist->setId(end($this->artists)->getId()+1);
            }else 
                $newArtist->setId(1);

			array_push($this->artists, $newArtist);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['artists']= $this->artists;
			

		}

    }

    public function read($id) { //busca por id o por arreglo de ids

        if (!empty($this->artists)){

            foreach ($this->artists as $key => $value) {

                if($value->getId() == $id){

                    return $value;
                }
            }
        }
     }


    public function update($id, $object){
        try{	
            $position= $this->getIdPosition($id);      // posicion en el arreglo del id que quiero modificar
            	
            $this->artists[$position]->setName($object->getName());
            $this->artists[$position]->setDescription($object->getDescription());
            $this->artists[$position]->setPhoto($object->getPhoto());
		
		}	catch(Exception $e){
			throw new Exception($e->getMessage());
		}	finally{
			$_SESSION['artists']= $this->artists;
		}

    }

    public function delete($id){

        try {
			$position = $this->getIdPosition($id);
			unset($this->artists[$position]);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}	finally{
			$_SESSION['artists']= $this->artists;
		}

    }  // elimina por id o por arreglo de ids

    public function readAll() {
        return $this->artists;
    }

    
    public function validateArtist($newArtist){
        if (!empty($this->artists)) {
            foreach ($this->artists as $key => $value) {
                if($value->getId() == $newArtist->getId()){              
                    throw new Exception("Ya hay un Producto cargado con el ID '" . $newArtist->getId() . "'.");
                }
            }
        }   
    }


    public function getIdPosition($idModif){   
        foreach ($this->artists as $key => $value) {
            if ($value->getId() == $idModif) {              
                return $key;
            }
        }
        throw new Exception("No hay ningun Producto con ID '" . $idModif . "'.");
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