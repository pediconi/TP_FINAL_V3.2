<?php namespace dao;

use interfaces\crud as CRUD;
use dao\Connection as Connection;
use models\eventLocation as Locations;
use config\Singleton as Singleton;

use Exception;   // ?

class EventLocation extends Singleton implements CRUD {

    private $connection;

    public function create($object) {

        $sql = "INSERT INTO EventsLocations(EventLocationName, EventLocationDescription) VALUES (:name, :description)";

        $parameters['name'] = $object->getName();
        $parameters['description'] = $object->getCapacity();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por un id o por arreglo de ids
        
     
          $sql = "SELECT * FROM EventsLocations where IdEventLocation = :id";
        

        try {
            $this->connection = Connection::getInstance();
            $parameters['id']=$id;
            $resultSet = $this->connection->execute($sql,$parameters);
        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
            return $this->mapear($resultSet);
        else
            return false;
     }

    public function update($id,$object){

        $sql = "UPDATE EventsLocations SET EventLocationName = :name, EventLocationDescription = :description WHERE IdEventLocation = $id";

        $parameters['name'] = $object->getName();
        $parameters['description'] = $object->getCapacity();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }   //recive el id del objeto que se quiere modificar, y el objecto que se quiere insertar en ese id

    public function delete($id){ // elimina por un id o por muchos

      if(is_array($id)){
        $sql = "DELETE FROM EventsLocations WHERE IdEventLocation IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM EventsLocations WHERE IdEventLocation = $id";
      }

      try {
          $this->connection = Connection::getInstance();
          $this->connection->executeQuery($sql);
      }catch(\PDOException $ex) {
          throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM EventsLocations";

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

    protected function mapear($value) {
        $value = is_array($value) ? $value : [];
        $resp = array_map(function($p){
            $a = new Locations($p['EventLocationName'], $p['EventLocationDescription'], $p['IdEventLocation']);
           
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }

}
