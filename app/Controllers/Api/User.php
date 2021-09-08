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
                //'surname' => 'required',
                'email' => 'required|valid_email|is_unique[auth.email]',
                'username' => 'required|is_unique[auth.username]',
                'password' => 'required',
            ];
            if ($this->validate($rules_income)) { // Execute validation
                unset($rules_income);
                $data = [
                    "name"        => $this->request->getVar("name"),
                    "surname"    => $this->request->getVar("surname"),
                    "username"    => $this->request->getVar("username"),
                    "email"        => $this->request->getVar("email"),
                    "password"    => $this->request->getVar("password"),
                    'display'         =>    ''
                ];
                if ($this->validate(['image' => 'uploaded[image]|max_size[image,1024]'])) {
                    $route = ['/img/users', $this->request->getVar("username") . '-profile.jpg'];
                    $file = $this->request->getFile('image');
                    $file->move("." . $route[0], $route[1]);
                    $data += ['img'         =>    $route[0] . "/" . $route[1]];
                }
                $user = new \App\Entities\Users($data);
                if ($this->model->save($user)) {
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
            $user = $this->model->find($id);
            $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
            if ($user->img != '/img/default/profile.jpg') {
                $file_delete =  "$base_dir/$user->img";
                if (file_exists($file_delete)) {
                    if (unlink($file_delete)) {
                        $image = true;
                    }
                }
            }
            if ($this->model->delete($id)) {
                return $this->respond(array(
                    'message'    => 'Deleted'
                ));
            } else {
                return $this->fail($this->model->errors());
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function edit($id = null)
    {
        try {
            if ($user = $this->model->find($id)) {
                $user->ignorePass();
                return $this->respond(array(
                    'data'    => $user
                ));
            } else {
                return $this->failNotFound('This user can\'t be no found it');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function update($id = null)
    {
        try {
            $rules_income = [ // Rules validations
                'name' => 'required',
                'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
                'username' => 'required|is_unique[users.username,id,{id}]',
            ];
            if ($this->validate($rules_income)) { // Execute validation
                unset($rules_income);
                $data = [
                    "name"        => $this->request->getVar("name"),
                    "surname"    => $this->request->getVar("surname"),
                    "username"    => $this->request->getVar("username"),
                    "email"        => $this->request->getVar("email"),
                    "password"    => $this->request->getVar("password"),
                    'display'         =>    ''
                ];
                $user = $this->model->find($id);
                if ($this->validate(['image' => 'uploaded[image]|max_size[image,1024]'])) {
                    $base_dir = realpath($_SERVER["DOCUMENT_ROOT"]);
                    if ($user->img != '/img/default/profile.jpg') {
                        $file_delete =  "$base_dir/$user->img";
                        if (file_exists($file_delete)) {
                            if (unlink($file_delete)) {
                                $image = true;
                            }
                        }
                    }
                    $route = ['/img/users', $this->request->getVar("username") . '-profile.jpg'];
                    $file = $this->request->getFile('image');
                    $file->move("." . $route[0], $route[1]);
                    $data += ['img'         =>    $route[0] . "/" . $route[1]];
                }
                $user = new \App\Entities\Users($data);
                $user->id = $this->request->getVar("id");
                if ($this->model->save($user)) {
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
}
