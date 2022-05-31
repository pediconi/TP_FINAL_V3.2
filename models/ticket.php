<?php namespace models;

use models\PurchaseLine as PurchaseLine;

class Ticket {

    private $idTicket;
    private $purchaseLine;
    private $number;
    private $qr;


    function __construct(PurchaseLine $purchaseLine, $qr, $number=0, $idTicket=0){

        $this->idTicket = $idTicket;
        $this->purchaseLine = $purchaseLine;
        $this->number = $number;
        $this->qr = $qr;  
    }

    public function getId(){
      return $this->idTicket;
    }

    public function setId($idTicket){
		  $this->idTicket = $idTicket;
    }

    public function getPurchaseLine(){
      return $this->purchaseLine;
    }

    public function getNumber(){
        return $this->number;
    }

    public function setNumber($number){
        $this->number = $number;
  }

      public function getQr(){
        return $this->qr;
    }  

}