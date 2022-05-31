<?php namespace models;

use Exception as Exception;

	/**
	*
	*/
	class Photo{

		private $path;

		public function uploadPhoto($photo, $folder){     //a $photo le llega $_FILES['photo'] y a folder  

			$allowedFolders= array("artists");  // array en el que indico que folders estan permitidas para guardar las photos

			if (!empty($photo)) {

				if (in_array($folder, $allowedFolders)) {   // verifico si el dato del parametro "folder" se encuentra dentro del array folders permitidas
					$imageDirectory = ROOT . 'images/' . $folder . '/';  // ej: TP_FINAL/images/artists/


					if(!file_exists($imageDirectory)){
						mkdir($imageDirectory);  // para crear el directorio si no existe

					}

					if($photo['name'] != ''){  // si la foto tiene nombre 

						$allowedTypes= array('png', 'jpg');  // guardo las extensiones permitidas
						$maxSize= 5000000; // tamaño
						$fileName= $photo['name'];  // guardo el nombre de la foto

						$file = $imageDirectory . $fileName; // donde lo voy a guardar con el nombre "name "   ej: TP_FINAL/images/artists/metallica 

						// $file = img/folder/abc.jpg
						$fileExtension = pathinfo($file, PATHINFO_EXTENSION); // guardo la extension (jpg o png)
						// $fileExtension = jpg

						if(in_array($fileExtension, $allowedTypes)){ // verifico si la extension esta entre los tipos permitidos

							if($photo['size'] < $maxSize){ // comparo tamaños photos

								if(move_uploaded_file($photo["tmp_name"], $file)){    //  muevo el archivo temporal a la ruta donde quiero guard

									$ruta= FRONT_ROOT . 'images/' . $folder . '/' . $fileName;
									$this->path = $ruta;

								}	else
								throw new Exception("Error al mover la photo.");

							}	else
							throw new Exception("Error, Se excedio el tamaño permitido.");

						}	else
						throw new Exception("Error, formato de photo no permitida.");

					}	else
					throw new Exception("Error, pongale un nombre a la photo.");

				}	else
				throw new Exception("Error, selecciono la folder de destino incorrecta.");

			}	else
			$this->path= null;

		}

		public function getPath(){
			return $this->path;
		}

		public function setpath($newVal){
			return $this->path= $newVal;
		}
	}

	?>
