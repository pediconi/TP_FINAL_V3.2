<?php namespace dao;

use interfaces\crud as CRUD;
use dao\Connection as Connection;
use models\artist as ClassArtist;
use config\Singleton as Singleton;

use Exception;   // ?

class Artist extends Singleton implements CRUD {

    private $connection;

    public function create($object) {

        $sql = "INSERT INTO Artists (NameArtist, DescriptionArtist, PhotoArtist) VALUES (:name, :description, :photo)";

        $parameters['name'] = $object->getName();
        $parameters['description'] = $object->getDescription();
        $parameters['photo'] = $object->getPhoto();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) { //busca por id o por arreglo de ids

        if(is_array($id)){
          $sql = "SELECT * FROM Artists where IdArtist IN (".implode(",",$id).")";
        }else{
          $sql = "SELECT * FROM Artists where IdArtist = $id";
        }

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

    public function update($id, $object){

        $sql = "UPDATE Artists SET NameArtist = :nombre, DescriptionArtist = :descripcion, PhotoArtist = :foto WHERE IdArtist = :id";

        $parameters['nombre'] = $object->getName();
        $parameters['descripcion'] = $object->getDescription();
        $parameters['foto'] = $object->getPhoto();
        $parameters['id'] = $object->getId();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function delete($id){

      if(is_array($id)){
        $sql = "DELETE FROM Artists WHERE IdArtist IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Artists WHERE IdArtist = $id";
      }

      try {
          $this->connection = Connection::getInstance();
          return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
          throw $ex;
      }

    }  // elimina por id o por arreglo de ids

    public function readAll() {

        $sql = "SELECT * FROM Artists";

        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql); // devuelve una array con varios array q representan cada fila de registros
        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
    }

    public function getByIdCalendar($_id) {
        $sql = "SELECT IdArtist FROM CalendarXArtist WHERE IdCalendar = :id";
          
        $parameters['id'] = $_id;

        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }

        return $resultSet;
   }

   public function getByNameArtist($_text) {
    $sql = "SELECT * FROM Artists WHERE NameArtist like :name";
    
    $parameters['name'] = '%' . $_text . '%';

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


   public function getArtistsCalendar() {
    $sql = "SELECT IdArtist FROM CalendarXArtist";

    try {
         $this->connection = Connection::getInstance();
         $resultSet = $this->connection->execute($sql);
    } catch(Exception $ex) {
        throw $ex;
    }

    return $resultSet;
    }

    public function getArtistsIdCalendar($_id) {
        $sql = "SELECT IdArtist FROM CalendarXArtist where IdCalendar = :id";

        $parameters['id'] = $_id;
    
        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }
    
        return $resultSet;
    }

    protected function mapear($value) {

        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){

        return new ClassArtist($p['NameArtist'], $p['DescriptionArtist'], $p['PhotoArtist'], $p['IdArtist'] );

    }, $value);   // $value es cada array q quiero convertir a objeto

            return $resp;

    }

}
