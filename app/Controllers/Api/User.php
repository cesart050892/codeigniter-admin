<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Users', false);
    }

    public function create()
    {
        try {
            $rules_income = [ // Rules validations
                'name' => 'required',
                'surname' => 'required',
                'email' => 'required|valid_email|is_unique[users.email]',
                'username' => 'required|is_unique[users.username]',
                'password' => 'required',
            ];
            if ($this->validate($rules_income)) { // Execute validation
                unset($rules_income);
                $route = ['/img/users', $this->request->getVar("username").'-profile.jpg'];
                $data = [
                    "name"        => $this->request->getVar("name"),
                    "surname"    => $this->request->getVar("surname"),
                    "username"    => $this->request->getVar("username"),
                    "email"        => $this->request->getVar("email"),
                    "password"    => $this->request->getVar("password"),
                    'img'         =>    $route[0]."/".$route[1],
                    'display'         =>    ''
                ];
                $user = new \App\Entities\Users($data);
                if ($this->model->save($user)) {
                    $file = $this->request->getFile('image');
                    $file->move(".".$route[0],$route[1]);
                    unset($data);
                    return $this->respond(array(
                        "status"    => 200,
                        "message"     => "Welcome! " . $user->username,
                        "data"        => [
                            "username"     => $user->username,
                            "email"        => $user->email
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

    public function profile()
    {
        try {
            //
            $user = $this->model->find(session()->user_id);
            $user->ignorePass();
            return $this->respond($user);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function logout()
    {
        try {
            $session = session();
            $session->destroy();
            return $this->respond(array(
                'status'    => 200,
                'message'    => 'See you next time!',
                'data'        => null
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function index()
    {
        try {
            $users = $this->model->findAll();
            foreach ($users as $user) {
                $user->ignorePass();
            }
            return $this->respond(array(
                'data'    => $users
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function delete($id = null)
    {
        try {
            $this->model->delete($id);
            return $this->respond(array(
                'message'    => 'Deleted'
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}
