<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    public function index(): ResponseInterface
    {
        return $this->response
            ->setStatusCode(501)
            ->setJSON(['message' => 'O gerenciamento de serviços ainda não foi implementado.']);
    }
}
