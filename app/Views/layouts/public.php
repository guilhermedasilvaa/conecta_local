<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <meta name="description" content="Encontre profissionais e serviços perto de você no Conecta Local.">
    <title><?= esc($this->renderSection('title') ?: ($title ?? 'Conecta Local')) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8" aria-label="Navegação principal">
            <a class="inline-flex shrink-0 items-center gap-3 text-lg font-bold tracking-tight text-teal-900" href="<?= site_url('/') ?>">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-700 text-xl text-white" aria-hidden="true">+</span>
                Conecta Local
            </a>
            <div class="flex items-center gap-3 sm:gap-6">
                <a class="text-sm font-semibold text-slate-700 hover:text-teal-800" href="<?= site_url('profissionais') ?>">Profissionais</a>
                <a class="hidden text-sm font-semibold text-slate-700 hover:text-teal-800 sm:inline" href="<?= site_url('login') ?>">Entrar</a>
                <a class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200" href="<?= site_url('register') ?>">Quero divulgar</a>
            </div>
        </nav>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-slate-950 text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-8 px-5 py-10 sm:px-8 md:grid-cols-2 md:items-center">
            <div>
                <a class="font-bold text-white" href="<?= site_url('/') ?>">Conecta Local</a>
                <p class="mt-2 max-w-md text-sm leading-6 text-slate-400">Uma plataforma para aproximar profissionais autônomos e pessoas da sua região.</p>
            </div>
            <div class="flex flex-wrap gap-x-6 gap-y-3 text-sm md:justify-end">
                <a class="hover:text-white" href="<?= site_url('profissionais') ?>">Encontrar profissionais</a>
                <a class="hover:text-white" href="<?= site_url('register') ?>">Cadastre-se</a>
                <a class="hover:text-white" href="<?= site_url('login') ?>">Entrar</a>
            </div>
            <p class="text-xs text-slate-500 md:col-span-2">© <?= date('Y') ?> Conecta Local. Conectando pessoas e serviços locais.</p>
        </div>
    </footer>
</body>
</html>
