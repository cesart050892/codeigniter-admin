<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Clients extends Entity
{
	protected $attributes = [
        'id' => null,
        'name' => null,        
        'surname' => null,
        'phone1' => null,
		'phone2' => null,
		'email1' => null,
		'email2' => null,
		'display' => null,
		'ruc' => null,
        'created_at' => null,
        'updated_at' => null,
		'deleted_at' => null,
    ];

	protected $datamap = [
		'email-personal' => 'email1', 
		'email-job' => 'email2' ,
		'phone-personal' =>'phone1' , 
		'phone-job' => 'phone2' ,
		'fullname' => 'display'
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
	
}
