<?php namespace controllers;

use models\EventSeat as EventSeat;
use models\PurchaseLine as PurchaseLine;

use config\Singleton as Singleton;

use dao\EventSeat as DaoEventSeat;
use dao\PurchaseLine as DaoPurchaseLine;
use dao\User as DaoUser;
use dao\Ticket as DaoTicket;
use dao\session\PurchaseLine as SessionPurchaseLine;  

use controllers\HomeController as HomeController; 
use controllers\PurchaseController as PurchaseController;
use controllers\TicketController as TicketController;

/**
*
*/

class PurchaseLineController extends Singleton{

    private $daoEventSeat;
    private $daoPurchaseLine;
    private $daoUser;
    private $daoTicket;

    private $sessionPurchaseLine;
    private $homeController;
    private $purchaseController;
    private $ticketController;

    /**
    *
    */
    function __construct(){

        $this->daoEventSeat = DaoEventSeat::getInstance();  //SINGLETON creo o devuelvo la instancia
        $this->daoPurchaseLine = DaoPurchaseLine:: getInstance();
        $this->daoUser = DaoUser:: getInstance();
        $this->daoTicket = DaoTicket:: getInstance();
        $this->sessionPurchaseLine = SessionPurchaseLine::getInstance();  //SINGLETON creo o devuelvo la instancia
        
        $this->homeController = HomeController::getInstance();
        $this->purchaseController = PurchaseController::getInstance();
        $this->ticketController = TicketController::getInstance();
    }
    /**
    *
    */
    public function purchaseLineView(){
        try{
            
            $purchaseLines = $this->sessionPurchaseLine->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
            $user = $this->daoUser->getByEmail($_SESSION['user']->getEmail());
            //var_dump($user);
            //var_dump($_SESSION['purchasesLines']);
            //var_dump($_SESSION['user']->getEmail());

        }	catch(Exception $e){
                throw $e;

        }	finally {
            require(ROOT . 'views/header.php');
            require(ROOT . 'views/cart.php'); 
            require(ROOT . 'views/footer.php');
        }
    }
    /**
    *
    */

    public function add($idEventSeat, $quantity){          
  
        try { 
        
            $EventSeat = $this->daoEventSeat->read($idEventSeat); 
            $total= $quantity * $EventSeat[0]->getPrice();
            $purchaseLine = new PurchaseLine($EventSeat[0], $quantity, $total);    

            $this->sessionPurchaseLine->create($purchaseLine);

            

            //$qr = new QR();
            //$qr->generateQr();
            
        } catch(\PDOException $ex) {
            throw $ex;

        } finally{
            $this->homeController->index();
        }
          
    }
    /**
    *
    */        
    // LLAMARA A ESTA CUANDO FINALIZA LA COMPRA PASANDOLE EL ID_USUARIO  agrega en la bd tabla purchase line todo lo q esta en session  
    public function addToDB($idUser, $email){  
        try { 
            $purchase = $this->purchaseController->add($idUser);    // tengo el objeto compra
            $msg = "";
            foreach($_SESSION['purchasesLines'] as $key => $value){
                $purchaseLine = new PurchaseLine($value->getEventSeat(), $value->getQuantity(), $value->getTotal(), $purchase[0]);
                $idPurchaseLine = $this->daoPurchaseLine->create($purchaseLine); 
                $idTicket = $this->ticketController->add($idPurchaseLine);
                $ticket = $this->daoTicket->read($idTicket)[0];
                $msg .= "| ticket number: " . $ticket->getNumber() . " for: " . $value->getEventSeat()->getCalendar()->getEvent()->getName() . " QR: " . $ticket->getQr() . " | ";
            }

            // use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg,70);

            // send email
            mail('ramirez.facu@hotmail.com', 'Musiteck Tickets', $msg);
            
            
        } 
        catch(\PDOException $ex) {
            throw $ex;
        }finally{
            require(ROOT . 'views/header.php');
            require(ROOT . 'views/success.php'); 
            require(ROOT . 'views/footer.php');
        }
        
    }
    /**
    *
    */
    public function delete($id){

        try{
            $mensaje="";

            $this->sessionPurchaseLine->delete($id); 
            
        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->purchaseLineView();
        }
       
    }
    /**
    *
    */
    public function deleteFromDB($id){

        try{
            $mensaje="";

            $this->daoPurchaseLine->delete($id); 
            
        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->purchaseLineView();
        }
       
    }

    /*public function getPurchasesLines(){

        if (isset($_SESSION['purchasesLines'])){
            return $_SESSION['purchasesLines'];
        }
        return null;
    }*/

    public function generateTicket($idPurchaseLine){

        $this->ticketController->add($idPurchaseLine);  // le paso esta responzabilidad a la controladora de ticket
    }

    public function returnLastTicket(){
        $sql = "SELECT LAST_INSERT_ID()";

        try {
            $resultSet = $this->connection->execute($sql);

        } catch(Exception $ex) {
            throw $ex;
        }
    }

}

?>