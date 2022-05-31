<?php namespace dao\session;

use interfaces\crud as CRUD;
use session\Session;
use config\Singleton as Singleton;

use Exception;   // ?

class Category extends Singleton implements CRUD {

    private $categories;

		function __construct(){
        
            Session::start();    
            
		    if (isset($_SESSION['categories'])) {		
                $this->categories= $_SESSION['categories'];
            		
		    }else{
			    $this->categories = array();
		    }
	}

    public function create($newCategory) {

        try {
			
			//$this->validateArtist($newArtist);
            if (!empty($this->categories)){
                $newCategory->setId(end($this->categories)->getId()+1);
            }else 
                $newCategory->setId(1);

			array_push($this->categories, $newCategory);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['categories']= $this->categories;
			

		}

    }

    public function read($id) { //busca por id o por arreglo de ids

        if (!empty($this->categories)){

            foreach ($this->categories as $key => $value) {

                if($value->getId() == $id){
                    //var_dump($value);
                    return $value;
                }
            }
        }
        
     }


    public function update($id, $name){

        try{
			
			$position= $this->getIdPosition($id);      // posicion en el arreglo del id que quiero modificar
           
            $this->categories[$position]->setName($name);
		
		}	catch(Exception $e){
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['categories']= $this->categories;
			
		}

    }

    public function delete($id){

        try {

			$position = $this->getIdPosition($id);
			unset($this->categories[$position]);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['categories']= $this->categories;

		}

    }  // elimina por id o por arreglo de ids

    public function readAll() {
        
        return $this->categories;
    }

    
    public function validateEvent($newCategory){

        if (!empty($this->categories)) {

            foreach ($this->categories as $key => $value) {

                if($value->getId() == $newCategory->getId()){
                
                    throw new Exception("Ya hay una categoria cargada con el ID '" . $newCategory->getId() . "'.");

                }
            }
        }   
    }


    public function getIdPosition($idModif){
    
        foreach ($this->categories as $key => $value) {

            if ($value->getId() == $idModif) {
                
                return $key;

            }
        }
        throw new Exception("No hay ningun Categoria con ID '" . $idModif . "'.");
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