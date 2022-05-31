<?php namespace models;

use models\Event as Event; 
use models\Artist as Artist; 
use models\EventLocation as EventLocation;   // (lugar evento) 

class Calendar {

    private $idCalendar;
    private $date;
    private $event;
    private $eventLocation;

    function __construct($date, Event $event, EventLocation $eventLocation, $idCalendar=null){
        
        $this->idCalendar = $idCalendar;
        $this->date = $date;
        $this->event = $event;
        $this->eventLocation = $eventLocation;
        
    }

    public function getId(){
        return $this->idCalendar;
    }

    public function setId($id)
    {
        $this->idCalendar = $id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function setEventLocation($eventLocation)
    {
        $this->eventLocation = $eventLocation;
    }

    public function getDate(){
        return $this->date;
    }

    public function getEvent(){
        return $this->event;
    }

    public function getEventLocation(){
        return $this->eventLocation;
    }

}