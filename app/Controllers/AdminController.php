<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function dashboard(): ResponseInterface
    {
        return $this->response->setJSON(['message' => 'Área administrativa']);
    }
}
