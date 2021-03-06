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
				//'surname' => 'required',
				'email' => 'required|valid_email|is_unique[auth.email]',
				'username' => 'required|is_unique[auth.username]',
				'password' => 'required',
				'pass_confirm' => 'required|matches[password]',
			];
			if ($this->validate($rules_income)) { // Execute validation
				unset($rules_income);
				$data = [
					"name"		=> $this->request->getVar("name"),
					"surname"	=> $this->request->getVar("surname"),
					'display' 		=>	''
				];
				$user = new \App\Entities\Users($data);
				if ($this->model->save($user)) {
					$data = [
						"username"	=> $this->request->getVar("username"),
						"email"		=> $this->request->getVar("email"),
						"password"	=> $this->request->getVar("password"),
						"user_fk"   => $this->model->insertID()
					];
					$authModel = model('App\Models\Auth', false);
					$user = new \App\Entities\Auth($data);
					if($authModel->save($user)){
						return $this->respond(array(
							"status"	=> 200,
							"message" 	=> "Welcome! " . $user->username,
							"data"		=> [
								"username" 	=> $user->username,
								"email"		=> $user->email
							]
						));
					}else{
						return $this->fail($authModel->validator->getErrors());
					}
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


	public function login()
	{
		//
		try {
			$rules_income = [ // Rules validations
				'username' => 'required',
				'password' => 'required|min_length[4]', //validate_user[username,password]
			];
			if ($this->validate($rules_income)) { // Execute validation
				$data = [$this->request->getVar('username'), $this->request->getVar('password')];
				$authModel = model('App\Models\Auth', false);
				$results = $authModel->where('username', $data[0])->first(); // Verify exist username
				if ($results == null) return $this->fail('This user no exist!');
				if (password_verify($data[1], $results->password)) { // Verify password
					$session_data = [ // Session data
						'base_url'  => base_url(),
						'user_img'  => $results->img,
						'user_name' => $results->name,
						'user_nick' => $results->nick,
						'user_fullname' => $results->fullname,
						'user_id' => $results->id,
						'isLoggedIn' => true
					];
					session()->set($session_data);
					return $this->respond([
						'status' => 200,
						'message' => 'logged in',
						'data' => [
							'username' => $results->username,
							'name' =>  $results->fullname,
							'created_at' => $results->created_at->humanize(),
						]
					], 200);
				} else {
					return $this->failValidationErrors('Invalid password');
				}
			} else {
				return $this->fail($this->validator->getErrors());
			}
		} catch (\Throwable $e) {
			//throw $e;
			return $this->failServerError($e->getMessage());
		}
	}
}
