<?php namespace models;


class EventLocation {
    
  private $id;
  private $name;
  private $capacity;
  
  function __construct($name, $capacity, $id = null){

    $this->id = $id;
    $this->name = $name;
    $this->capacity = $capacity;                    
  }

  public function getId(){
    return $this->id;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function getName(){
    return $this->name;
  }

  public function getCapacity(){
    return $this->capacity;
  }

}