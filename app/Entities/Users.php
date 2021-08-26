<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Users extends Entity
{
	protected $attributes = [
        'id' => null,
        'name' => null,        
        'surname' => null,
        'password' => null,
		'username' => null,
		'email' => null,
		'phone' => null,
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

	protected function setPassword(string $password)
	{
		$this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
		return $this;
	}

	public function ignorePass(){
		unset($this->attributes['password']);
		return $this;
	}
}
