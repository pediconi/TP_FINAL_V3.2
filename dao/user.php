<?php namespace dao;

use interfaces\crud as CRUD;
use dao\Connection as Connection;
use models\User as Logins;
use config\Singleton as Singleton;

use Exception;   // ?

class User extends Singleton implements CRUD {

    private $connection;

    function __construct(){

    }

    public function create($object) {

        $sql = "INSERT INTO Users(NameUser, EmailUser, RoleUser, PasswordUser) VALUES (:name, :email, :role, :pass)";
        $parameters['name'] = $object->getName();
        $parameters['email'] = $object->getEmail();
        $parameters['role'] = $object->getRole();
        $parameters['pass'] = $object->getPass();

        try {
            
        $this->connection = Connection::getInstance();
        return $this->connection->ExecuteQuery($sql, $parameters);
        }catch(\PDOException $ex) {
            throw $ex;
        }

    }

    public function read($id) {  //busca por un id o por arreglo de ids
        
       
        $sql = "SELECT * FROM Users WHERE IdUser = :id";
  
        $parameters['id'] = $id;

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

    public function update($id,$name){


    }   //recive el id del objeto que se quiere modificar, y el objecto que se quiere insertar en ese id

    public function delete($id){ // elimina por un id o por muchos

   
    }

    public function readAll() {

        $sql = "SELECT * FROM Users";

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


    public function getByEmail($_email) {
        $sql = "SELECT * FROM Users WHERE EmailUser = :emailUser";
          
        $parameters['emailUser'] = $_email;

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
    




    protected function mapear($value) {
        $resp = array_map(function($p){
            $a = new Logins($p['NameUser'], $p['EmailUser'], $p['PasswordUser'], $p['RoleUser'], $p['IdUser']);
           
            return $a;
        }, $value);   // $value es cada array q quiero convertir a objeto
        return $resp;
    }

}