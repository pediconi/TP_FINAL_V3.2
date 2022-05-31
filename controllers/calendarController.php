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


use controllers\EventSeatController as EventSeatController;
use controllers\HomeController as HomeController; 
use session\Session as Session;

/**
*
*/

class CalendarController extends Singleton {

    private $daoArtist;
    private $daoEvent;
    private $daoCategory;
    private $daoCalendar;
    private $daoEventLocation;
    private $daoEventSeat;
    private $eventSeatController;
    private $daoSeatType;
    private $home;
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
      $this->home = new HomeController();
      try{
            Session::start();
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    /**
    *
    */
    public function calendarView(){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{                                                // BERNAR modifica esto vos, en base a lo q quieras q se vea en tu vista manageCalendar
                //$eventLocation = $this->daoCategory->readAll();  // arreglo de objetos de categorias
                $events = $this->daoEvent->readAll();
                $artists = $this->daoArtist->readAll();
                $seatEvent = $this->daoEventSeat->readAll();
                $seatType = $this->daoSeatType-> readAll();
                $eventLocation = $this->daoEventLocation->readAll();
                $calendars = $this->daoCalendar->readAll();
                

            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageCalendar.php');  // BERNARDITO... toda tuya la vista
                require(ROOT . 'views/footer.php');
            } 
        }else {
            $this->home->index();
        }    
    }
    /**
    *
    */
    // AGREGAR UN CALENDARIO (NO SE SI TIENE Q RECIBIR LOS ARTISTAS Y MANDARLOS CON UN DAO A LA TABLA INTERMEDIA)
    public function add($date, $idEvent, $artists, $idEventLocation, $seats){   // seats = array (Vip(precio, cantidad), field(precio, cantidad) ... )
        if ($_SESSION['user']->getRole() === 'admin') {
            try { 
                
                $event = $this->daoEvent->read($idEvent); // traigo el objeto evento
                $eventLocation = $this->daoEventLocation->read($idEventLocation);
                
                $calendar = new Calendar($date, $event[0], $eventLocation[0]);    // eventSeats = arreglo de objetos plaza evento;
                $id_calendar = $this->daoCalendar->create($calendar); // creo el evento y lo guardo. IMPORTANTE en la BD SE GUARDA CADA FK idEventSeat(osea los id de la tabla eventSeats) DE $arrayEventSeats, 
                $calendar = $this->daoCalendar->read($id_calendar); 
        
                foreach($seats as $key => $value){
                    if(!($value['capacity'] === "")){
                        $seatType = $this->daoSeatType->read($key); 
                        $eventSeat = new EventSeat($calendar[0], $seatType[0], $value['capacity'], $value['price']);
                        $this->daoEventSeat->create($eventSeat);
                    }  
                }

                foreach($artists as $key => $value){
                    $this->daoCalendar->insertCalendarXArtist($id_calendar, $value); 
                }
            
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                $this->calendarView();
            }
        }else {
            $this->home->index();
        } 
    }


    //MODIFICAR UN CALENDARIO
    public function modify($idModif, $date, $idEvent, $artist, $idEventLocation, $seats){  // seats se recibe con la misma estructura que en add 
        if ($_SESSION['user']->getRole() === 'admin') {
            try {
                $event = $this->daoEvent->read($idEvent); // traigo el objeto evento    
                $eventLocation = $this->daoEventLocation->read($idEventLocation);

                $calendar = $this->daoCalendar->read($idModif); // traigo el obj calend
                $calendar[0]->setDate($date);
                $calendar[0]->setEvent($event);
                $calendar[0]->setEventLocation($eventLocation);
                

                
                //$calendar = new Calendar($date, $event[0], $eventLocation[0]);    // eventSeats = arreglo de objetos plaza evento;
                $this->daoCalendar->update($idModif, $calendar); // creo el evento y lo guardo. IMPORTANTE en la BD SE GUARDA CADA FK idEventSeat(osea los id de la tabla eventSeats) DE $arrayEventSeats, 
                                // arreglo para guardar los id de los objeto plazaEvento
                
                foreach($seats as $key => $value){
                    if(!($value['capacity'] === "")){
                        $eventSeat = $this->daoSeatEvent->readByCalendar_SeatType($idModif, $key);  // busco seatType x el id
                    
                        $eventSeat->setTotalAvailables($value['capacity']);   
                        $id_modifEventSeat = $eventSeat->getId();

                        //$eventSeat = new EventSeat($calendar[0], $seatType[0], $value['capacity'], $value['price']);
                        $this->daoEventSeat->update($id_modifEventSeat, $eventSeat);
                        }
                }
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
        }else {
            $this->home->index();
        } 
        
    }

}

?>