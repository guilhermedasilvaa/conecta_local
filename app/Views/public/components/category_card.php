<?php
$categoryIcon = match ($category['name']) {
    'Desenvolvimento Web'             => 'web',
    'Design Gráfico'                  => 'design',
    'Marketing Digital'               => 'marketing',
    'Assistência Técnica'             => 'repair',
    'Aulas e Reforço Escolar'         => 'education',
    'Beleza e Estética'               => 'beauty',
    'Saúde e Bem-estar'               => 'health',
    'Serviços Elétricos'              => 'electric',
    'Encanamento e Hidráulica'        => 'plumbing',
    'Pintura'                         => 'painting',
    'Construção e Reformas'           => 'construction',
    'Marcenaria'                      => 'woodwork',
    'Jardinagem e Paisagismo'         => 'garden',
    'Limpeza de Terrenos'             => 'yard',
    'Limpeza Residencial e Comercial' => 'cleaning',
    'Mudanças e Fretes'               => 'moving',
    'Costura e Ajustes'               => 'sewing',
    'Fotografia e Vídeo'              => 'camera',
    'Cuidados com Pets'               => 'pets',
    'Serviços Automotivos'            => 'automotive',
    default                           => 'general',
};
?>
<a class="group flex min-h-16 min-w-0 items-center gap-3 rounded-xl border border-slate-200 bg-white/90 p-3 transition duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:bg-white hover:shadow-md focus:outline-none focus-visible:ring-4 focus-visible:ring-brand-100 sm:gap-3.5 sm:p-3.5" href="<?= site_url('profissionais?category=' . (int) $category['id']) ?>">
    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-700 transition group-hover:bg-brand-700 group-hover:text-white sm:h-10 sm:w-10" aria-hidden="true">
        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <?php if ($categoryIcon === 'web'): ?>
                <path d="m8 8-4 4 4 4m8-8 4 4-4 4m-3-11-2 14" />
            <?php elseif ($categoryIcon === 'design'): ?>
                <path d="m14 6 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z" />
            <?php elseif ($categoryIcon === 'marketing'): ?>
                <path d="M4 14V9a1 1 0 0 1 1-1h3l9-4v14l-9-4H5a1 1 0 0 1-1-1Zm4 0 2 6h4l-2.5-5.3M20 9l2-1m-2 5 2 1" />
            <?php elseif ($categoryIcon === 'repair'): ?>
                <path d="M14 7a5 5 0 0 0 6 6l-9 9-5-5 9-9a5 5 0 0 1 6-6l-3 3 1 3 3 1 3-3a5 5 0 0 1-6 6" />
            <?php elseif ($categoryIcon === 'education'): ?>
                <path d="M3 5.5A2.5 2.5 0 0 1 5.5 3H12v17H5.5A2.5 2.5 0 0 0 3 22V5.5Zm18 0A2.5 2.5 0 0 0 18.5 3H12v17h6.5a2.5 2.5 0 0 1 2.5 2V5.5Z" />
            <?php elseif ($categoryIcon === 'beauty'): ?>
                <path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Zm7 11 1 2.5 2.5 1-2.5 1L19 21l-1-2.5-2.5-1 2.5-1 1-2.5Z" />
            <?php elseif ($categoryIcon === 'health'): ?>
                <path d="M12 21s-8-4.5-8-11a4.5 4.5 0 0 1 8-2.8A4.5 4.5 0 0 1 20 10c0 6.5-8 11-8 11Z" /><path d="M5 12h4l2-4 3 8 2-4h3" />
            <?php elseif ($categoryIcon === 'electric'): ?>
                <path d="M13 2 5 13h6l-1 9 9-12h-6l1-8Z" />
            <?php elseif ($categoryIcon === 'plumbing'): ?>
                <path d="M4 4v6a4 4 0 0 0 4 4h4a4 4 0 0 1 4 4v2m-5-16v6m-5 0h8m3 8h4m-2-2v4" />
            <?php elseif ($categoryIcon === 'painting'): ?>
                <path d="M4 4h16v6H4zM8 10v3a2 2 0 0 0 2 2h2v6m-4-17v3m8-3v3" />
            <?php elseif ($categoryIcon === 'construction'): ?>
                <path d="M3 20h18M5 20V9l7-5 7 5v11m-10 0v-6h6v6M3 9h18" />
            <?php elseif ($categoryIcon === 'woodwork'): ?>
                <path d="m4 18 14-14 3 3L7 21l-3-3Zm5-5 2 2m1-5 2 2m1-5 2 2M4 4l4 4m-6-2 4-4" />
            <?php elseif ($categoryIcon === 'garden'): ?>
                <path d="M12 21v-9m0 4c-5 0-8-3-8-8 5 0 8 3 8 8Zm0-3c0-5 3-8 8-8 0 5-3 8-8 8Zm-5 8h10" />
            <?php elseif ($categoryIcon === 'yard'): ?>
                <path d="M4 20 16 8m-9 9-4-4m7 1-4-4m7 1-4-4m9-4-2 6m-2-2 4 4" />
            <?php elseif ($categoryIcon === 'cleaning'): ?>
                <path d="M9 3h6m-5 0v4l-4 4v9h12v-9l-4-4V3m-8 8h12m-9 4h.01M14 15h.01" />
            <?php elseif ($categoryIcon === 'moving'): ?>
                <path d="M3 7h11v11H3zM14 11h4l3 3v4h-7M7 18a2 2 0 1 0 4 0m5 0a2 2 0 1 0 4 0" />
            <?php elseif ($categoryIcon === 'sewing'): ?>
                <path d="M20 4 7 17m13-13-3-1-1 3m-8 8-3 3m3-3 3 3M5 5a2 2 0 1 0 0 .01" />
            <?php elseif ($categoryIcon === 'camera'): ?>
                <path d="M4 7h4l2-3h4l2 3h4a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2Z" /><circle cx="12" cy="13" r="4" />
            <?php elseif ($categoryIcon === 'pets'): ?>
                <path d="M12 12c-2.5 0-6 3.2-6 6a3 3 0 0 0 3 3c1.5 0 2-.8 3-.8s1.5.8 3 .8a3 3 0 0 0 3-3c0-2.8-3.5-6-6-6Z" /><ellipse cx="5" cy="9" rx="2" ry="3" /><ellipse cx="10" cy="5" rx="2" ry="3" /><ellipse cx="16" cy="5" rx="2" ry="3" /><ellipse cx="20" cy="9" rx="2" ry="3" />
            <?php elseif ($categoryIcon === 'automotive'): ?>
                <path d="m5 11 1.5-5h11l1.5 5m-15 0h18v7H3v-7Zm3 7v2m12-2v2M6 14h.01M18 14h.01M7 11h10" />
            <?php else: ?>
                <path d="M4 12h16M12 4v16m-5-5 5-3 5 3m-10-6 5 3 5-3" />
            <?php endif ?>
        </svg>
    </span>
    <span class="line-clamp-2 min-w-0 text-xs font-bold leading-4 text-ink-950 sm:text-sm sm:leading-5"><?= esc($category['name']) ?></span>
</a>
