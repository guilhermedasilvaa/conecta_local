<?php

namespace App\Database\Seeds;

use App\Models\CategoryModel;
use CodeIgniter\Database\Seeder;
use RuntimeException;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name'        => 'Desenvolvimento Web',
                'description' => 'Criação de sites, lojas virtuais, sistemas e aplicações para a web.',
            ],
            [
                'name'        => 'Design Gráfico',
                'description' => 'Criação de identidades visuais, logotipos, materiais gráficos e peças digitais.',
            ],
            [
                'name'        => 'Marketing Digital',
                'description' => 'Gestão de redes sociais, anúncios, conteúdo e estratégias de divulgação online.',
            ],
            [
                'name'        => 'Assistência Técnica',
                'description' => 'Manutenção e suporte para computadores, celulares e equipamentos eletrônicos.',
            ],
            [
                'name'        => 'Aulas e Reforço Escolar',
                'description' => 'Aulas particulares, reforço escolar, idiomas e preparação para provas.',
            ],
            [
                'name'        => 'Beleza e Estética',
                'description' => 'Cabeleireiro, manicure, maquiagem, estética e cuidados pessoais.',
            ],
            [
                'name'        => 'Saúde e Bem-estar',
                'description' => 'Atendimentos e atividades de saúde, condicionamento físico e bem-estar.',
            ],
            [
                'name'        => 'Serviços Elétricos',
                'description' => 'Instalação, manutenção e reparo de redes e equipamentos elétricos.',
            ],
            [
                'name'        => 'Encanamento e Hidráulica',
                'description' => 'Instalação e reparo de torneiras, tubulações, caixas d’água e sistemas hidráulicos.',
            ],
            [
                'name'        => 'Pintura',
                'description' => 'Pintura residencial e comercial de paredes, fachadas e outras superfícies.',
            ],
            [
                'name'        => 'Construção e Reformas',
                'description' => 'Pequenas obras, reformas, acabamentos e serviços de construção em geral.',
            ],
            [
                'name'        => 'Marcenaria',
                'description' => 'Fabricação, montagem, instalação e reparo de móveis e estruturas de madeira.',
            ],
            [
                'name'        => 'Jardinagem e Paisagismo',
                'description' => 'Manutenção de jardins, poda, plantio, paisagismo e cuidados com áreas verdes.',
            ],
            [
                'name'        => 'Limpeza de Terrenos',
                'description' => 'Roçada, capina, retirada de vegetação e limpeza de lotes e terrenos.',
            ],
            [
                'name'        => 'Limpeza Residencial e Comercial',
                'description' => 'Limpeza, organização e conservação de casas, escritórios e estabelecimentos.',
            ],
            [
                'name'        => 'Mudanças e Fretes',
                'description' => 'Transporte local, pequenos fretes, mudanças e entrega de móveis e objetos.',
            ],
            [
                'name'        => 'Costura e Ajustes',
                'description' => 'Consertos, ajustes, reformas e confecção de roupas e peças têxteis.',
            ],
            [
                'name'        => 'Fotografia e Vídeo',
                'description' => 'Cobertura de eventos, ensaios fotográficos, filmagem e edição de vídeo.',
            ],
            [
                'name'        => 'Cuidados com Pets',
                'description' => 'Banho e tosa, passeio, hospedagem e cuidados para animais de estimação.',
            ],
            [
                'name'        => 'Serviços Automotivos',
                'description' => 'Manutenção, reparos, limpeza e cuidados para carros e motocicletas.',
            ],
        ];

        foreach ($categories as $category) {
            $model = new CategoryModel();
            $existing = $model->where('name', $category['name'])->first();
            $data = $category + ['active' => 1];

            $saved = $existing === null
                ? $model->insert($data)
                : $model->update((int) $existing['id'], $data);

            if ($saved === false) {
                throw new RuntimeException(
                    'Não foi possível cadastrar a categoria: ' . $category['name']
                );
            }
        }
    }
}
