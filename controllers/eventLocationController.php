<?php namespace controllers;

use models\EventLocation as EventLocation;

use dao\EventLocation as DaoEventLocation; 

use controllers\HomeController as HomeController; 
use session\Session as Session;

/**
*
*/

class EventLocationController{

    private $daoEventLocation;
    private $home;
    
    /**
    *
    */
    function __construct(){

      $this->daoEventLocation = DaoEventLocation::getInstance();  //SINGLETON creo o devuelvo la instancia
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
    public function eventLocationView(){
        if ($_SESSION['user']->getRole() === 'admin') {
        try{
            
            $locations = $this->daoEventLocation->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
            
        }	catch(Exception $e){
                throw $e;

        }	finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageEventLocation.php');
                require(ROOT . 'views/footer.php');
            }
           
        }else {
            $this->home->index();
        }

    }
    
    public function add($eventLocationName, $capacity){     // traigo del form el nombre como text, y el value del idCategory seleccionado de un select,
        if ($_SESSION['user']->getRole() === 'admin') {
            try { 
                
                $eventLocation = new EventLocation($eventLocationName, $capacity); // creo el objeto evento pasandole el id de la categoria y el nombre del evento
                
                $this->daoEventLocation->create($eventLocation); // creo el evento y lo guardo
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                $this->home->index();
            }
        }else {
            $this->home->index();
        } 
    }

    public function modify($idModif, $eventLocationName, $capacity){   // cargo los valores modificados
        if ($_SESSION['user']->getRole() === 'admin') {
            try {
                
                $eventLocation = new EventLocation($eventLocationName, $capacity);  // creo el objeto artista 
                
                $this->daoEventLocation->update($idModif, $eventLocation); // id del evento a modificar, y el nuevo evento
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                $this->eventLocationView();
            }
        }else {
            $this->home->index();
        } 
    }

    public function delete($id){
        if ($_SESSION['user']->getRole() === 'admin') {
        try{
            $mensaje="";
            $this->daoEventLocation->delete($id); // LLAMO AL METODO DELETE DEL DAOEVENT
        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{
                if(!empty($mensaje)){
                    echo '<script>alert("' . $mensaje . '")</script>';
                }
           
                $this->eventLocationView();
            } 
        }else {
            $this->home->index();
        } 
    }

}

?>