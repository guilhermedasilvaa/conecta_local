<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProfessionalProfileModel;
use App\Models\ServiceModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class ServiceController extends BaseController
{
    public function index(): string
    {
        $profile = $this->currentProfile();
        $services = db_connect()
            ->table('services')
            ->select([
                'services.id',
                'services.title',
                'services.description',
                'services.price',
                'services.active',
                'services.category_id',
                'categories.name AS category_name',
            ])
            ->join('categories', 'categories.id = services.category_id')
            ->where('services.professional_id', (int) $profile['id'])
            ->orderBy('services.created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('professional/services/index', [
            'title'            => 'Meus serviços',
            'activeNav'        => 'services',
            'services'         => $services,
            'success'          => session()->getFlashdata('success'),
            'error'            => session()->getFlashdata('error'),
            'validationErrors' => session()->getFlashdata('validationErrors') ?? [],
        ]);
    }

    public function new(): string
    {
        return $this->serviceForm(null);
    }

    public function create(): ResponseInterface
    {
        $profile = $this->currentProfile();
        $data = $this->serviceInput();
        $errors = $this->validateService($data);

        if ($errors !== []) {
            return $this->formFailure($data, $errors, site_url('professional/services/new'));
        }

        if (! $this->categoryIsActive((int) $data['category_id'])) {
            return $this->formFailure($data, ['category_id' => 'Selecione uma categoria ativa.'], site_url('professional/services/new'));
        }

        $serviceModel = new ServiceModel();

        try {
            $created = $serviceModel->insert([
                'professional_id' => (int) $profile['id'],
                'category_id'     => (int) $data['category_id'],
                'title'           => $data['title'],
                'description'     => $data['description'],
                'price'           => $this->normalizePrice($data['price']),
                'active'          => (int) $data['active'],
            ]);
        } catch (DatabaseException $exception) {
            log_message('error', 'Falha ao criar serviço profissional: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Não foi possível cadastrar o serviço. Tente novamente.')
                ->with('oldInput', $data);
        }

        if ($created === false) {
            log_message('error', 'Falha ao criar serviço profissional: {errors}', [
                'errors' => json_encode($serviceModel->errors()),
            ]);

            return redirect()->back()
                ->with('error', 'Não foi possível cadastrar o serviço. Tente novamente.')
                ->with('oldInput', $data);
        }

        return redirect()->to(site_url('professional/services'))
            ->with('success', 'Serviço cadastrado com sucesso.');
    }

    public function edit(int $id): string
    {
        $profile = $this->currentProfile();
        $service = $this->ownedService($id, (int) $profile['id']);

        return $this->serviceForm($service);
    }

    public function update(int $id): ResponseInterface
    {
        $profile = $this->currentProfile();
        $service = $this->ownedService($id, (int) $profile['id']);
        $data = $this->serviceInput();
        $errors = $this->validateService($data);

        if ($errors !== []) {
            return $this->formFailure($data, $errors, site_url('professional/services/' . $id . '/edit'));
        }

        $categoryId = (int) $data['category_id'];
        $existingCategoryId = (int) $service['category_id'];

        if ($categoryId !== $existingCategoryId && ! $this->categoryIsActive($categoryId)) {
            return $this->formFailure($data, ['category_id' => 'Selecione uma categoria ativa.'], site_url('professional/services/' . $id . '/edit'));
        }

        $serviceModel = new ServiceModel();

        try {
            $updated = $serviceModel
                ->where('professional_id', (int) $profile['id'])
                ->update($id, [
                    'category_id' => $categoryId,
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'price'       => $this->normalizePrice($data['price']),
                    'active'      => (int) $data['active'],
                ]);
        } catch (DatabaseException $exception) {
            log_message('error', 'Falha ao atualizar serviço profissional {id}: {message}', [
                'id'      => $id,
                'message' => $exception->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Não foi possível atualizar o serviço. Tente novamente.')
                ->with('oldInput', $data);
        }

        if (! $updated) {
            log_message('error', 'Falha ao atualizar serviço profissional {id}: {errors}', [
                'id'     => $id,
                'errors' => json_encode($serviceModel->errors()),
            ]);

            return redirect()->back()
                ->with('error', 'Não foi possível atualizar o serviço. Tente novamente.')
                ->with('oldInput', $data);
        }

        return redirect()->to(site_url('professional/services'))
            ->with('success', 'Serviço atualizado com sucesso.');
    }

    public function delete(int $id): ResponseInterface
    {
        $profile = $this->currentProfile();
        $service = $this->ownedService($id, (int) $profile['id']);

        if (! (new ServiceModel())->delete((int) $service['id'])) {
            log_message('error', 'Falha ao excluir serviço profissional {id}.', ['id' => $id]);

            return redirect()->to(site_url('professional/services'))
                ->with('error', 'Não foi possível excluir o serviço. Tente novamente.');
        }

        return redirect()->to(site_url('professional/services'))
            ->with('success', 'Serviço excluído com sucesso.');
    }

    public function toggleStatus(int $id): ResponseInterface
    {
        $profile = $this->currentProfile();
        $service = $this->ownedService($id, (int) $profile['id']);
        $active = $this->postString('active');

        if (! in_array($active, ['0', '1'], true)) {
            return redirect()->to(site_url('professional/services'))
                ->with('error', 'Situação de serviço inválida.');
        }

        if (! (new ServiceModel())->update((int) $service['id'], ['active' => (int) $active])) {
            log_message('error', 'Falha ao alterar situação do serviço profissional {id}.', ['id' => $id]);

            return redirect()->to(site_url('professional/services'))
                ->with('error', 'Não foi possível alterar a situação do serviço. Tente novamente.');
        }

        $message = $active === '1'
            ? 'Serviço ativado com sucesso.'
            : 'Serviço desativado e removido do catálogo público.';

        return redirect()->to(site_url('professional/services'))->with('success', $message);
    }

    /**
     * @param array<string, mixed>|null $service
     */
    private function serviceForm(?array $service): string
    {
        $categories = (new CategoryModel())
            ->where('active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();

        if ($service !== null && ! array_filter($categories, static fn (array $category): bool => (int) $category['id'] === (int) $service['category_id'])) {
            $currentCategory = (new CategoryModel())->find((int) $service['category_id']);

            if ($currentCategory !== null) {
                $currentCategory['name'] .= ' (inativa — categoria atual)';
                $categories[] = $currentCategory;
            }
        }

        return view('professional/services/form', [
            'title'            => $service === null ? 'Novo serviço' : 'Editar serviço',
            'activeNav'        => 'services',
            'service'          => $service,
            'categories'       => $categories,
            'success'          => session()->getFlashdata('success'),
            'error'            => session()->getFlashdata('error'),
            'validationErrors' => session()->getFlashdata('validationErrors') ?? [],
            'oldInput'         => session()->getFlashdata('oldInput') ?? [],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function serviceInput(): array
    {
        return [
            'title'       => trim($this->postString('title')),
            'description' => trim($this->postString('description')),
            'category_id' => $this->postString('category_id'),
            'price'       => trim($this->postString('price')),
            'active'      => $this->postString('active'),
        ];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, string>
     */
    private function validateService(array $data): array
    {
        if (! $this->validateData($data, [
            'title'       => 'required|max_length[150]',
            'description' => 'required|max_length[5000]',
            'category_id' => 'required|is_natural_no_zero',
            'price'       => 'permit_empty|decimal',
            'active'      => 'required|in_list[0,1]',
        ], [
            'title' => [
                'required'   => 'Informe o título do serviço.',
                'max_length' => 'O título deve ter no máximo 150 caracteres.',
            ],
            'description' => [
                'required'   => 'Informe a descrição do serviço.',
                'max_length' => 'A descrição deve ter no máximo 5000 caracteres.',
            ],
            'category_id' => [
                'required'           => 'Selecione uma categoria.',
                'is_natural_no_zero' => 'Selecione uma categoria válida.',
            ],
            'price' => ['decimal' => 'Informe um preço válido, usando ponto ou vírgula decimal.'],
            'active' => ['in_list' => 'Selecione uma situação válida.'],
        ])) {
            return $this->validator->getErrors();
        }

        if ($data['price'] !== '' && ! preg_match('/\A\d{1,8}(?:[.,]\d{1,2})?\z/', $data['price'])) {
            return ['price' => 'O preço deve ser positivo e ter no máximo duas casas decimais.'];
        }

        return [];
    }

    private function categoryIsActive(int $categoryId): bool
    {
        return (new CategoryModel())
            ->where('id', $categoryId)
            ->where('active', 1)
            ->first() !== null;
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

    /**
     * @return array<string, mixed>
     */
    private function ownedService(int $serviceId, int $profileId): array
    {
        $service = (new ServiceModel())
            ->where('professional_id', $profileId)
            ->find($serviceId);

        if ($service === null) {
            throw PageNotFoundException::forPageNotFound('Serviço não encontrado.');
        }

        return $service;
    }

    private function postString(string $key): string
    {
        $value = $this->request->getPost($key);

        return is_string($value) ? $value : '';
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, string> $errors
     */
    private function formFailure(array $data, array $errors, string $url): ResponseInterface
    {
        return redirect()->to($url)
            ->with('validationErrors', $errors)
            ->with('oldInput', $data);
    }

    private function normalizePrice(string $price): ?string
    {
        if ($price === '') {
            return null;
        }

        return str_replace(',', '.', $price);
    }
}
