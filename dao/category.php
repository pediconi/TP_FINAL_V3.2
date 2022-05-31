<?php namespace dao;

use interfaces\crud as CRUD;
use dao\Connection as Connection;
use models\category as Categorias;
use config\Singleton as Singleton;

use Exception;   // ?

class Category extends Singleton implements CRUD {

    private $connection;

    public function create($object) {

        $sql = "INSERT INTO Categories(NameCategory) VALUES (:name)";

        $parameters['name'] = $object->getName();

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function read($id) {  //busca por un id o por arreglo de ids
        
     
          $sql = "SELECT * FROM Categories where IdCategory = $id";
        

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

    public function update($id,$name){

        $sql = "UPDATE Categories SET NameCategory = :nombre WHERE IdCategory = $id";

        $parameters['nombre'] = $name;

        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }   //recive el id del objeto que se quiere modificar, y el objecto que se quiere insertar en ese id

    public function delete($id){ // elimina por un id o por muchos

      if(is_array($id)){
        $sql = "DELETE FROM Categories WHERE IdCategory IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Categories WHERE IdCategory = $id";
      }

      try {
          $this->connection = Connection::getInstance();
          $this->connection->executeQuery($sql);
      }catch(\PDOException $ex) {
          throw $ex;
      }

    }

    public function readAll() {

        $sql = "SELECT * FROM Categories";

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
            $a = new Categorias($p['NameCategory'], $p['IdCategory']);
           
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }

}
