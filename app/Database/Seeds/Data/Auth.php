<?php

namespace App\Database\Seeds\Data;

use CodeIgniter\Database\Seeder;

class Auth extends Seeder
{
	public function run()
	{
		//
		$model = model('App\Models\Auth', false);
		$data = [
			[
				'username'	=>	'cesart050892',
				'password'	=>	'admin',
				'email'		=>	'cesart050892@gmail.com',
				'user_fk'	=> 1
			],
			[
				'name'		=>	'Administrator',
				'username'	=>	'admin',
				'password'	=>	'admin',
				'email'		=>	'admin@crm.dev',
				'user_fk'	=> 2
			],
			[
				'name'		=>	'Guest',
				'username'	=>	'guest',
				'password'	=>	'guest',
				'email'		=>	'guest@crm.dev',
				'user_fk'	=> 3
			]
		];
		foreach ($data as $key) {
			$user = new \App\Entities\Auth($key);
			$model->insert($user);
		}
	}
}
