<?php namespace models;

class Artist {

    private $id;
    private $name;
    private $description;
    private $photo;

    function __construct($name, $description, $pathPhoto='', $id=0){
      
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
      $this->photo = $pathPhoto;
    }

    public function getId(){
      return $this->id;
    }

    public function setId($id)
    {
      $this->id = $id;
    }
    
    public function getName(){
      return $this->name;
    }

    public function getDescription(){
      return $this->description;
    }

    public function getPhoto(){
      return $this->photo;
    }

}
