<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Auth extends Entity
{
	protected $attributes = [
        'password' => null,
		'username' => null,
		'email' => null,
        'created_at' => null,
        'updated_at' => null,
		'deleted_at' => null,
    ];

	protected $datamap = [];

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
