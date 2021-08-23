<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Clients extends Entity
{
	protected $datamap = [
		'email1' => 'email-personal',
		'email2' => 'email-job',
		'phone1' => 'phone-personal',
		'phone2' => 'phone-job',
	];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
	
}
