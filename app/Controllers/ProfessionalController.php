<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class ProfessionalController extends BaseController
{
    public function dashboard(): ResponseInterface
    {
        return $this->response->setJSON(['message' => 'Área do profissional']);
    }
}
