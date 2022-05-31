<?php namespace controllers;

use models\Ticket as Ticket;
use models\PurchaseLine as PurchaseLine;
use models\Qr as QR;

use dao\Ticket as DaoTicket; 
use dao\PurchaseLine as DaoPurchaseLine; 

use config\Singleton as Singleton;

use controllers\homeController as HomeController;



/**
*
*/

class TicketController extends Singleton{

    private $daoTicket;
    private $daoPurchaseLine;
    private $homeController;
    
    /**
    *
    */
    function __construct(){

        $this->daoTicket = DaoTicket::getInstance();  //SINGLETON creo o devuelvo la instancia
        $this->daoPurchaseLine = DaoPurchaseLine::getInstance();  //SINGLETON creo o devuelvo la instancia
        $this->homeController = HomeController::getInstance();  //SINGLETON creo o devuelvo la instancia
        
    }
    /**
    *
    */
    public function TicketView(){
        
        try{
            $tickets = $this->daoTicket->readAll();
        }
        catch(Exception $e){
            throw $e;
        }
        finally {
            //require(ROOT . 'views/header.php');
            //require(ROOT .'views/manageTicket.php');  ////////////////////////////////////
            //require(ROOT . 'views/footer.php');
        }    
    }
    /**
    *
    */
    
    public function add($idPurchaseLine){    
        try {     
            $PurchaseLine = $this->daoPurchaseLine->read($idPurchaseLine); // en este punto ya se tuvieron q haber guardado en la bd las lineas de compra  
            
            //$qr = new QR();
            //$qr->generateQr();
            $qr = 'sdfgadsdfg';
            $ticket = new Ticket($PurchaseLine[0], $qr, $idPurchaseLine);
            
            $id = $this->daoTicket->create($ticket); 
            return $id;
           
        } 
        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            
                //$this->homeController->index();
        }
    }


    public function delete($id){

        try{
            $mensaje="";

            $this->daoTicket->delete($id); // LLAMO AL METODO DELETE DEL DAOTicket

        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->TicketView();
        }
    }

}

?>