<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicCatalogModel extends Model
{
    protected $table            = 'professional_profiles';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [];
    protected $useTimestamps    = false;

    /**
     * @return list<array<string, mixed>>
     */
    public function activeCategories(): array
    {
        return (new CategoryModel())
            ->where('active', 1)
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function featuredProfessionals(int $limit = 6): array
    {
        $this->publicProfessionals()
            ->whereIn('professional_profiles.id', static function ($builder): void {
                $builder->select('services.professional_id')
                    ->from('services')
                    ->where('services.active', 1);
            })
            ->orderBy('professional_profiles.created_at', 'DESC');

        $professionals = $this->findAll($limit);

        return $this->attachServices($professionals);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function searchProfessionals(
        string $term,
        ?int $categoryId,
        int $perPage = 12,
        ?string $state = null,
        string $city = '',
        string $neighborhood = ''
    ): array
    {
        $this->publicProfessionals();

        if ($state !== null) {
            $this->where('professional_profiles.state', $state);
        }

        if ($city !== '') {
            $this->like('professional_profiles.city', $city);
        }

        if ($neighborhood !== '') {
            $this->like('professional_profiles.neighborhood', $neighborhood);
        }

        if ($categoryId !== null) {
            $this->whereIn('professional_profiles.id', static function ($builder) use ($categoryId): void {
                $builder->select('services.professional_id')
                    ->from('services')
                    ->join('categories', 'categories.id = services.category_id')
                    ->where('services.active', 1)
                    ->where('categories.active', 1)
                    ->where('services.category_id', $categoryId);
            });
        }

        if ($term !== '') {
            $this->groupStart()
                ->like('users.name', $term)
                ->orWhereIn('professional_profiles.id', static function ($builder) use ($term, $categoryId): void {
                    $builder->select('services.professional_id')
                        ->from('services')
                        ->join('categories', 'categories.id = services.category_id')
                        ->where('services.active', 1)
                        ->where('categories.active', 1)
                        ->groupStart()
                            ->like('services.title', $term)
                            ->orLike('services.description', $term)
                        ->groupEnd();

                    if ($categoryId !== null) {
                        $builder->where('services.category_id', $categoryId);
                    }
                })
                ->groupEnd();
        }

        $this->orderBy('users.name', 'ASC');

        $professionals = $this->paginate($perPage, 'professionals');

        return $this->attachServices($professionals);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findPublicProfessional(int $profileId): ?array
    {
        $professional = $this->publicProfessionals()
            ->where('professional_profiles.id', $profileId)
            ->first();

        if ($professional === null) {
            return null;
        }

        $professional['photo_url'] = $this->photoUrl($professional['photo'] ?? null);
        $professional['services'] = $this->servicesForProfessionalIds([$profileId])[$profileId] ?? [];

        return $professional;
    }

    private function publicProfessionals(): self
    {
        return $this->select([
            'professional_profiles.id',
            'professional_profiles.whatsapp',
            'professional_profiles.city',
            'professional_profiles.state',
            'professional_profiles.neighborhood',
            'professional_profiles.description',
            'professional_profiles.photo',
            'users.name',
        ])
            ->join('users', 'users.id = professional_profiles.user_id')
            ->where('professional_profiles.active', 1)
            ->where('users.active', 1)
            ->where('users.role', 'professional');
    }

    /**
     * @param list<array<string, mixed>> $professionals
     *
     * @return list<array<string, mixed>>
     */
    private function attachServices(array $professionals): array
    {
        if ($professionals === []) {
            return [];
        }

        $ids      = array_map(static fn (array $professional): int => (int) $professional['id'], $professionals);
        $services = $this->servicesForProfessionalIds($ids);

        foreach ($professionals as &$professional) {
            $professional['photo_url'] = $this->photoUrl($professional['photo'] ?? null);
            $professional['services'] = $services[(int) $professional['id']] ?? [];
        }
        unset($professional);

        return $professionals;
    }

    /**
     * @param list<int> $profileIds
     *
     * @return array<int, list<array<string, mixed>>>
     */
    private function servicesForProfessionalIds(array $profileIds): array
    {
        $grouped = [];

        if ($profileIds === []) {
            return $grouped;
        }

        $services = db_connect()
            ->table('services')
            ->select([
                'services.professional_id',
                'services.title',
                'services.description',
                'services.price',
                'categories.name AS category_name',
            ])
            ->join('categories', 'categories.id = services.category_id')
            ->where('services.active', 1)
            ->whereIn('services.professional_id', $profileIds)
            ->orderBy('services.title', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($services as $service) {
            $profileId = (int) $service['professional_id'];
            unset($service['professional_id']);
            $grouped[$profileId][] = $service;
        }

        return $grouped;
    }

    private function photoUrl(mixed $photo): ?string
    {
        if (! is_string($photo) || trim($photo) === '') {
            return null;
        }

        $photo  = trim($photo);
        $parsed = parse_url($photo);

        if ($parsed === false) {
            return null;
        }

        $scheme = $parsed['scheme'] ?? null;

        if ($scheme !== null) {
            return in_array(strtolower($scheme), ['http', 'https'], true) ? $photo : null;
        }

        $path = str_replace('\\', '/', $photo);

        if (str_contains($path, '..') || str_contains($path, "\0")) {
            return null;
        }

        return base_url(ltrim($path, '/'));
    }
}
