<?php  
namespace Controladora;

use Modelo\Cuenta as Cuenta;
use Modelo\Cliente as Cliente;
use Modelo\Foto as Foto;

use Dao\BD\DaoBDCuenta as DaoCuenta;

use Exception;

	/**
	* 
	*/
	class GestionCuentaControladora{
		
		private $daoCuenta;
		

		function __construct(){
			
			$this->daoCuenta= DaoCuenta::getInstance();
		}

		public function vistaLoginRegistrar(){

			require(ROOT . 'Vistas/TemplateBase/header.php');
			require(ROOT . 'Vistas/TemplateBase/navHeader.php');
			require(ROOT . 'Vistas/Cuenta/loginRegistrar.php');
			require(ROOT . 'Vistas/TemplateBase/footer.php');
		}

		public function vistaModificar(){
			
			require(ROOT . 'Vistas/TemplateBase/header.php');
			require(ROOT . 'Vistas/Cuenta/Registrar/modificarCuenta.php');
			require(ROOT . 'Vistas/TemplateBase/footer.php');
		}

		public function registrar($nombre, $apellido, $dni, $telefono, $localidad, $fecha, $direccion, $email, $contrasenia1, $contrasenia2){

			if (!empty($_FILES['foto']['name'])) {
				$foto= $_FILES['foto'];

			}	else{
				$foto= null;
			}
			
			try{
				$mensaje= "ok";

				$emailBuscado = $this->daoCuenta->buscar($email);

				if ($emailBuscado == null) {

					$this->igualdadContrasenias($contrasenia1, $contrasenia2);

					$rutaFoto= new Foto();
					$rutaFoto->subirFoto($foto, "Perfiles");

					$fechita = str_replace('/', '-', $fecha);
					
					$cliente= new Cliente($nombre, $apellido, $dni, $fechita, $direccion, $localidad, $telefono);
					$cuenta= new Cuenta($cliente, $email, $contrasenia1, $rutaFoto->getDireccion());
					$this->daoCuenta->insertar($cuenta);
				
				}	else{
					throw new Exception("Email ya Cargado");
					
				}

			}	catch(Exception $e){

				$mensaje= $e->getMessage();

			}	finally{
				
				if(!empty($mensaje)){
					echo $mensaje; 

				}
			}
		}

		public function login($email, $contra){

			try{
				$mensaje= "ok";

				$cuenta= $this->daoCuenta->buscarCuentaLogin($email, $contra);

				$_SESSION['cuentaUsuario'] = $cuenta;

			}	catch(Exception $e){

				$mensaje= $e->getMessage();

			}	finally{

				echo $mensaje; 
				
			}
		}

		private function igualdadContrasenias($contra1, $contra2){

			if(trim($contra1) !== trim($contra2)){
				throw new Exception("Las contraseñas no coinciden");
				
			}
		}

		public function cerrarSession(){

			session_unset();
			session_destroy();
			
			header('Location: ' . BASE . 'paginaPrincipal/inicio');
		}
	}
	?>