<?php
namespace controllers;

use models\Artist as Artist;
use dao\Artist as DaoArtist;  //namespace y nombre de la Clase
use models\Photo as Photo;

use controllers\HomeController as HomeController; 
use session\Session as Session;
/**
*
*/

class ArtistController{

    private $daoArtist;
    private $home;
    /**
    *
    */
    function __construct(){

      $this->daoArtist = DaoArtist::getInstance();  //SINGLETON creo o devuelvo la instancia
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
    public function artistView(){
        if ($_SESSION['user']->getRole() === 'admin') {
            try{
                
                $artists = $this->daoArtist->readAll();   //con esto guardo un arreglo de objetos artistas traido de la base de datos mapeado?
                
            }	catch(Exception $e){
                    throw $e;

            }	finally {
                require(ROOT . 'views/header.php');
                require(ROOT .'views/manageArtist.php');
                require(ROOT . 'views/footer.php');
            }
        }else {
            $this->home->index();
        }    

    }
    /**
    *
    */
    
    public function add($name,  $description){
        if ($_SESSION['user']->getRole() === 'admin') {
            if (isset($_FILES['photo'])) {   // trim suprime espacios en blanco, pregunto si esta seteado $_FILES[photo] y de name osea pasaron una foto..
                $photo = $_FILES['photo']; 

            }else{

                $photo = null;
            }

            try {

                $pathPhoto = new Photo();
                $pathPhoto->uploadPhoto($photo, "artists");   // subir la $photo a la carpeta en este caso "artists"

                $_artist = new Artist($name, $description, $pathPhoto->getPath()); // creo el objeto artista
                $this->daoArtist->create($_artist);
            } 
            catch(\PDOException $ex) {
                throw $ex;
            } 
            finally{
                    $this->artistView();
            }
        }else {
            $this->home->index();
        }    
    }


public function modify($idModif, $artistName, $description){   // cargo los valores modificados
    if ($_SESSION['user']->getRole() === 'admin') {
        if (isset($_FILES['photo'])) {   // trim suprime espacios en blanco, pregunto si esta seteado $_FILES[photo] y de name osea pasaron una foto..
            $photo = $_FILES['photo']; 

        }else{

            $photo = null;
        }

        try {
            $pathPhoto = new Photo();
            $pathPhoto->uploadPhoto($photo, "artists");   // subir la $photo a la carpeta en este caso "artists"        

            $artist = new Artist($artistName, $description, $pathPhoto->getPath()); // creo el objeto artista 
            
            $this->daoArtist->update($idModif, $artist); 
        } 
        catch(\PDOException $ex) {
            throw $ex;
        } 
        finally{
            $this->artistView();
        }
    }else {
        $this->home->index();
    }    
}

public function delete($id){
    if ($_SESSION['user']->getRole() === 'admin') {
        try{
            $mensaje="";

            $this->daoArtist->delete($id); 

        }	catch(Exception $e){
            $mensaje= $e->getMessage();

        }	finally{

            if(!empty($mensaje)){
                echo '<script>alert("' . $mensaje . '")</script>';
            }
            $this->artistView();
        }
    }else {
        $this->home->index();
    }    
}

}

?>
