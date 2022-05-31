<?php namespace controllers;

use models\Purchase as Purchase;
use models\User as User;

use config\Singleton as Singleton;

use dao\Purchase as DaoPurchase; 
use dao\User as DaoUser; 



/**
*
*/

class PurchaseController extends Singleton{

    private $daoPurchase;
    private $daoUser;
  
    
    /**
    *
    */
    function __construct(){

        $this->daoPurchase = DaoPurchase::getInstance();  //SINGLETON creo o devuelvo la instancia
        $this->daoUser = DaoUser::getInstance();    
    }
    /**
    *
    */
    public function PurchaseView(){
        
        try{
            $purchases = $this->daoPurchase->readAll();
        }
        catch(Exception $e){
            throw $e;
        }
        finally {
            //require(ROOT . 'views/header.php');
            //require(ROOT .'views/managePurchase.php');  // llamo a la vista newCalendar ,, tiene q tener una vista para agregar TODO UN PurchaseO( fechas, artistas, lugar, etc)
            //require(ROOT . 'views/footer.php');
        }    
    }
    /**
    *
    */
    
    public function add($idUser){    
        try { 
            
            $user = $this->daoUser->read($idUser); 
            
            date_default_timezone_set("America/Buenos_Aires");
            $date = date("20y-m-d");

            $purchase = new Purchase($user[0], $date);   
            
            $id_purchase = $this->daoPurchase->create($purchase);      // devolver el id de la compra creada 

            $purchase = $this->daoPurchase->read($id_purchase);  // leo el objeto compra de la bd

            

            return $purchase;
            }
         

        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            //$this->calendarView();
        }
    }


    public function delete($id){

        try{
            $mensaje="";

            $this->daoPurchase->delete($id); // LLAMO AL METODO DELETE DEL DAOPurchase

        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->PurchaseView();
        }
    }

}

?>