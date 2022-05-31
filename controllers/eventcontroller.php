<?php namespace controllers;

use models\Event as Event;
use models\Category as Category;

use dao\Event as DaoEvent; 
use dao\Category as DaoCategory; 

use controllers\HomeController as HomeController; 
use session\Session as Session;
/**
*
*/

class EventController{

    private $daoEvent;
    private $daoCategory;
    private $home;
    /**
    *
    */
    function __construct(){

      $this->daoEvent = DaoEvent::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->daoCategory = DaoCategory::getInstance();  //SINGLETON creo o devuelvo la instancia
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
    public function eventView(){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{
                $categories = $this->daoCategory->readAll();  // arreglo de objetos de categorias
                $events = $this->daoEvent->readAll();
            }
            catch(Exception $e){
                throw $e;
            }
            finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageEvent.php');  // llamo a la vista newCalendar ,, tiene q tener una vista para agregar TODO UN EVENTO( fechas, artistas, lugar, etc)
                require(ROOT . 'views/footer.php');
            }    
        }else {
            $this->home->index();
        } 
    }
    /**
    *
    */
    
    public function add($eventName, $idCategory){     // traigo del form el nombre como text, y el value del idCategory seleccionado de un select,
        if ($_SESSION['user']->getRole() === 'admin') {
            try {     
                $category = $this->daoCategory->read($idCategory); // traigo el obj cateogoria (llega contenido en un arreglo, x eso accedo como category[0])
            
                $event = new Event($category[0], $eventName); // creo el objeto evento pasandole el id de la categoria y el nombre del evento
                
                $this->daoEvent->create($event); // creo el evento y lo guardo
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                    $this->eventView();
            }
        }else {
            $this->home->index();
        } 
    }

    public function modify($idModif, $eventName, $idCategory){   // cargo los valores modificados
        if ($_SESSION['user']->getRole() === 'admin') {
            try {
                $category = $this->daoCategory->read($idCategory); // traigo el obj cateogoria
                
                $event = new Event($category[0], $eventName); // creo el objeto artista 

                
                $this->daoEvent->update($idModif, $event); // id del evento a modificar, y el nuevo evento
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                $this->eventView();
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
                $this->eventView();
            }
        }else {
            $this->home->index();
        } 
    }

}

?>