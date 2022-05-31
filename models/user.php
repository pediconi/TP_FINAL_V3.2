<?php namespace models;

class User {

  private $id;
  private $email;
  private $name;
  private $pass;
  private $role;

  function __construct($name, $email, $pass, $role="user", $id=0){

    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->pass = $pass;
    $this->role = $role;

  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getRole(){
      return $this->role;
    }


  public function getName(){
    return $this->name;
  }

  public function getPass(){
      return $this->pass;
    }

}