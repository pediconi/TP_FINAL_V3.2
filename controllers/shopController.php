<?php namespace controllers;

use config\Singleton as Singleton;

use models\Artist as Artist;
use models\Event as Event;
use models\Category as Category;
use models\Calendar as Calendar;
use models\EventLocation as EventLocation;
use models\EventSeat as EventSeat;
use models\SeatType as SeatType;

use dao\Artist as DaoArtist;
use dao\Event as DaoEvent; 
use dao\Calendar as DaoCalendar;
use dao\EventLocation as DaoEventLocation;
use dao\EventSeat as DaoEventSeat;
use dao\SeatType as DaoSeatType;


/**
*
*/

class ShopController extends Singleton {

    private $daoArtist;
    private $daoEvent;
    private $daoCategory;
    private $daoCalendar;
    private $daoEventLocation;
    private $daoEventSeat;
    private $eventSeatController;
    private $daoSeatType;
    
    /**
    *
    */
    function __construct(){
      
      $this->daoArtist= DaoArtist::getInstance();  
      $this->daoEvent = DaoEvent::getInstance();  //SINGLETON creo o devuelvo la instancia
      
      $this->daoCalendar = DaoCalendar::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->daoEventLocation = DaoEventLocation::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->daoEventSeat = DaoEventSeat::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->daoSeatType = DaoSeatType::getInstance();

      $this->eventSeatController = EventSeatController::getInstance();
    }

    /**
    *
    */
    public function shopViewCalendar($id){
        try{                                                
            $calendar = $this->daoCalendar->read($id); 
            $idArtists = $this->daoArtist->getByIdCalendar($id);

            for ($x=0;$x<count($idArtists); $x++) { 
                $artists[$x] = $this->daoArtist->read($idArtists[$x][0]);
            }

            $seatEvents = $this->daoEventSeat->getByIdCalendar($id);
            
        }
        catch(Exception $e){
            throw $e;
        }
        finally {
            require(ROOT . 'views/header.php');
            require(ROOT .'views/shop.php');  
            require(ROOT . 'views/footer.php');
        }    
    }
    
    public function shopViewArtist($id){
        try{                                                
            $artist = $this->daoArtist->read($id); 
            $idCalendars = $this->daoCalendar->getByIdArtist($id);

            

            $calendar = $this->daoCalendar->read($idCalendars[0][0]);
            $idArtists = $this->daoArtist->getByIdCalendar($calendar[0]->getId());


            for ($x=0;$x<count($idArtists); $x++) { 
                $artists[$x] = $this->daoArtist->read($idArtists[$x][0]);
            }
            
            $seatEvents = $this->daoEventSeat->getByIdCalendar($calendar[0]->getId());

            
        }
        catch(Exception $e){
            throw $e;
        }
        finally {
            require(ROOT . 'views/header.php');
            require(ROOT .'views/shop.php');  
            require(ROOT . 'views/footer.php');
        }    
    }

}

?>