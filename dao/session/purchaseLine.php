<?php namespace dao\session;

use interfaces\crud as CRUD;
use session\Session;
use config\Singleton as Singleton;

use Exception;   // ?

class PurchaseLine extends Singleton implements CRUD {

    private $purchasesLines;


		function __construct(){

        Session::start();
            
		if (isset($_SESSION['purchasesLines'])) {		
            $this->purchasesLines = $_SESSION['purchasesLines'];	
                
		}	else{
            $this->purchasesLines = array();
		}
	}

    public function create($newPurchaseLine) {

        try {
			
			//$this->validateArtist($newArtist);
            if (!empty($this->purchasesLines)){
                
                $newPurchaseLine->setId(end($this->purchasesLines)->getId()+1);
            }else 
                $newPurchaseLine->setId(1);

			array_push($this->purchasesLines, $newPurchaseLine);


		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
            
			$_SESSION['purchasesLines'] = $this->purchasesLines;
		

		}

    }

    public function read($id) { //busca por id o por arreglo de ids

        if (!empty($this->purchasesLines)){

            foreach ($this->purchasesLines as $key => $value) {

                if($value->getId() == $id){

                    return $value;
                }
            }
        }
        
     }


    public function update($id, $object){

        try{
			
			$position= $this->getIdPosition($id);      // posicion en el arreglo del id que quiero modificar

			$this->purchasesLines[$position]->setEventSeat($object->getEventSeat());
            $this->purchasesLines[$position]->setQuantity($object->getQuantity());
            $this->purchasesLines[$position]->setTotal($object->getTotal());            
		
		}	catch(Exception $e){
			throw new Exception($e->getMessage());
		
		}	finally{
			$_SESSION['purchasesLines']= $this->purchasesLines;
			
		}

    }

    public function delete($id){

        try {

			$position = $this->getIdPosition($id);
			unset($this->purchasesLines[$position]);

		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		
		}	finally{
            Session::start();
			$_SESSION['purchasesLines']= $this->purchasesLines;
           }
        

    }  // elimina por id o por arreglo de ids

    public function readAll() {
        
        return $this->purchasesLines;
    }

    
    public function validatePurchaseLine($newPurchaseLine){

        if (!empty($this->purchasesLines)) {

            foreach ($this->purchasesLines as $key => $value) {

                if($value->getId() == $newPurchaseLine->getId()){
                
                    throw new Exception("Ya hay una linea de compra cargada con el ID '" . $newPurchaseLine->getId() . "'.");

                }
            }
        }   
    }


    public function getIdPosition($idModif){
    
        foreach ($this->purchasesLines as $key => $value) {

            if ($value->getId() == $idModif) {
                
                return $key;

            }
        }
        throw new Exception("No hay ningun PurchaseLineo con ID '" . $idModif . "'.");
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