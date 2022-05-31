<?php namespace dao;

use interfaces\crud as CRUD;
use models\Event as ClassEvent;
use config\Singleton as Singleton;

use dao\Connection as Connection;
use dao\Category as DaoCategory;


use Exception;   

class Event extends Singleton implements CRUD {

    private $connection;
    private $daoCategory;

    function __construct(){
        $this->daoCategory = DaoCategory::GetInstance();

    }

    public function create($object) {

        $sql = "INSERT INTO Events (IdCategory, NameEvent) VALUES (:idCat, :name)";

        $parameters['idCat'] = $object->getCategory()->getId(); //id de la categoria
        $parameters['name'] = $object->getName();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por id o arreglo de ids

        if(is_array($id)){
          $sql = "SELECT * FROM Events WHERE IdEvent IN (".implode(",",$id).")";
        }else{
          $sql = "SELECT * FROM Events WHERE IdEvent = $id";
        }

        try {
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql);   // arreglo de arreglos con cada objeto

        } catch(Exception $ex) {
            throw $ex;
        }
        if(!empty($resultSet))
            return $this->mapear($resultSet);
        else
            return false;
     }

    public function update($id, $object){

        $sql = "UPDATE Events SET IdCategory = :idCat, NameEvent = :nombre WHERE IdEvent = $id";

        $parameters['idCat'] = $object->getCategory()->getId();
        $parameters['nombre'] = $object->getName();
        

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }  //id del evento que se modificara, y el objecto que ingresara en ese id

    public function getByName($name) {
        $sql = "SELECT * FROM Events WHERE NameEvent LIKE :name OR IdCategory LIKE :name";
          
        $parameters['name'] = '%' . $name . '%';
        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }


        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
   }

   public function getByIdCategory($_id) {
    $sql = "SELECT * FROM Events WHERE IdCategory = :id";
      
    $parameters['id'] = $_id;

    try {
         $this->connection = Connection::getInstance();
         $resultSet = $this->connection->execute($sql, $parameters);
    } catch(Exception $ex) {
        throw $ex;
    }


    if(!empty($resultSet))
         return $this->mapear($resultSet);
    else
         return false;
}

    public function delete($id){  //recive el id del evento que borrara o arreglo de ids

      if(is_array($id)){
        $sql = "DELETE FROM Events WHERE IdEvent IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Events WHERE IdEvent = $id";
      }

      try {
        $this->connection = Connection::getInstance();
        return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
        throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM Events";

        try {

             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql);

        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
    }

	protected function mapear($value) {   // va reemplazando cada posicion del arreglo (de registros) con el objeto correspondiente
                                    // paso de tener un arreglo de arreglos con registros, a arreglo con arreglos de obj
        $value = is_array($value) ? $value : [];
        $resp = array_map( function($p) {
        
            $category = $this->daoCategory->Read($p['IdCategory']); 
            //var_dump($category[0]); // todos los objetos q leyo de la bd
            return new ClassEvent($category[0], $p['NameEvent'], $p['IdEvent']); // category[0](es un arreglo)
        
        }, $value);   // $value es cada array q quiero convertir a objeto
        
        return count($resp) >= 1 ? $resp : $resp[0];
    }      
    
}                                                                           
                    

