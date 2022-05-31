<?php namespace controllers;

use models\EventSeat as EventSeat;
use models\SeatType as SeatType;
use config\Singleton as Singleton;

use dao\SeatType as DaoSeatType;
use dao\EventSeat as DaoEventSeat;
 
use controllers\HomeController as HomeController; 
use session\Session as Session;
/**
*
*/

class EventSeatController extends Singleton{

    private $daoSeatType;
    private $daoEventSeat;
    private $home;
    /**
    *
    */
    function __construct(){
    
      $this->daoSeatType = DaoSeatType::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->daoEventSeat = DaoEventSeat::getInstance();  //SINGLETON creo o devuelvo la instancia
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

    public function add($idSeatType, $price ,$quantity){     
        if ($_SESSION['user']->getRole() === 'admin') {
            try { 
                $seatType = $this->daoSeatType->read($idSeatType); 
                
                $id = $this->daoEventSeat->getLastId();  // traer el ultimo id de la tabla eventSeat 

                $eventSeat = new EventSeat($seatType, $quantity, $price, $id+1);    
                
                $this->daoEventSeat->create($eventSeat); 

                return $eventSeat;
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
        }else {
            $this->home->index();
        } 
    }



    public function modify($idModif, $seatType, $price, $quantity){   // cargo los valores modificados
        if ($_SESSION['user']->getRole() === 'admin') {
            try {
                
                $eventSeat = new EventSeat($seatType, $quantity, $price); 
                
                $this->daoEventSeat->update($idModif, $eventSeat); 

                return $eventSeat;
            } 
            catch(\PDOException $ex) {
                throw $ex;
            }
        }else {
            $this->home->index();
        }  
        
    }

    public function delete($id){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{
                $mensaje="";

                $this->daoEvent->delete($id); // LLAMO AL METODO DELETE DEL DAOEVENT

            }	catch(Exception $e){
                $mensaje= $e->getMessage();

            }	finally{

                if(!empty($mensaje)){
                    echo '<script>alert("' . $mensaje . '")</script>';
                }
            }
        }else {
            $this->home->index();
        } 
    }

}

?>