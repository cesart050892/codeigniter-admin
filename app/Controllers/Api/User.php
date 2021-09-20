<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Users', false);
        $this->db = \Config\Database::connect();
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
                    'display'         =>    ''
                ];
                if ($this->validate(['image' => 'uploaded[image]|max_size[image,1024]'])) {
                    $route = ['/img/users', $this->request->getVar("username") . '-profile.jpg'];
                    $file = $this->request->getFile('image');
                    $file->move("." . $route[0], $route[1]);
                    $data += ['img'         =>    $route[0] . "/" . $route[1]];
                }
                $user = new \App\Entities\Users($data);
                $this->db->transStart();
                if ($this->model->save($user)) {
                    $data = [
                        "username"    => $this->request->getVar("username"),
                        "email"        => $this->request->getVar("email"),
                        "password"    => $this->request->getVar("password"),
                        "user_fk"     => $this->model->insertID()
                    ];
                    $this->authModel = model('App\Models\Auth', false);
                    if ($this->authModel->save($data)) {
                        $this->db->transComplete();
                        return $this->respond(array(
                            "status"    => 200,
                            "message"     => "Welcome! " . $user->username,
                            "data"        => [
                                "username"     => $user->username,
                                "email"        => $user->email
                            ]
                        ));
                    } else {
                        return $this->fail($this->authModel->validator->getErrors());
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

    public function profile()
    {
        try {
            //
            $user = $this->model->getOne(session()->user_id);
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
            $users = $this->model->getAll();
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
                $this->model->purgeDeleted();
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
            if ($user = $this->model->getOne($id)) {
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
        // las reglas de validacion podrias reutilizarlas tanto para crear / actualizar investiga sobre el tema
            if (!$this->validate([
                "name" => 'required|max_length[75]',
                "surname"  => 'permit_empty|max_length[75]',

            ])) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            if (!$user = $this->model->getOne($id)) {
                return $this->failNotFound();
            }

            if ($file = $this->request->getFile('image')) {
                if ($this->validate([
                    "image" => 'is_image[image]|max_size[image,1024]|permit_empty' // moidifique el JS para aceptar pdf y testear la validacion
                ])) {
                    if ($file->isValid()) { // el usuario cambio la imagen
                        if (!$newImage = $user->saveProfileImage($file)) {
                            return $this->failValidationErrors('Image is no valid!');
                        }
                        $user->img = $newImage;
                    }
                }
            }

            $user = $user->fill($this->request->getPost(['surname', 'name', 'phone']));
            

            if (!$this->model->save($user)) {
                return $this->failValidationErrors($this->model->errors());
            }

            return $this->respondUpdated(['message' => 'ok!']);

    }
}
