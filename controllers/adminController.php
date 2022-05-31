<?php namespace controllers;

use model\Usuario as M_Usuario;

use controllers\UserController as UserController;

use dao\User as D_User;

     /**
      *
      */
     class AdminController
     {
          private $userController;

          function __construct() {
               $this->userController = new UserController();

          }


          /**
           *
           */
          public function index($_user = null, $_pass = null) {

               $showDashboard = false; // Esto se vuelve true solo si hay un admin logueado.

               // Verifico si existe un admin logueado. Le paso la responsabilidad a UserController de verificarlo
               if($user = $this->userController->checkSession()) {
                    if($user->getRole() == 1)
                         $showDashboard = true;
                    else
                         $alert = "No tiene permisos de administrador.";
               } else {

                    // Si no hay usuario logueado pero viene un usuario como parametro, es un intento de logueo.
                    if(isset($_user)) {

                         // Intento loguear. Le paso la responsabilidad a UserController. Si es true, muetro home. Caso contrario sigo...
                         if($user = $this->userController->login($_user, $_pass)) {
                              if($user->getRole() == 1)
                                   $showDashboard = true;
                              else
                                   $alert = "No tiene permisos de administrador.";

                         } else {
                              $alert = "Datos incorrectos, vuelva a intentar.";
                         }
                    }
               }

               include_once VIEWS . '/header.php';

               if($showDashboard)
                    include_once ADMIN_VIEWS . '/dashboard.php';
               else
                    include_once ADMIN_VIEWS . '/login.php';

               include_once VIEWS . '/footer.php';
          }

          /**
           * showList
           * Este método es común para cualquier $element (user, movie, serie) y dispara vistas $action (edit.php, list.php o add-form.php).
           *
           * @param String $aListar   El dato debe concidir con la tabla de la base de datos que se quiere consultar.
           */
          public function show($action, $element, $value = null) {

               if($user = $this->userController->checkSession()) {
                    if($user->getRole() != 1) {
                         $alert = "No tiene permisos para acceder a esta pagina.";
                    } else {
                         switch ($element) {
                              case 'user' :
                                   $dao = new D_User();
                                   $title = "Usuarios";
                                   break;
                              case 'movie' :
                                   $dao = new D_Pelicula();
                                   $title = "Peliculas";
                                   break;
                              case 'serie' :
                                   $dao = new D_Serie();
                                   $title = "Series";
                                   break;
                              case 'documental' :
                                   $dao = new D_Documental();
                                   $title = "Documentales";
                                   break;
                              case 'musical' :
                                   $dao = new D_Musical();
                                   $title = "Musicales";
                                   break;
                         }

                         switch ($action) {
                              case 'list':
                                   $list = $dao->readAll();
                                   break;
                              case 'edit':
                                   if(isset($value)) {
                                        $elementToEdit = $dao->read($value);
                                        if($elementToEdit == false)
                                             $alertinner = "El $element $value no se encontró en la base de datos.";
                                   } else {
                                        $alertinner = 'El elemento a editar no se encontró.';
                                   }

                                   break;
                         }

                    }
               } else {
                    $alert = "Se produjo un error, vuelva a iniciar sesión";
               }

               include_once VIEWS . '/header.php';

               if(isset($alert))
                    include_once VIEWS . '/login.php';
               else
                    include_once VIEWS . "/admin/$action.php";

               include_once VIEWS . '/footer.php';
          }

     }
