<?php namespace dao;

use interfaces\crud as CRUD;
use dao\connection as Connection;
use models\calendar as ClassCalendar;
use config\Singleton as Singleton;

use dao\Event as DaoEvent;
use dao\EventLocation as DaoEventLocation;    // HACERLO
use dao\EventSeat as DaoEventSeat;
use dao\SeatType as DaoSeatType;
use dao\Connection as DaoConnection;

use Exception;

class Calendar extends Singleton implements CRUD {

    private $connection;
    private $daoEvent;
    private $daoEventLocation;
    private $daoEventSeat;
    private $daoSeatType;

    function __construct(){
        $this->daoEvent = DaoEvent::getInstance();
        $this->daoEventLocation = DaoEventLocation::getInstance();
        //$this->daoEventSeat = DaoEventSeat::getInstance(); esto provoca recursividad
        $this->daoSeatType = DaoSeatType::getInstance();
        $this->connection = DaoConnection::getInstance();

    }

    public function create($calendar) {

        $sql = "INSERT INTO Calendars (DateCalendar, IdEvent, IdEventLocation) VALUES (:dateCal, :event, :eventLocation)";
       
            $date = $calendar->getDate();
            $dateCal = str_replace("/", "-", $date);

            $parameters['dateCal'] = $dateCal;
            $parameters['event'] = $calendar->getEvent()->getId();
            $parameters['eventLocation'] = $calendar->getEventLocation()->getId();

        
        try {

        $this->connection = Connection::getInstance();

         $this->connection->ExecuteQuery($sql, $parameters);

        
        $pdo = $this->connection->getPdo();
        return $pdo->lastInsertId();

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function insertCalendarXArtist($idCalendar, $idArtist) {

        $sql = "INSERT INTO CalendarXArtist (IdCalendar, IdArtist) VALUES (:idCalendar, :idArtist)" ;

            $parameters['idCalendar'] = $idCalendar;
            $parameters['idArtist'] = $idArtist;
        
        try {

        $this->connection = Connection::getInstance();

         $this->connection->ExecuteQuery($sql, $parameters);

        
        $pdo = $this->connection->getPdo();
        return $pdo->lastInsertId();

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function getByText($_text) {
        $sql = "SELECT * FROM Calendars WHERE IdEvent = :idEvent"; //por q no anda el or DateCalendar like :text OR 

        $event = $this->daoEvent->getByName($_text)[0];
        
        if($event){
            $parameters['idEvent'] = $event->getId();
        } else{
            $parameters['text'] = '%' . $_text . '%';
        }
        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql, $parameters);
        } catch(Exception $ex) {
            throw $ex;
        }


        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
   }

   public function getByIdArtist($_id) {
    $sql = "SELECT IdCalendar FROM CalendarXArtist WHERE IdArtist = :id";
      
    $parameters['id'] = $_id;

    try {
         $this->connection = Connection::getInstance();
         $resultSet = $this->connection->execute($sql, $parameters);
    } catch(Exception $ex) {
        throw $ex;
    }

    return $resultSet;

}

    public function read($id) { //busca por id o por arreglo de ids

        if(is_array($id)){
          $sql = "SELECT * FROM Calendars where IdCalendar IN (".implode(",",$id).")";
        }else{
          $sql = "SELECT * FROM Calendars where IdCalendar = $id";
        }

        try {

            $this->connection = Connection::getInstance();
            $resultSet = $this->connection->execute($sql);

        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
            return $this->mapear($resultSet);
        else
            return false;
     }

    public function update($id, $object){

        $sql = "UPDATE Calendars SET DateCalendar = :dateCal, IdEvent = :event, IdPlace = :place WHERE IdCalendar = $id";

        $parameters['dateCal'] = $object->getDate();
        $parameters['event'] = $object->getEvent();
        $parameters['place'] = $object->getEventLocation();
        
        try {

        $this->connection = Connection::getInstance();

        return $this->connection->ExecuteQuery($sql, $parameters);

        }catch(\PDOException $ex) {

            throw $ex;
        }

    }

    public function delete($id){

      if(is_array($id)){
        $sql = "DELETE FROM Calendars WHERE IdCalendar IN (".implode(",",$id).")";
      }else{
        $sql = "DELETE FROM Calendars WHERE IdCalendar = $id";
      }

      try {
          $this->connection = Connection::getInstance();
          return $this->connection->ExecuteQuery($sql);
      }catch(\PDOException $ex) {
          throw $ex;
      }

    } // elimina por id o por arreglo de ids

    public function readAll() {

        $sql = "SELECT * FROM Calendars";

        try {
             $this->connection = Connection::getInstance();
             $resultSet = $this->connection->execute($sql); // devuelve una array con varios array q representan cada fila de registros
        } catch(Exception $ex) {
            throw $ex;
        }

        if(!empty($resultSet))
             return $this->mapear($resultSet);
        else
             return false;
    }


    protected function mapear($value) {

        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){

            $event = $this->daoEvent->read($p['IdEvent']); // traigo el objeto evento
            $eventLocation = $this->daoEventLocation->read($p['IdEventLocation']);    

            

        return new ClassCalendar($p['DateCalendar'], $event[0], $eventLocation[0], $p['IdCalendar'] );

    }, $value);   // $value es cada array q quiero convertir a objeto

            return $resp;

    }

}
