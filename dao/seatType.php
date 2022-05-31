<?php namespace dao;

use interfaces\crud as CRUD;
use dao\Connection as Connection;
use models\seatType as TypeSeat;
use config\Singleton as Singleton;

use Exception;   // ?

class SeatType extends Singleton implements CRUD {

    private $connection;

    public function create($object) {

        $sql = "INSERT INTO SeatTypes(SeatTypeName) VALUES (:name)";

        $parameters['name'] = $object->getName();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por un id o por arreglo de ids
        
        if(is_array($id)){
            $sql = "SELECT * FROM SeatTypes where IdSeatType IN (".implode(",",$id).")";
          }else{
            $sql = "SELECT * FROM SeatTypes where IdSeatType = $id";
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

    public function update($id,$object){

        $sql = "UPDATE SeatTypes SET SeatTypeName = :name WHERE IdSeatType = $id";

        $parameters['name'] = $object->getName();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }   //recive el id del objeto que se quiere modificar, y el objecto que se quiere insertar en ese id

    public function delete($id){ // elimina por un id o por muchos

      if(is_array($id)){
        $sql = "DELETE FROM SeatTypes WHERE IdSeatType IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM SeatTypes WHERE IdSeatType = $id";
      }

      try {
          $this->connection = Connection::getInstance();
          $this->connection->executeQuery($sql);
      }catch(\PDOException $ex) {
          throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM SeatTypes";

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
            $a = new TypeSeat($p['SeatTypeName'], $p['IdSeatType']);
           
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }

}
