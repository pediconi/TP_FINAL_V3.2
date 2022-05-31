<?php namespace models;

use models\User as User;

class Purchase {

    private $idPurchase;
    private $user;
    private $date;


    function __construct(User $user, $date , $idPurchase=0){

        $this->idPurchase = $idPurchase;
        $this->user = $user;
        $this->date = $date;  
    }

    public function getId(){
        return $this->idPurchase;
    }

    public function setId($idPurchase){
		$this->idPurchase = $idPurchase;
    }


    public function getUser(){
        return $this->user;
    }

    public function getDate(){
        return $this->date;;
    }  

}