<?php

namespace App\Controllers;

use App\Models\ProfessionalProfileModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\BrazilianStates;

class ProfessionalProfileController extends BaseController
{
    public function edit(): string
    {
        $profile = $this->currentProfile();
        $profile['name'] = (new UserModel())->find((int) session()->get('user_id'))['name'];

        return view('professional/profile', [
            'title'            => 'Meu perfil',
            'activeNav'        => 'profile',
            'profile'          => $profile,
            'success'          => session()->getFlashdata('success'),
            'error'            => session()->getFlashdata('error'),
            'validationErrors' => session()->getFlashdata('validationErrors') ?? [],
            'oldInput'         => session()->getFlashdata('oldInput') ?? [],
            'states'           => BrazilianStates::STATES,
        ]);
    }

    public function update(): ResponseInterface
    {
        $profile = $this->currentProfile();
        $userId  = (int) session()->get('user_id');
        $data    = [
            'name'         => trim($this->postString('name')),
            'phone'        => trim($this->postString('phone')),
            'whatsapp'     => trim($this->postString('whatsapp')),
            'city'         => trim($this->postString('city')),
            'state'        => strtoupper(trim($this->postString('state'))),
            'neighborhood' => trim($this->postString('neighborhood')),
            'description'  => trim($this->postString('description')),
        ];

        if (! $this->validateData($data, [
            'name'         => 'required|max_length[150]',
            'phone'        => 'permit_empty|max_length[20]',
            'whatsapp'     => 'required|max_length[20]',
            'city'         => 'required|max_length[100]',
            'state'        => 'required|in_list[' . implode(',', array_keys(BrazilianStates::STATES)) . ']',
            'neighborhood' => 'permit_empty|max_length[100]',
            'description'  => 'permit_empty|max_length[5000]',
        ], [
            'name' => [
                'required'   => 'Informe seu nome.',
                'max_length' => 'O nome deve ter no máximo 150 caracteres.',
            ],
            'phone' => ['max_length' => 'O telefone deve ter no máximo 20 caracteres.'],
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
            'description' => ['max_length' => 'A descrição deve ter no máximo 5000 caracteres.'],
        ])) {
            return $this->validationFailure($data, $this->validator->getErrors());
        }

        $photo = $this->request->getFile('photo');
        $hasPhoto = $photo instanceof UploadedFile && $photo->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasPhoto && ! $this->validateData(['photo' => ''], [
            'photo' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpeg,image/png,image/webp]|max_size[photo,2048]',
        ], [
            'photo' => [
                'uploaded' => 'Selecione uma imagem válida.',
                'is_image' => 'O arquivo precisa ser uma imagem.',
                'mime_in'  => 'Use uma imagem JPG, PNG ou WEBP.',
                'max_size' => 'A foto deve ter no máximo 2 MB.',
            ],
        ])) {
            return $this->validationFailure($data, $this->validator->getErrors());
        }

        $oldPhoto = $profile['photo'];
        $newPhoto = null;
        $uploadDirectory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'profiles';

        if ($hasPhoto) {
            if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0755, true) && ! is_dir($uploadDirectory)) {
                log_message('error', 'Não foi possível criar o diretório de fotos profissionais.');

                return redirect()->back()->with('error', 'Não foi possível salvar a foto. Tente novamente.');
            }

            if (! is_writable($uploadDirectory)) {
                log_message('error', 'O diretório de fotos profissionais não permite gravação.');

                return redirect()->back()->with('error', 'Não foi possível salvar a foto. Tente novamente.');
            }

            $extension = $photo->guessExtension();

            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                return $this->validationFailure($data, ['photo' => 'Use uma imagem JPG, PNG ou WEBP.']);
            }

            $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

            try {
                $photo->move($uploadDirectory, $fileName);
            } catch (\RuntimeException $exception) {
                log_message('error', 'Falha ao armazenar foto profissional: {message}', [
                    'message' => $exception->getMessage(),
                ]);

                return redirect()->back()->with('error', 'Não foi possível salvar a foto. Tente novamente.');
            }

            $newPhoto = 'uploads/profiles/' . $fileName;
        }

        $db = db_connect();
        $profileModel = new ProfessionalProfileModel();
        $userModel = new UserModel();

        try {
            if (! $db->transBegin()) {
                throw new DatabaseException('Não foi possível iniciar a transação do perfil profissional.');
            }

            $profileData = [
                'phone'        => $data['phone'] !== '' ? $data['phone'] : null,
                'whatsapp'     => $data['whatsapp'],
                'city'         => $data['city'],
                'state'        => $data['state'],
                'neighborhood' => $data['neighborhood'] !== '' ? $data['neighborhood'] : null,
                'description'  => $data['description'] !== '' ? $data['description'] : null,
            ];

            if ($newPhoto !== null) {
                $profileData['photo'] = $newPhoto;
            }

            if (! $profileModel->update((int) $profile['id'], $profileData)
                || ! $userModel->update($userId, ['name' => $data['name']])
                || ! $db->transStatus()
                || ! $db->transCommit()) {
                throw new DatabaseException('Não foi possível atualizar o perfil profissional.');
            }
        } catch (DatabaseException $exception) {
            $db->transRollback();
            $this->removeUploadedFile($newPhoto);
            log_message('error', 'Falha ao atualizar perfil profissional: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Não foi possível atualizar seu perfil. Tente novamente.')
                ->with('oldInput', $data);
        }

        session()->set('user_name', $data['name']);

        if ($newPhoto !== null) {
            $this->removeUploadedFile($oldPhoto);
        }

        return redirect()->to(site_url('professional/profile'))
            ->with('success', 'Perfil atualizado com sucesso.');
    }

    public function toggleStatus(): ResponseInterface
    {
        $profile = $this->currentProfile();
        $active = $this->postString('active');

        if (! in_array($active, ['0', '1'], true)) {
            return redirect()->to(site_url('professional/profile'))
                ->with('error', 'Situação de perfil inválida.');
        }

        if (! (new ProfessionalProfileModel())->update((int) $profile['id'], ['active' => (int) $active])) {
            log_message('error', 'Não foi possível alterar a situação do perfil profissional {id}.', [
                'id' => $profile['id'],
            ]);

            return redirect()->to(site_url('professional/profile'))
                ->with('error', 'Não foi possível alterar a situação do perfil. Tente novamente.');
        }

        $message = $active === '1'
            ? 'Seu perfil está ativo e pode aparecer no catálogo.'
            : 'Seu perfil foi desativado e não aparece mais no catálogo.';

        return redirect()->to(site_url('professional/profile'))->with('success', $message);
    }

    /**
     * @return array<string, mixed>
     */
    private function currentProfile(): array
    {
        $profile = (new ProfessionalProfileModel())
            ->where('user_id', (int) session()->get('user_id'))
            ->first();

        if ($profile === null) {
            throw PageNotFoundException::forPageNotFound('Perfil profissional não encontrado.');
        }

        return $profile;
    }

    private function postString(string $key): string
    {
        $value = $this->request->getPost($key);

        return is_string($value) ? $value : '';
    }

    /**
     * @param array<string, string> $data
     * @param array<string, string> $errors
     */
    private function validationFailure(array $data, array $errors): ResponseInterface
    {
        return redirect()->back()
            ->with('validationErrors', $errors)
            ->with('oldInput', $data);
    }

    private function removeUploadedFile(?string $path): void
    {
        if ($path === null || ! str_starts_with($path, 'uploads/profiles/')) {
            return;
        }

        $file = FCPATH . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        if (is_file($file) && ! unlink($file)) {
            log_message('error', 'Não foi possível remover foto profissional antiga: {path}', [
                'path' => $path,
            ]);
        }
    }
}
