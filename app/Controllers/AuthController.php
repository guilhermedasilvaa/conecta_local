<?php

namespace App\Controllers;

use App\Models\ProfessionalProfileModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use Config\BrazilianStates;

class AuthController extends BaseController
{
    public function loginForm(): string
    {
        return view('auth/login', $this->formFeedback('Entrar'));
    }

    public function registerForm(): string
    {
        return view('auth/register', $this->formFeedback('Cadastro profissional'));
    }

    public function login(): ResponseInterface
    {
        $data = [
            'email'    => strtolower(trim($this->postString('email'))),
            'password' => $this->postString('password'),
        ];

        if (! $this->validateData($data, [
            'email'    => 'required|valid_email|max_length[150]',
            'password' => 'required|max_length[255]',
        ], [
            'email' => [
                'required'    => 'Informe seu e-mail.',
                'valid_email' => 'Informe um e-mail válido.',
                'max_length'  => 'O e-mail deve ter no máximo 150 caracteres.',
            ],
            'password' => [
                'required'   => 'Informe sua senha.',
                'max_length' => 'A senha deve ter no máximo 255 caracteres.',
            ],
        ])) {
            return redirect()->back()
                ->with('validationErrors', $this->validator->getErrors())
                ->with('oldInput', ['email' => $data['email']]);
        }

        $user = (new UserModel())
            ->where('email', $data['email'])
            ->first();

        if (
            $user === null
            || (int) $user['active'] !== 1
            || ! password_verify($data['password'], $user['password'])
        ) {
            return redirect()->back()
                ->with('error', 'E-mail ou senha inválidos.')
                ->with('oldInput', ['email' => $data['email']]);
        }

        session()->regenerate(true);
        session()->set([
            'user_id'    => (int) $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
        ]);

        return redirect()->to($user['role'] === 'admin' ? site_url('admin/dashboard') : site_url('professional/dashboard'));
    }

    public function register(): ResponseInterface
    {
        $data = [
            'name'             => trim($this->postString('name')),
            'email'            => strtolower(trim($this->postString('email'))),
            'password'         => $this->postString('password'),
            'password_confirm' => $this->postString('password_confirm'),
            'whatsapp'         => trim($this->postString('whatsapp')),
            'city'             => trim($this->postString('city')),
            'state'            => strtoupper(trim($this->postString('state'))),
            'neighborhood'     => trim($this->postString('neighborhood')),
            'accept_terms'     => $this->postString('accept_terms'),
        ];

        try {
            $validData = $this->validateData($data, [
                'name'             => 'required|max_length[150]',
                'email'            => 'required|valid_email|max_length[150]|is_unique[users.email]',
                'password'         => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'required|matches[password]',
                'whatsapp'         => 'required|max_length[20]',
                'city'             => 'required|max_length[100]',
                'state'            => 'required|in_list[' . implode(',', array_keys(BrazilianStates::STATES)) . ']',
                'neighborhood'     => 'permit_empty|max_length[100]',
                'accept_terms'     => 'required|in_list[1]',
            ], [
                'name' => [
                    'required'   => 'Informe seu nome completo.',
                    'max_length' => 'O nome deve ter no máximo 150 caracteres.',
                ],
                'email' => [
                    'required'    => 'Informe seu e-mail.',
                    'valid_email' => 'Informe um e-mail válido.',
                    'max_length'  => 'O e-mail deve ter no máximo 150 caracteres.',
                    'is_unique'   => 'Este e-mail já está cadastrado.',
                ],
                'password' => [
                    'required'   => 'Informe uma senha.',
                    'min_length' => 'A senha deve ter pelo menos 8 caracteres.',
                    'max_length' => 'A senha deve ter no máximo 255 caracteres.',
                ],
                'password_confirm' => [
                    'required' => 'Confirme sua senha.',
                    'matches'  => 'A confirmação deve ser igual à senha informada.',
                ],
                'whatsapp' => [
                    'required'   => 'Informe seu WhatsApp.',
                    'max_length' => 'O WhatsApp deve ter no máximo 20 caracteres.',
                ],
                'city' => [
                    'required'   => 'Informe sua cidade.',
                    'max_length' => 'A cidade deve ter no máximo 100 caracteres.',
                ],
                'state' => [
                    'required' => 'Selecione seu estado.',
                    'in_list'  => 'Selecione um estado válido.',
                ],
                'neighborhood' => ['max_length' => 'O bairro deve ter no máximo 100 caracteres.'],
                'accept_terms' => [
                    'required' => 'É necessário aceitar os Termos de Uso e a Política de Privacidade.',
                    'in_list'  => 'É necessário aceitar os Termos de Uso e a Política de Privacidade.',
                ],
            ]);
        } catch (DatabaseException) {
            log_message('error', 'Falha ao validar os dados do cadastro profissional.');

            return $this->registrationFailure($data);
        }

        if (! $validData) {
            return redirect()->back()
                ->with('validationErrors', $this->validator->getErrors())
                ->with('oldInput', $this->registrationOldInput($data));
        }

        $db           = db_connect();
        $userModel    = new UserModel();
        $profileModel = new ProfessionalProfileModel();
        $transactionStarted = false;

        try {
            if (! $db->transBegin()) {
                log_message('error', 'Não foi possível iniciar a transação do cadastro profissional.');

                return $this->registrationFailure($data);
            }

            $transactionStarted = true;
            $userId = $userModel->insert([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'role'     => 'professional',
            ]);

            if ($userId === false) {
                $db->transRollback();
                log_message('error', 'Não foi possível criar o usuário profissional: {errors}', [
                    'errors' => json_encode($userModel->errors()),
                ]);

                return $this->registrationFailure($data);
            }

            $profileCreated = $profileModel->insert([
                'user_id'  => (int) $userId,
                'whatsapp' => $data['whatsapp'],
                'city'     => $data['city'],
                'state'    => $data['state'],
                'neighborhood' => $data['neighborhood'] !== '' ? $data['neighborhood'] : null,
            ]);

            if ($profileCreated === false || ! $db->transStatus()) {
                $db->transRollback();
                log_message('error', 'Não foi possível criar o perfil profissional: {errors}', [
                    'errors' => json_encode($profileModel->errors()),
                ]);

                return $this->registrationFailure($data);
            }

            if (! $db->transCommit()) {
                $db->transRollback();
                log_message('error', 'Não foi possível confirmar a transação do cadastro profissional.');

                return $this->registrationFailure($data);
            }
        } catch (DatabaseException) {
            if ($transactionStarted) {
                $db->transRollback();
            }

            log_message('error', 'Falha de banco de dados durante o cadastro profissional.');

            return $this->registrationFailure($data);
        }

        return redirect()->to(site_url('login'))
            ->with('success', 'Cadastro realizado. Faça login para continuar.');
    }

    public function logout(): ResponseInterface
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }

    private function formFeedback(string $title): array
    {
        return [
            'title'            => $title,
            'error'            => session()->getFlashdata('error'),
            'success'          => session()->getFlashdata('success'),
            'validationErrors' => session()->getFlashdata('validationErrors') ?? [],
            'oldInput'         => session()->getFlashdata('oldInput') ?? [],
            'states'           => BrazilianStates::STATES,
        ];
    }

    private function postString(string $key): string
    {
        $value = $this->request->getPost($key);

        return is_string($value) ? $value : '';
    }

    private function registrationOldInput(array $data): array
    {
        return [
            'name'         => $data['name'],
            'email'        => $data['email'],
            'whatsapp'     => $data['whatsapp'],
            'city'         => $data['city'],
            'state'        => $data['state'],
            'neighborhood' => $data['neighborhood'],
            'accept_terms' => $data['accept_terms'],
        ];
    }

    private function registrationFailure(array $data): ResponseInterface
    {
        return redirect()->back()
            ->with('error', 'Não foi possível concluir o cadastro. Tente novamente.')
            ->with('oldInput', $this->registrationOldInput($data));
    }
}
