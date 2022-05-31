<?php
namespace controllers;

use models\Category as Category;
use dao\Category as DaoCategory;  //namespace y nombre de la Clase

use controllers\HomeController as HomeController; 
use session\Session as Session;

/**
*
*/

class CategoryController{

    private $daoCategory;
    private $home;

    /**
    *
    */
    function __construct(){

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
    public function categoryView(){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{
                
                $categories = $this->daoCategory->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
                
            }	catch(Exception $e){
                    throw $e;

            }	finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageCategory.php');
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
                $_category = new Category($name); 
                $this->daoCategory->create($_category);
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                    $this->categoryView();
            }
        }else {
            $this->home->index();
        } 
    }


public function modify($idModif, $categoryName){ 
    if ($_SESSION['user']->getRole() === 'admin') {  
        try {

            $category = new Category($categoryName); 
            
            $this->daoCategory->update($idModif, $categoryName); 
        } 
        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            $this->categoryView();
        }
    }else {
        $this->home->index();
    } 
}

public function delete($id){
    if ($_SESSION['user']->getRole() === 'admin') {
        try{
            $mensaje="";

            $this->daoCategory->delete($id); 

        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->categoryView();
        }
    }else {
        $this->home->index();
    } 
}

}

?>