<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087e80">
    <title><?= esc($title) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-slate-50 text-ink-950 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-[90rem] items-center justify-between gap-3 px-4 py-3.5 sm:px-6 lg:px-8">
            <a class="inline-flex min-w-0 items-center gap-2.5 text-base font-extrabold tracking-tight text-brand-800 sm:text-lg" href="<?= site_url('professional/dashboard') ?>">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl bg-brand-700 text-xs font-extrabold text-white shadow-sm" aria-hidden="true">CL</span>
                <span class="truncate">Conecta Local <span class="hidden font-medium text-slate-400 sm:inline">/ Área profissional</span></span>
            </a>
            <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                <a class="hidden text-sm font-bold text-slate-500 transition hover:text-brand-800 sm:inline" href="<?= site_url('profissionais') ?>" target="_blank" rel="noopener noreferrer">Ver catálogo</a>
                <div class="hidden items-center gap-2 sm:flex">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-sm font-bold text-brand-800" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr((string) session()->get('user_name'), 0, 1))) ?></span>
                    <span class="max-w-40 truncate text-sm font-semibold text-slate-700"><?= esc((string) session()->get('user_name')) ?></span>
                </div>
                <form action="<?= site_url('logout') ?>" method="post">
                    <?= csrf_field() ?>
                    <button class="rounded-xl px-3 py-2.5 text-sm font-bold text-slate-500 transition hover:bg-slate-100 hover:text-ink-950" type="submit">Sair</button>
                </form>
            </div>
        </div>
    </header>

    <div class="mx-auto grid max-w-[90rem] gap-5 px-4 py-5 sm:px-6 sm:py-7 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-8 lg:px-8 lg:py-8">
        <aside>
            <nav class="grid grid-cols-3 gap-1 rounded-2xl border border-slate-200 bg-white p-2 shadow-sm lg:sticky lg:top-6 lg:flex lg:flex-col lg:gap-1.5 lg:p-3" aria-label="Menu profissional">
                <a class="flex min-h-11 items-center justify-center rounded-xl px-2 py-2 text-center text-xs font-bold transition sm:text-sm lg:justify-start lg:px-4 <?= $activeNav === 'dashboard' ? 'bg-brand-50 text-brand-900' : 'text-slate-500 hover:bg-slate-50 hover:text-ink-950' ?>" href="<?= site_url('professional/dashboard') ?>">
                    <svg class="mr-1.5 hidden h-4 w-4 shrink-0 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5" /><rect x="13.5" y="3.5" width="7" height="7" rx="1.5" /><rect x="3.5" y="13.5" width="7" height="7" rx="1.5" /><rect x="13.5" y="13.5" width="7" height="7" rx="1.5" /></svg>
                    Visão geral
                </a>
                <a class="flex min-h-11 items-center justify-center rounded-xl px-2 py-2 text-center text-xs font-bold transition sm:text-sm lg:justify-start lg:px-4 <?= $activeNav === 'profile' ? 'bg-brand-50 text-brand-900' : 'text-slate-500 hover:bg-slate-50 hover:text-ink-950' ?>" href="<?= site_url('professional/profile') ?>">
                    <svg class="mr-1.5 hidden h-4 w-4 shrink-0 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0" /></svg>
                    Meu perfil
                </a>
                <a class="flex min-h-11 items-center justify-center rounded-xl px-2 py-2 text-center text-xs font-bold transition sm:text-sm lg:justify-start lg:px-4 <?= $activeNav === 'services' ? 'bg-brand-50 text-brand-900' : 'text-slate-500 hover:bg-slate-50 hover:text-ink-950' ?>" href="<?= site_url('professional/services') ?>">
                    <svg class="mr-1.5 hidden h-4 w-4 shrink-0 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5h16M4 12h16M4 16.5h10" /><rect x="2.5" y="3.5" width="19" height="17" rx="2.5" /></svg>
                    Meus serviços
                </a>
            </nav>
            <div class="mt-4 hidden rounded-2xl bg-brand-900 p-5 text-white lg:block">
                <p class="text-sm font-bold">Seu perfil, sua vitrine.</p>
                <p class="mt-2 text-xs leading-5 text-brand-100">Mantenha suas informações e serviços atualizados para que clientes possam encontrar você.</p>
                <a class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-white hover:text-brand-200" href="<?= site_url('profissionais') ?>" target="_blank" rel="noopener noreferrer">Abrir catálogo <span aria-hidden="true">↗</span></a>
            </div>
        </aside>

        <main class="min-w-0">
            <?php if ($success !== null): ?>
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800" role="status">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
                    <?= esc($success) ?>
                </div>
            <?php endif ?>
            <?php if ($error !== null): ?>
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800" role="alert">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path stroke-linecap="round" d="M12 8v5m0 3h.01" /></svg>
                    <?= esc($error) ?>
                </div>
            <?php endif ?>
            <?php if (($validationErrors ?? []) !== []): ?>
                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800" role="alert">
                    <p class="font-bold">Confira os dados informados:</p>
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
