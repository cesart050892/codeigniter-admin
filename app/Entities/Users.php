<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;

class Users extends Entity
{
	protected $attributes = [
        'id' => null,
        'name' => null,        
        'surname' => null,
		'phone' => null,
		'address' => null,
		'display' => null,
		'img' => null,
        'created_at' => null,
        'updated_at' => null,
		'deleted_at' => null,
    ];

	protected $datamap = [
		'fullname' => 'display',
		'nick'	   => 'username'
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];

	protected function setDisplay(string $data)
	{
		if(isset($this->attributes['surname'])){
			$this->attributes['display'] = $this->attributes['name'] ." ". $this->attributes['surname'];
		}else{
			$this->attributes['display'] = $this->attributes['name'];
		}
		return $this;
	}


	public function saveProfileImage(UploadedFile $image) {

		// tambien se podria establecer en la bd el campo img como null y utilizar una funcion en la entidad para obtener la imagen de perfil
		// asi mismo si el usuario cuenta con imagen se muestre la que tenga configurada o de lo contrario muestre la imagen por default 
		// debes aprovechar mas el uso de las entidades para abstraer tus reglas de negocio y que no todo quede en el controlador
		$newImage = $this->storeImage($image);

		if ($this->img !== '/img/default/profile.jpg') { 
			$this->deleteImage();
		}

		return $newImage;
	}

	private function storeImage(UploadedFile $image) {
		
		// - no recomiendo guardar los paths completos solo el nombre de la imagen es suficiente
		// - si vas a generar el nombre de las imagenes de esa forma los nicks necesitan ser unicos para evitar problemas 
		// puse un hash aleatorio adicional para solucionar ese bug por el momento
		$pathImage = "/img/users/{$this->nick}_{$image->getRandomName()}"; 

		if (!$image->isValid() || $image->hasMoved()) {
			return false;
		}

		try {
			$image->move(".",$pathImage);
		} catch (\Throwable $th) {
			return false;
		}

		return $pathImage;

	}

	private function deleteImage(): bool {

		// Define en una constante global el path del almacenamiento de los perfiles para no hardcodear de esa forma
		$baseDir = realpath($_SERVER["DOCUMENT_ROOT"]);
		$file    = "{$baseDir}/{$this->img}";

		if (!file_exists($file)) {
			return false;
		}

		return unlink($file);
	}
}
