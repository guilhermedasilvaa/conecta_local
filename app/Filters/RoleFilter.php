<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = (int) session()->get('user_id');

        if ($userId < 1) {
            return redirect()->to(site_url('login'));
        }

        $user = (new UserModel())->find($userId);

        if ($user === null || (int) $user['active'] !== 1) {
            session()->destroy();

            return redirect()->to(site_url('login'));
        }

        $allowedRoles = $arguments ?? [];

        if (in_array($user['role'], $allowedRoles, true)) {
            session()->set('user_role', $user['role']);

            return null;
        }

        if ($user['role'] === 'admin') {
            return redirect()->to(site_url('admin/dashboard'));
        }

        if ($user['role'] === 'professional') {
            return redirect()->to(site_url('professional/dashboard'));
        }

        session()->destroy();

        return redirect()->to(site_url('login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
