<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Clients extends Seeder
{
	public function run()
	{
		//
		$model = model('App\Models\Clients', false);
		$data = [
			[
				'name'		=>	'Pedrito Jose',
				'surname'   => 	'Perez',
				'email-personal' =>	'pedrio@gmail.com',
				'display' 		=>	''
			],
			[
				'name'		=>	'Jose Alejandro',
				'surname'   => 	'Aleman',
				'email-job'		=>	'rrhh@crm.dev',
				'display' 		=>	''
			],
			[
				'name'		=>	'Juan Fernando',
				'surname'   => 	'Escorcia',
				'email-job'		=>	'sales@crm.dev',
				'display' 		=>	''
			]
		];
		foreach ($data as $key) {
			$user = new \App\Entities\Clients($key);
			$model->insert($user);
		}
	}
}
