<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <title><?= esc($title) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-[90rem] items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a class="inline-flex items-center gap-3 text-lg font-bold tracking-tight text-teal-900" href="<?= site_url('professional/dashboard') ?>">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-700 text-xl text-white" aria-hidden="true">+</span>
                <span>Conecta Local <span class="hidden font-medium text-slate-500 sm:inline">/ Área profissional</span></span>
            </a>
            <div class="flex items-center gap-4">
                <a class="hidden text-sm font-semibold text-slate-600 hover:text-teal-800 sm:inline" href="<?= site_url('profissionais') ?>" target="_blank" rel="noopener noreferrer">Ver catálogo</a>
                <form action="<?= site_url('logout') ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900" type="submit">Sair</button>
                </form>
            </div>
        </div>
    </header>

    <div class="mx-auto grid max-w-[90rem] gap-6 px-4 py-6 sm:px-6 lg:grid-cols-[15rem_minmax(0,1fr)] lg:px-8 lg:py-8">
        <aside>
            <nav class="flex gap-2 overflow-x-auto rounded-2xl border border-slate-200 bg-white p-2 lg:sticky lg:top-6 lg:flex-col lg:overflow-visible lg:p-3" aria-label="Menu profissional">
                <a class="shrink-0 rounded-xl px-4 py-3 text-sm font-semibold <?= $activeNav === 'dashboard' ? 'bg-teal-50 text-teal-900' : 'text-slate-600 hover:bg-slate-50' ?>" href="<?= site_url('professional/dashboard') ?>">Visão geral</a>
                <a class="shrink-0 rounded-xl px-4 py-3 text-sm font-semibold <?= $activeNav === 'profile' ? 'bg-teal-50 text-teal-900' : 'text-slate-600 hover:bg-slate-50' ?>" href="<?= site_url('professional/profile') ?>">Meu perfil</a>
                <a class="shrink-0 rounded-xl px-4 py-3 text-sm font-semibold <?= $activeNav === 'services' ? 'bg-teal-50 text-teal-900' : 'text-slate-600 hover:bg-slate-50' ?>" href="<?= site_url('professional/services') ?>">Meus serviços</a>
            </nav>
        </aside>

        <main class="min-w-0">
            <?php if ($success !== null): ?>
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status"><?= esc($success) ?></div>
            <?php endif ?>
            <?php if ($error !== null): ?>
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert"><?= esc($error) ?></div>
            <?php endif ?>
            <?php if (($validationErrors ?? []) !== []): ?>
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Confira os dados informados:</p>
                    <ul class="mt-2 list-inside list-disc space-y-1">
                        <?php foreach ($validationErrors as $message): ?>
                            <li><?= esc($message) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</body>
</html>
