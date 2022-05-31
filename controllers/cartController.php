<?php namespace controllers;

use config\Singleton as Singleton;

use models\PurchaseLine as PurchaseLine;

use dao\session\PurchaseLine as SessionPurchaseLine;  



/**
*
*/

class CartController extends Singleton {

    private $sessionPurchaseLine;
    /**
    *
    */
    function __construct(){
        $this->sessionPurchaseLine = SessionPurchaseLine::getInstance();  //SINGLETON creo o devuelvo la instancia
    }

    /**
    *
    */
    public function cartView(){
        try{                                                
            $purchaseLines = $this->sessionPurchaseLine->readAll();         
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

}

?>