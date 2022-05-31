<?php namespace models;

use models\EventSeat as EventSeat;
use models\Purchase as Purchase;

class PurchaseLine {

  private $idPurchaseLine;
  private $purchase; 
  private $eventSeat;
  private $quantity;
  private $total;

  function __construct(EventSeat $eventSeat, $quantity, $total , Purchase $purchase = null ,$idPurchaseLine=0 ){

    $this->idPurchaseLine = $idPurchaseLine;
    $this->purchase = $purchase;
    $this->eventSeat = $eventSeat;
    $this->quantity = $quantity;
    $this->total = $total;
  }

  public function getId(){
      return $this->idPurchaseLine;
  }

  public function getEventSeat(){
    return $this->eventSeat;
  }

  public function getPurchase(){
    return $this->purchase;
  }

  public function getQuantity(){
    return $this->quantity;
  }

  public function setQuantity($quantity){
      $this->quantity= $quantity;
    }

  public function getTotal(){
      return $this->total;
    }

  public function setTotal($total){
      $this->$total= $$total;
    }

  public function setId($idPurchaseLine){
    $this->idPurchaseLine = $idPurchaseLine;
  }

  public function seteventSeat($value){
    $this->eventSeat = $value;
  }
  
}