<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
	public function __construct()
	{
		$this->model = model('App\Models\Users', false);
	}

	public function signup()
	{
		try {
			$rules_income = [ // Rules validations
				'name' => 'required',
				'surname' => 'required',
				'email' => 'required|valid_email|is_unique[users.email]',
				'username' => 'required|is_unique[users.username]',
				'password' => 'required',
				'pass_confirm' => 'required|matches[password]',
			];
			if ($this->validate($rules_income)) { // Execute validation
				unset($rules_income);
				$data = [
					"name"		=> $this->request->getVar("name"),
					"surname"	=> $this->request->getVar("surname"),
					"username"	=> $this->request->getVar("username"),
					"email"		=> $this->request->getVar("email"),
					"password"	=> $this->request->getVar("password"),
				];
				$data += ['display_name' => $this->request->getVar("name") . " " . $this->request->getVar("surname")];
				$user = new \App\Entities\Users($data);
				unset($data);
				if ($this->model->save($user)) {
					return $this->respond(array(
						"status"	=> 200,
						"message" 	=> "Welcome! " . $user->username,
						"data"		=> [
							"username" 	=> $user->username,
							"email"		=> $user->email
						]
					));
				} else {
					return $this->fail($this->model->validator->getErrors());
				}
			} else {
				return $this->fail($this->validator->getErrors());
			}
		} catch (\Throwable $e) {
			return $this->failServerError($e->getMessage());
		}
	}
}
