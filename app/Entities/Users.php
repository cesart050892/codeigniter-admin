<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Users extends Entity
{
	protected $datamap = [
		'fullname' => 'display_name'
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];

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
