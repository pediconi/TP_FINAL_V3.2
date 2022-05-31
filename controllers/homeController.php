<?php    namespace controllers;

use controllers\ArtistController as ArtistCont ;
use dao\Artist as DaoArtist;
use config\Singleton as Singleton;
use dao\Event as DaoEvent;
use dao\Calendar as DaoCalendar;
use session\Session as Session;


class HomeController extends Singleton{

    private $daoArtist;
    private $daoEvent;
    private $daoCalendar;

    function __construct(){
        $this->daoCalendar = DaoCalendar::getInstance();
        $this->daoEvent = DaoEvent::getInstance();
        $this->daoArtist = DaoArtist::getInstance();             
        try{
            Session::start();
        }catch (Exception $ex) {
            throw $ex;
       }
    }

    public function index(){
        
       try{
            $calendars = $this->daoCalendar->readAll();

            $idArtists = $this->daoArtist->getArtistsCalendar();


            for ($x=0;$x<count($idArtists); $x++) { 
                $artists[$x] = $this->daoArtist->read($idArtists[$x][0]);
            }
        }
        catch(Exception $e){
            throw $e;
        }
            
        
        if(isset($_SESSION['user'])) {
            require(ROOT .'views/header.php');        
            require(ROOT .'views/index.php');  
            require(ROOT .'views/footer.php');
        } else {
            require(ROOT .'views/login.php');
        }

    }

    public function searchView($search){
        
        try{
            $artist = $this->daoArtist->getByNameArtist($search);

            if($artist){
                $idCalendars = $this->daoCalendar->getByIdArtist($artist[0]->getId());
                $calendars = $this->daoCalendar->read($idCalendars[0][0]);
                $idArtists = $this->daoArtist->getByIdCalendar($calendars[0]->getId());

                for ($x=0;$x<count($idArtists); $x++) { 
                    $artists[$x] = $this->daoArtist->read($idArtists[$x][0]);
                }
            }else{
                $calendars = $this->daoCalendar->getByText($search);
                $idArtists = $this->daoArtist->getByIdCalendar($calendars[0]->getId());

                for ($x=0;$x<count($idArtists); $x++) { 
                    $artists[$x] = $this->daoArtist->read($idArtists[$x][0]);
                }
            }

        }
        catch(Exception $e){
            throw $e;
        }
        if(isset($_SESSION['user'])) {
            $user = $_SESSION['user'];    
            require(ROOT .'views/header.php');        
            require(ROOT .'views/index.php');  
            require(ROOT .'views/footer.php');
        } else {
            require(ROOT .'views/login.php'); 
        }


    }
}

    




    



