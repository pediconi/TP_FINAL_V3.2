<?php namespace dao;

use interfaces\crud as CRUD;
use models\Purchase as ClassPurchase;
use config\Singleton as Singleton;

use dao\Connection as Connection;
use dao\User as DaoUser;
//use dao\Purchase as DaoPurchase;


use Exception;   

class Purchase extends Singleton implements CRUD {

    private $connection;
    private $daoUser;

    function __construct(){
        
        $this->daoUser = DaoUser::GetInstance();
        
    }

    public function create($object) {

        $sql = "INSERT INTO Purchases (IdUser, DatePurchase) VALUES (:idUser, :datePurchase)";

        $parameters['datePurchase'] = $object->getDate();
        $parameters['idUser'] = $object->getUser()->getId(); //id de la categoria
        

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
          $sql = "SELECT * FROM Purchases WHERE IdPurchase IN (".implode(",",$id).")";
        }else{
          $sql = "SELECT * FROM Purchases WHERE IdPurchase = $id";
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

        $sql = "UPDATE Purchases SET IdUser = :idUser, DatePurchase = :datePurchase
                WHERE IdPurchase = $id";

        $parameters['datePurchase'] = $object->getDate();
        $parameters['idUser'] = $object->getUser()->getId(); //id de la categoria
        

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }  //id del Usero que se modificara, y el objecto que ingresara en ese id


    public function delete($id){  //recive el id del Usero que borrara o arreglo de ids

      if(is_array($id)){
        $sql = "DELETE FROM Purchases WHERE IdPurchase IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Purchases WHERE IdPurchase = $id";
      }

      try {
        $this->connection = Connection::getInstance();
        return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
        throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM Purchases";

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
        
            $User = $this->daoUser->read($p['IdUser']); 
           
            return new ClassPurchase($User[0], $p['DatePurchase'], $p['IdPurchase'] ); // User[0](es un arreglo)
        
        }, $value);   // $value es cada array q quiero convertir a objeto
        
        return count($resp) >= 1 ? $resp : $resp[0];
    }      
    
}     