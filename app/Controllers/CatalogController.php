<?php

namespace App\Controllers;

use App\Models\PublicCatalogModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\BrazilianStates;

class CatalogController extends BaseController
{
    private const PER_PAGE = 12;

    public function index(): string
    {
        $catalog    = new PublicCatalogModel();
        $categories = $catalog->activeCategories();
        $categoryId = $this->categoryFilter($categories);
        $term       = $this->searchTerm();
        $state      = $this->stateFilter();
        $city       = $this->locationFilter('city');

        return view('public/catalog/index', [
            'title'         => 'Encontre profissionais',
            'term'          => $term,
            'categoryId'    => $categoryId,
            'state'         => $state,
            'city'          => $city,
            'categories'    => $categories,
            'professionals' => $catalog->searchProfessionals(
                $term,
                $categoryId,
                self::PER_PAGE,
                $state,
                $city
            ),
            'pager'         => $catalog->pager,
        ]);
    }

    public function show(int $id): string
    {
        $professional = (new PublicCatalogModel())->findPublicProfessional($id);

        if ($professional === null) {
            throw PageNotFoundException::forPageNotFound('Profissional não encontrado.');
        }

        $professional['whatsapp_url'] = $this->whatsappUrl((string) $professional['whatsapp']);

        return view('public/catalog/show', [
            'title'        => $professional['name'],
            'professional' => $professional,
        ]);
    }

    private function searchTerm(): string
    {
        $term = $this->request->getGet('q');

        if (! is_string($term)) {
            return '';
        }

        $term = preg_replace('/[\x00-\x1F\x7F]/u', ' ', trim($term)) ?? '';

        return mb_substr($term, 0, 100);
    }

    private function stateFilter(): ?string
    {
        $value = $this->request->getGet('state');

        if (! is_string($value)) {
            return null;
        }

        $state = strtoupper(trim($value));

        return isset(BrazilianStates::STATES[$state]) ? $state : null;
    }

    private function locationFilter(string $key): string
    {
        $value = $this->request->getGet($key);

        if (! is_string($value)) {
            return '';
        }

        $value = preg_replace('/[\x00-\x1F\x7F]/u', ' ', trim($value)) ?? '';

        return mb_substr($value, 0, 100);
    }

    /**
     * @param list<array<string, mixed>> $categories
     */
    private function categoryFilter(array $categories): ?int
    {
        $value = $this->request->getGet('category');

        if (! is_string($value) || ! ctype_digit($value)) {
            return null;
        }

        $categoryId = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

        if ($categoryId === false) {
            return null;
        }

        foreach ($categories as $category) {
            if ((int) $category['id'] === $categoryId) {
                return $categoryId;
            }
        }

        return null;
    }

    private function whatsappUrl(string $whatsapp): ?string
    {
        $number = preg_replace('/\D+/', '', $whatsapp) ?? '';
        $number = ltrim($number, '0');

        if (
            str_starts_with($number, '550')
            && in_array(strlen($number), [13, 14], true)
        ) {
            $number = '55' . substr($number, 3);
        }

        if (! (str_starts_with($number, '55') && in_array(strlen($number), [12, 13], true))) {
            $number = '55' . $number;
        }

        if (! in_array(strlen($number), [12, 13], true)) {
            return null;
        }

        return 'https://wa.me/' . $number;
    }
}
