<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Users', false);
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
}
