<?php namespace models;

use models\Category as Category;

class Event {

  private $idEvent;
  private $category;
  private $name;

  function __construct(Category $category, $name, $idEvent=0){

    $this->idEvent = $idEvent;
    $this->category = $category;
    $this->name = $name;
  }

  public function getId(){
      return $this->idEvent;
  }

  public function getCategory(){
    return $this->category;
  }

  public function getName(){
    return $this->name;
  }

  public function setId($idEvent){
    $this->idEvent = $idEvent;
  }

  public function setCategory($value){
    $this->category = $value;
  }
  
  public function setName($value){
    $this->name = $value;
  }



}
