<?php namespace dao;

use interfaces\crud as CRUD;
use models\Ticket as ClassTicket;
use config\Singleton as Singleton;

use dao\Connection as Connection;
use dao\PurchaseLine as DaoPurchaseLine;


use Exception;   

class Ticket extends Singleton implements CRUD {

    private $connection;
    private $daoPurchaseLine;

    function __construct(){
        $this->daoPurchaseLine = DaoPurchaseLine::GetInstance();
        $this->connection = Connection::GetInstance();
    }

    public function create($object) {

        $sql = "INSERT INTO Tickets (IdPurchaseLine, QrTicket, NumberTicket) VALUES (:idPurchaseLine, :qrTicket , :numberTicket)";

        $parameters['idPurchaseLine'] = $object->getPurchaseLine()->getId(); //id de la categoria
        $parameters['numberTicket'] = $object->getNumber();
        $parameters['qrTicket'] = $object->getQr();

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
          $sql = "SELECT * FROM Tickets WHERE IdTicket = :id";
          
          $parameters['id'] = $id;

          try {
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

        $sql = "UPDATE Tickets SET IdPurchaseLine = :idPurchaseLine,  QrTicket =: qrTicket, NumberTicket = :numberTicket 
                WHERE IdTicket = $id";

        $parameters['idPurchaseLine'] = $object->getPurchaseLine()->getId(); //id de la categoria
        $parameters['numberTicket'] = $object->getNumber();
        $parameters['qrTicket'] = $object->getQr();
        

        try {

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }  //id del Ticketo que se modificara, y el objecto que ingresara en ese id


    public function delete($id){  //recive el id del Ticketo que borrara o arreglo de ids

      if(is_array($id)){
        $sql = "DELETE FROM Tickets WHERE IdTicket IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Tickets WHERE IdTicket = $id";
      }

      try {
        
        return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
        throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM Tickets";

        try {
            $resultSet = $this->connection->execute($sql);

        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
    }

    public function getByPurchaseLine($_id){
        $sql = "SELECT * FROM Tickets WHERE IdPurchaseLine = :id";
              
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

	protected function mapear($value) {   // va reemplazando cada posicion del arreglo (de registros) con el objeto correspondiente
                                    // paso de tener un arreglo de arreglos con registros, a arreglo con arreglos de obj
        $value = is_array($value) ? $value : [];
        $resp = array_map( function($p) {
        
            $purchaseLine = $this->daoPurchaseLine->read($p['IdPurchaseLine']); 
           
            return new ClassTicket($purchaseLine[0], $p['QrTicket'], $p['NumberTicket'], $p['IdTicket']); // PurchaseLine[0](es un arreglo)
        
        }, $value);   // $value es cada array q quiero convertir a objeto
        
        return count($resp) >= 1 ? $resp : $resp[0];
    }      
    
}     