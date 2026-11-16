<?php
$currentPath = trim(uri_string(), '/');
$activePage = match (true) {
    $currentPath === '' => 'home',
    $currentPath === 'profissionais' || str_starts_with($currentPath, 'profissionais/') => 'professionals',
    $currentPath === 'login' => 'login',
    $currentPath === 'register' => 'register',
    default => '',
};
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087e80">
    <meta name="description" content="Encontre profissionais e serviços perto de você no Conecta Local.">
    <title><?= esc($this->renderSection('title') ?: ($title ?? 'Conecta Local')) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="flex min-h-screen flex-col bg-slate-50 text-ink-950 antialiased">
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3.5 sm:px-6 lg:px-8" aria-label="Navegação principal">
            <a class="inline-flex shrink-0 items-center gap-2.5 text-lg font-extrabold tracking-tight text-brand-800" href="<?= site_url('/') ?>">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-brand-700 text-white shadow-sm shadow-brand-700/20" aria-hidden="true">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 11.25 10.5 9a2.12 2.12 0 0 1 3 0l.75.75m-6 1.5 3.75 3.75a2.12 2.12 0 0 0 3 0l3.75-3.75M3 9.75l4.5-4.5 3 3-4.5 4.5L3 9.75Zm18 0-4.5-4.5-3 3 4.5 4.5 3-3ZM3 9.75l-1.5 1.5 4.5 4.5 1.5-1.5m13.5-4.5 1.5 1.5-4.5 4.5-1.5-1.5" />
                    </svg>
                </span>
                <span class="leading-tight">Conecta<br class="sm:hidden"> Local</span>
            </a>

            <div class="hidden items-center gap-8 lg:flex">
                <a data-nav-item="home" data-nav-active="relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600" data-nav-idle="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" class="<?= $activePage === 'home' ? 'relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600' : 'py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700' ?>" href="<?= site_url('/') ?>" <?= $activePage === 'home' ? 'aria-current="page"' : '' ?>>Início</a>
                <a data-nav-item="professionals" data-nav-active="relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600" data-nav-idle="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" class="<?= $activePage === 'professionals' ? 'relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600' : 'py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700' ?>" href="<?= site_url('profissionais') ?>" <?= $activePage === 'professionals' ? 'aria-current="page"' : '' ?>>Profissionais</a>
                <a data-nav-item="categories" data-nav-active="relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600" data-nav-idle="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" class="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" href="<?= site_url('/') ?>#categorias">Categorias</a>
                <a data-nav-item="about" data-nav-active="relative py-2 text-sm font-bold text-brand-800 after:absolute after:-bottom-3.5 after:left-0 after:h-0.5 after:w-full after:rounded-full after:bg-brand-600" data-nav-idle="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" class="py-2 text-sm font-semibold text-slate-600 transition hover:text-brand-700" href="<?= site_url('/') ?>#sobre">Sobre</a>
            </div>

            <div class="hidden items-center gap-3 lg:flex">
                <a data-nav-item="login" data-nav-active="rounded-xl bg-brand-800 px-4 py-2.5 text-sm font-bold text-white shadow-sm ring-4 ring-brand-100" data-nav-idle="rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100" class="<?= $activePage === 'login' ? 'rounded-xl bg-brand-800 px-4 py-2.5 text-sm font-bold text-white shadow-sm ring-4 ring-brand-100' : 'rounded-xl bg-brand-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100' ?>" href="<?= site_url('login') ?>" <?= $activePage === 'login' ? 'aria-current="page"' : '' ?>>Área do profissional</a>
            </div>

            <details class="relative lg:hidden">
                <summary class="flex h-11 w-11 cursor-pointer list-none items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-brand-100" aria-label="Abrir menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </summary>
                <div class="absolute right-0 top-14 z-40 w-[min(20rem,calc(100vw-2rem))] rounded-2xl border border-slate-200 bg-white p-3 shadow-xl">
                    <div class="grid gap-1">
                        <a data-nav-item="home" data-nav-active="rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800" data-nav-idle="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" class="<?= $activePage === 'home' ? 'rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800' : 'rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50' ?>" href="<?= site_url('/') ?>" <?= $activePage === 'home' ? 'aria-current="page"' : '' ?>>Início</a>
                        <a data-nav-item="professionals" data-nav-active="rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800" data-nav-idle="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" class="<?= $activePage === 'professionals' ? 'rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800' : 'rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50' ?>" href="<?= site_url('profissionais') ?>" <?= $activePage === 'professionals' ? 'aria-current="page"' : '' ?>>Profissionais</a>
                        <a data-nav-item="categories" data-nav-active="rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800" data-nav-idle="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" class="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="<?= site_url('/') ?>#categorias">Categorias</a>
                        <a data-nav-item="about" data-nav-active="rounded-xl bg-brand-50 px-3 py-3 text-sm font-bold text-brand-800" data-nav-idle="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" class="rounded-xl px-3 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="<?= site_url('/') ?>#sobre">Sobre</a>
                    </div>
                    <div class="mt-2 grid grid-cols-1 gap-2 border-t border-slate-100 pt-3">
                        <a data-nav-item="login" data-nav-active="rounded-xl bg-brand-800 px-3 py-2.5 text-center text-sm font-bold text-white ring-4 ring-brand-100" data-nav-idle="rounded-xl bg-brand-700 px-3 py-2.5 text-center text-sm font-bold text-white hover:bg-brand-800" class="<?= $activePage === 'login' ? 'rounded-xl bg-brand-800 px-3 py-2.5 text-center text-sm font-bold text-white ring-4 ring-brand-100' : 'rounded-xl bg-brand-700 px-3 py-2.5 text-center text-sm font-bold text-white hover:bg-brand-800' ?>" href="<?= site_url('login') ?>" <?= $activePage === 'login' ? 'aria-current="page"' : '' ?>>Área do profissional</a>
                    </div>
                </div>
            </details>
        </nav>
    </header>

    <main class="flex-1">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-9 px-5 py-10 sm:px-8 md:grid-cols-[1.4fr_1fr_1fr] lg:py-12">
            <div>
                <a class="inline-flex items-center gap-2.5 font-extrabold tracking-tight text-brand-800" href="<?= site_url('/') ?>">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-700 text-sm font-bold text-white" aria-hidden="true">CL</span>
                    Conecta Local
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">Conectando pessoas a profissionais de confiança, perto de casa.</p>
            </div>
            <div>
                <h2 class="text-sm font-bold text-ink-950">Encontre serviços</h2>
                <div class="mt-3 grid gap-2.5 text-sm text-slate-500">
                    <a class="transition hover:text-brand-700" href="<?= site_url('profissionais') ?>">Explorar profissionais</a>
                    <a class="transition hover:text-brand-700" href="<?= site_url('/') ?>#categorias">Ver categorias</a>
                </div>
            </div>
            <div>
                <h2 class="text-sm font-bold text-ink-950">Para profissionais</h2>
                <div class="mt-3 grid gap-2.5 text-sm text-slate-500">
                    <a class="transition hover:text-brand-700" href="<?= site_url('register') ?>">Divulgue seu trabalho</a>
                    <a class="transition hover:text-brand-700" href="<?= site_url('login') ?>">Acessar minha conta</a>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-5 text-xs leading-5 text-slate-400 md:col-span-3 md:flex md:items-center md:justify-between md:pt-6">
                <p>© <?= date('Y') ?> Conecta Local. Todos os direitos reservados.</p>
                <a class="mt-2 inline-block font-semibold text-slate-500 hover:text-brand-700 md:mt-0" href="<?= site_url('/') ?>#sobre">Sobre a plataforma</a>
            </div>
        </div>
    </footer>
<script src="<?= base_url('assets/js/location-fields.js') ?>" defer></script>
<script {csp-script-nonce}>
    const updateActiveNavigation = () => {
        const hashItem = {
            '#categorias': 'categories',
            '#sobre': 'about',
        }[window.location.hash];
        const activeItem = hashItem || '<?= esc($activePage, 'js') ?>';

        document.querySelectorAll('[data-nav-item]').forEach((link) => {
            const isActive = link.dataset.navItem === activeItem;
            link.classList.remove(...link.dataset.navActive.split(' '), ...link.dataset.navIdle.split(' '));
            link.classList.add(...(isActive ? link.dataset.navActive : link.dataset.navIdle).split(' '));
            if (isActive) {
                link.setAttribute('aria-current', hashItem ? 'location' : 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    updateActiveNavigation();
    window.addEventListener('hashchange', updateActiveNavigation);
</script>
</body>
</html>
