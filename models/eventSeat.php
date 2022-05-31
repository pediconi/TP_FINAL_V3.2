<?php namespace models;

use models\SeatType as SeatType;
use models\Calendar as Calendar;

class EventSeat {  // (plaza evento)
    
    private $id;
    private $seatType;
    private $totalAvailables;
    private $price;
    private $calendar;
    
    function __construct(Calendar $calendar, SeatType $seatType, $totalAvailables, $price, $id=0){

        $this->id = $id;
        $this->seatType = $seatType;
        $this->totalAvailables = $totalAvailables;            
        $this->price = $price; 
        $this->calendar = $calendar;        
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
		$this->id = $id;
    }

    public function setTotalAvailables($totalAvailables){
		$this->totalAvailables = $totalAvailables;
    }
  
    public function getSeatType(){
        return $this->seatType;
    }

    public function getTotalAvailables(){
        return $this->totalAvailables;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
		$this->price = $price;
    }

    public function getTotal(){
        return ($this->price * $this->totalAvailables);
    }


    public function getCalendar(){
        return $this->calendar;
    }

    
}