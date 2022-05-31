<?php namespace dao;

use interfaces\crud as CRUD;
use models\EventSeat as ClassEventSeat;
use config\Singleton as Singleton;

use dao\Connection as Connection;
use dao\SeatType as DaoSeatType;
use dao\Calendar as DaoCalendar;


use Exception;   

class EventSeat extends Singleton implements CRUD {

    private $connection;
    private $daoSeatType;
    private $daoCalendar;

    function __construct(){
        $this->daoSeatType = DaoSeatType::GetInstance();
        $this->daoCalendar = DaoCalendar::GetInstance();

    }

    public function create($object) {

        $sql = "INSERT INTO SeatEvents (IdCalendar, TotalAvailables, Price, IdSeatType) VALUES (:idCalendar, :totalAvailables, :price, :idSeatType)";
        
        $parameters['idCalendar'] = $object->getCalendar()->getId();
        
        $parameters['totalAvailables'] = $object->getTotalAvailables(); //id del tipo de plaza

        $parameters['price'] = $object->getPrice(); //id del tipo de plaza

        $parameters['idSeatType'] = $object->getSeatType()->getId(); //id del tipo de plaza

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por id o arreglo de ids

          $sql = "SELECT * FROM SeatEvents WHERE IdSeatEvent = :id";

          $parameters['id'] = $id;
        

        try {
            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql, $parameters);   // arreglo de arreglos con cada objeto

        } catch(Exception $ex) {
            throw $ex;
        }
        if(!empty($resultSet))
            return $this->mapear($resultSet);
        else
            return false;
     }

     public function getByIdCalendar($_id){
        $sql = "SELECT * FROM SeatEvents WHERE IdCalendar = :id";
          
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

    public function update($id, $object){

        $sql = "UPDATE SeatEvents SET  IdCalendar=:idCalendar TotalAvailables=:totalAvailables , Price=:price, IdSeatType=:idSeatType  WHERE IdSeatEvent = $id";

        $parameters['idCalendar'] = $object->getName();
        
        $parameters['totalAvailables'] = $object->getTotalAvailables(); //id del tipo de plaza

        $parameters['price'] = $object->getPrice(); //id del tipo de plaza

        $parameters['idSeatType'] = $object->getSeatType()->getId(); //id del tipo de plaza

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }  //id del evento que se modificara, y el objecto que ingresara en ese id

    public function delete($id){  //recive el id del evento que borrara o arreglo de ids

      if(is_array($id)){
        $sql = "DELETE FROM SeatEvents WHERE IdSeatEvent IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM SeatEvents WHERE IdSeatEvent = $id";
      }

      try {
        $this->connection = Connection::getInstance();
        return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
        throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM SeatEvents";

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
        
            $seatType = $this->daoSeatType->Read($p['IdSeatType']); 
            $calendar = $this->daoCalendar->Read($p['IdCalendar']);
            return new ClassEventSeat($calendar[0], $seatType[0], $p['TotalAvailables'], $p['Price'], $p['IdSeatEvent']); // category[0](es un arreglo)
        
        }, $value);   // $value es cada array q quiero convertir a objeto
        
        return count($resp) >= 1 ? $resp : $resp[0];
    }      
    
}         