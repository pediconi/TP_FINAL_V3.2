<?php
	namespace models;

/**
 * @author gianf
 * @version 1.0
 * @created 11-oct.-2017 10:54:42
 */
class Cliente{

	private $id;
	private $nombre;
	private $apellido;
	private $dni;
	private $fechaNacimiento;
	private $direccion;
	private $localidad;
	private $telefono;

	function __construct($nombre='', $apellido='', $dni='', $fechaNacimiento='', $direccion= '', $localidad='', $telefono=''){

		$this->id= null;
		$this->nombre= $nombre;
		$this->apellido= $apellido;
		$this->dni= $dni;
		$this->fechaNacimiento= $fechaNacimiento;
		$this->direccion=$direccion;
		$this->localidad= $localidad;
		$this->telefono= $telefono;
	}


	public function getId()
	{
		return $this->id;
	}

	public function getNombre()
	{
		return $this->nombre;
	}

	public function getApellido()
	{
		return $this->apellido;
	}

	public function getDNI()
	{
		return $this->dni;
	}

	public function getFechaNacimiento()
	{
		return $this->fechaNacimiento;
	}

	public function getDireccion(){
		return $this->direccion;
	}


	public function getLocalidad()
	{
		return $this->localidad;
	}

	public function getTelefono()
	{
		return $this->telefono;
	}
	
	/**
	 * 
	 * @param newVal
	 */
	public function setApellido($newVal)
	{
		$this->apellido = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setDNI($newVal)
	{
		$this->dni = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setFechaNacimiento($newVal)
	{
		$this->fechaNacimiento = $newVal;
	}	

	/**
	 * 
	 * @param newVal
	 */
	public function setDireccion($newVal)
	{
		$this->direccion = $newVal;
	}	


	/**
	 * 
	 * @param newVal
	 */
	public function setNombre($newVal)
	{
		$this->nombre = $newVal;
	}

	/**
	 * 
	 * @param newVal
	 */
	public function setTelefono($newVal)
	{
		$this->telefono = $newVal;
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
	public function setLocalidad($newVal)
	{
		$this->localidad = $newVal;
	}

	
}
?>