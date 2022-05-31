<?php
namespace controllers;

use models\SeatType as SeatType;
use dao\SeatType as DaoSeatType;  //namespace y nombre de la Clase
use controllers\HomeController as HomeController; 
use session\Session as Session;

/**
*
*/

class SeatTypeController{

    private $daoSeatType;
    private $home;
    /**
    *
    */
    function __construct(){

      $this->daoSeatType = DaoSeatType::getInstance();  //SINGLETON creo o devuelvo la instancia
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
    public function seatTypeView(){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{
                
                $seatTypes = $this->daoSeatType->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
                
            }	catch(Exception $e){
                    throw $e;

            }	finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageSeatType.php');
                require(ROOT . 'views/footer.php');
            }
        }else {
            $this->home->index();
        } 

    }
    /**
    *
    */
    
    public function add($name){
        if ($_SESSION['user']->getRole() === 'admin') {
            try {
                $_seatType = new SeatType($name); 
                $this->daoSeatType->create($_seatType);
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                    $this->seatTypeView();
            }
        }else {
            $this->home->index();
        } 
    }


public function modify($idModif, $seatTypeName){  
    if ($_SESSION['user']->getRole() === 'admin') { 
        try {

            $seatType = new SeatType($seatTypeName); 
            
            $this->daoSeatType->update($idModif, $seatTypeName); 
        } 
        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            $this->seatTypeView();
        }
    }else {
        $this->home->index();
    } 
}

public function delete($id){
    if ($_SESSION['user']->getRole() === 'admin') {
        try{
            $mensaje="";

            $this->daoSeatType->delete($id); 

        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->seatTypeView();
        }
    }else {
        $this->home->index();
    } 
    

}
}

?>