<?php namespace dao;

use interfaces\crud as CRUD;
use models\PurchaseLine as ClassPurchaseLine;
use config\Singleton as Singleton;

use dao\Connection as Connection;
use dao\EventSeat as DaoEventSeat;
use dao\Purchase as DaoPurchase;


use Exception;   

class PurchaseLine extends Singleton implements CRUD {

    private $connection;
    private $daoEventSeat;
    private $daoPurchase;

    function __construct(){
        
        $this->daoEventSeat = DaoEventSeat::GetInstance();
        $this->daoPurchase = DaoPurchase::GetInstance();
    }

    public function create($object) {

        $sql = "INSERT INTO PurchaseLines (IdPurchase, IdSeatEvent, QuantityPurchaseLine, Total) VALUES (:idPurchase, :idSeatEvent, :quantity, :total)";
        
        $parameters['idPurchase'] = $object->getPurchase()->getId(); //id de la categoria
        $parameters['idSeatEvent'] = $object->getEventSeat()->getId(); //id de la categoria
        $parameters['quantity'] = $object->getQuantity();
        $parameters['total'] = $object->getTotal();

        try {

        $this->connection = Connection::getInstance();

        $this->connection->ExecuteQuery($sql, $parameters);

        $pdo = $this->connection->getPdo();
        return $pdo->lastInsertId();

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por id o arreglo de ids

        if(is_array($id)){
          $sql = "SELECT * FROM PurchaseLines WHERE IdPurchaseLine IN (".implode(",",':id').")";
        }else{
          $sql = "SELECT * FROM PurchaseLines WHERE IdPurchaseLine = :id";
        }

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

    public function update($id, $object){

        $sql = "UPDATE PurchaseLines SET IdPurchase = :idPurchase, IdSeatEvent = :idEventSeat, QuantityPurchaseLine = :quantity, Total =: total  
                WHERE IdPurchaseLine = $id";

        $parameters['IdPurchase'] = $object->getPurchase()->getId(); //id de la categoria
        $parameters['idSeatEvent'] = $object->getEventSeat()->getId(); //id de la categoria
        $parameters['quantity'] = $object->getQuantity();
        $parameters['total'] = $object->getTotal();
        

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }  //id del EventSeato que se modificara, y el objecto que ingresara en ese id


    public function delete($id){  //recive el id del EventSeato que borrara o arreglo de ids

      if(is_array($id)){
        $sql = "DELETE FROM PurchaseLines WHERE IdPurchaseLine IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM PurchaseLines WHERE IdPurchaseLine = $id";
      }

      try {
        $this->connection = Connection::getInstance();
        return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
        throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM PurchaseLines";

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
        
            $EventSeat = $this->daoEventSeat->read($p['IdSeatEvent']);
            $Purchase = $this->daoPurchase->read($p['IdPurchase']);  
           
            return new ClassPurchaseLine($EventSeat[0], $p['QuantityPurchaseLine'], $p['Total'], $Purchase[0] , $p['IdPurchaseLine'] ); // EventSeat[0](es un arreglo)
        
        }, $value);   // $value es cada array q quiero convertir a objeto
        
        return count($resp) >= 1 ? $resp : $resp[0];
    }      
    
}     