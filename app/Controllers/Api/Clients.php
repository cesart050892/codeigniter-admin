<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Clients extends ResourceController
{
    public function __construct()
    {
        $this->model = model('App\Models\Clients', false);
    }

    public function index()
    {
        try {
            $clients = $this->model->findAll();
            return $this->respond(array(
                'data' => $clients
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function delete($id = null)
    {
        try {
            $clients = $this->model->delete($id);
            return $this->respond(array(
                'message' => 'delete'
            ));
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}
