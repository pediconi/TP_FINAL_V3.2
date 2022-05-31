<?php
	namespace models;

	use Modelo\Cliente as Cliente;

/**
 * @author gianf
 * @version 1.0
 * @created 11-oct.-2017 10:54:42
 */
class Cuenta{

	private $id;
	private $persona; //es el cliente
	private $email;	
	private $contrasenia;
	private $foto;
	private $tipoUsuario; 


	//Este parametro recive una foto de tipo Foto?????????????????????????????????????
	function __construct(Cliente $persona, $email='', $contrasenia='', $rutaFoto=''){
		$this->id=null;
		$this->persona= $persona;
		$this->email= $email;
		$this->contrasenia= $contrasenia;
		$this->foto= $rutaFoto; //foto se guarda como un string ahora
		$this->tipoUsuario= 'Cliente';
	}

	public function getId()
	{
		return $this->id;
	}

	public function getPersona()
	{
		return $this->persona;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getContrasenia()
	{
		return $this->contrasenia;
	}

	public function getFotoPerfil(){

		return $this->foto;
	}

	public function getTipoUsuario()
	{
		return $this->tipoUsuario;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setId($newVal)
	{
		$this->id = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setPersona(Cliente $newVal)
	{
		$this->persona = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setContrasenia($newVal)
	{
		$this->contrasenia = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setEmail($newVal)
	{
		$this->email = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFotoPerfil($newVal)
	{
		$this->foto = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTipoUsuario($newVal)
	{
		$this->tipoUsuario = $newVal;
	}

}
?>