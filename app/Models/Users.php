<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = \App\Entities\Users::class;
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['name', 'surname', 'display', 'img', 'phone'];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	// Functions

	public function getAll(){

		return $this->select('
				users.id, 
				users.`name`, 
				users.surname, 
				users.display, 
				users.img, 
				users.phone, 
				users.address, 
				auth.email, 
				auth.username,
				auth.id AS auth,
				users.created_at,
				users.updated_at,
			')
			->join('auth', 'users.id = auth.user_fk' )
			->findAll();
			
	}

	public function getOne($id){
		return  $this->select('
		users.id, 
		users.`name`, 
		users.surname, 
		users.display, 
		users.img, 
		users.phone, 
		users.address, 
		auth.email, 
		auth.username,
		auth.id AS auth,
		users.created_at,
		users.updated_at,
		')
		->join('auth', 'users.id = auth.user_fk' )
		->where('users.id', $id)
		->first();
	}
}
