<?php namespace controllers;

use config\Singleton as Singleton;

use models\PurchaseLine as PurchaseLine;

use dao\session\PurchaseLine as SessionPurchaseLine;  
use session\Session as Session;


/**
*
*/

class CheckoutController extends Singleton {

    private $sessionPurchaseLine;
    /**
    *
    */
    function __construct(){
        $this->sessionPurchaseLine = SessionPurchaseLine::getInstance();  //SINGLETON creo o devuelvo la instancia
        try{
            Session::start();
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    /**
    *
    */
    public function checkoutView(){
        try{                                                
            $purchaseLines = $this->sessionPurchaseLine->readAll();   
            $account = $_SESSION['user'];       
        }
        catch(Exception $e){
            throw $e;
        }
        finally {
            require(ROOT . 'views/header.php');
            require(ROOT .'views/checkout.php');  
            require(ROOT . 'views/footer.php');
        }    
    }

    public function email()
    {
        // the message
        $msg = "soy una bestia que se va a hacer hice que el codigo te mande un pvto mail";

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);

        // send email
        mail('ivanpediconi@hotmail.com', 'ivan pvto',$msg);
        
    }

}

?>