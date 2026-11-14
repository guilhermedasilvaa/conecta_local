<?php

namespace App\Controllers;

use App\Models\ProfessionalProfileModel;
use App\Models\ServiceModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProfessionalController extends BaseController
{
    public function dashboard(): string
    {
        $profile = $this->profileForCurrentUser();
        $serviceModel = new ServiceModel();
        $totalServices = $serviceModel
            ->where('professional_id', $profile['id'])
            ->countAllResults();
        $activeServices = $serviceModel
            ->where('professional_id', $profile['id'])
            ->where('active', 1)
            ->countAllResults();

        return view('professional/dashboard', [
            'title'          => 'Painel profissional',
            'activeNav'      => 'dashboard',
            'profile'        => $profile,
            'totalServices'  => $totalServices,
            'activeServices' => $activeServices,
            'success'        => session()->getFlashdata('success'),
            'error'          => session()->getFlashdata('error'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function profileForCurrentUser(): array
    {
        $profile = (new ProfessionalProfileModel())
            ->where('user_id', (int) session()->get('user_id'))
            ->first();

        if ($profile === null) {
            throw PageNotFoundException::forPageNotFound('Perfil profissional não encontrado.');
        }

        $profile['name'] = (string) session()->get('user_name');

        return $profile;
    }
}
