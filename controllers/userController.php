<?php namespace controllers;

use models\User as User;
use dao\User as DaoUser;
use controllers\HomeController as HomeController; 
use session\Session as Session;


/**
*
*/

class UserController{

    private $daoUser;
    private $home;
    
    /**
    *
    */
    function __construct(){

      $this->daoUser = DaoUser::getInstance();  //SINGLETON creo o devuelvo la instancia
      $this->home = new HomeController();
    }

    /**
    *
    */
    public function loginView(){
        try{
            
            $users = $this->daoUser->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
            
        }	catch(Exception $e){
                throw $e;

        }	finally {
            require(ROOT .'views/login.php');
        }  
    }
    /**
    *
    */
    public function singUpView(){
        try{
            
        }	catch(Exception $e){
                throw $e;

        }	finally {
            require(ROOT .'views/singup.php');
        }  
    }
    
    public function login($email, $pass){   // cargo los valores modificados
        try{
            Session::start();
            Session::remove("user");
        }catch (Exception $ex) {
            throw $ex;
       }
        $usercompleto = $this->daoUser->getByEmail($email)[0];
        if($usercompleto) {
           if($usercompleto->getPass() === $pass) {
               $_SESSION['user'] = $usercompleto;
           } 
        }

        
        $this->home->index();
    }

    public function singUp($nameUser, $emailUser, $passwordAdmin){   // cargo los valores modificados

        try {     
            $user = new User($nameUser, $emailUser, $passwordAdmin); // creo el objeto producto pasandole el id de la categoria y el nombre del producto
            $this->daoUser->create($user); // creo el producto y lo guardo
        } 
        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            header("Location:" . FRONT_ROOT .  "user/loginView");
        }
    }

    public function logout(){
        try{
            Session::start();
            Session::remove("user");
        }catch (Exception $ex) {
            throw $ex;
       }
       $this->home->index();
    }

    public function delete(){

        
    }

}

?>