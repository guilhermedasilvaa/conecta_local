<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-start justify-between gap-4">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Área profissional</p>
        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl">Olá, <?= esc($profile['name']) ?>!</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">Acompanhe seu perfil e gerencie os serviços que você oferece.</p>
    </div>
    <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-bold <?= (int) $profile['active'] === 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-200 text-slate-600' ?>">
        <span class="h-2 w-2 rounded-full <?= (int) $profile['active'] === 1 ? 'bg-emerald-500' : 'bg-slate-500' ?>" aria-hidden="true"></span>
        Perfil <?= (int) $profile['active'] === 1 ? 'ativo' : 'inativo' ?>
    </span>
</div>

<section class="mt-7 grid gap-4 sm:grid-cols-2" aria-label="Resumo dos serviços">
    <article class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <span class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600" aria-hidden="true">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5h16M4 12h16M4 16.5h10" /><rect x="2.5" y="3.5" width="19" height="17" rx="2.5" /></svg>
        </span>
        <p class="text-sm font-semibold text-slate-500">Serviços cadastrados</p>
        <p class="mt-4 text-4xl font-extrabold tracking-tight text-ink-950"><?= (int) $totalServices ?></p>
        <p class="mt-2 text-xs text-slate-500">Todos os serviços do seu perfil.</p>
    </article>
    <article class="relative overflow-hidden rounded-2xl border border-brand-100 bg-brand-50/60 p-5 shadow-sm sm:p-6">
        <span class="absolute right-5 top-5 flex h-10 w-10 items-center justify-center rounded-xl bg-white text-brand-700" aria-hidden="true">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
        </span>
        <p class="text-sm font-semibold text-brand-800">Serviços ativos</p>
        <p class="mt-4 text-4xl font-extrabold tracking-tight text-brand-800"><?= (int) $activeServices ?></p>
        <p class="mt-2 text-xs text-slate-500">Visíveis no catálogo quando seu perfil está ativo.</p>
    </article>
</section>

<section class="mt-8">
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.13em] text-brand-700">Gerencie sua presença</p>
            <h2 class="mt-1 text-xl font-extrabold text-ink-950">Acesso rápido</h2>
        </div>
        <?php if ((int) $profile['active'] === 1): ?>
            <a class="text-sm font-bold text-brand-700 transition hover:text-brand-900" href="<?= site_url('profissionais/' . (int) $profile['id']) ?>" target="_blank" rel="noopener noreferrer">Ver meu perfil público <span aria-hidden="true">↗</span></a>
        <?php else: ?>
            <p class="text-xs font-medium text-slate-500">Ative seu perfil para aparecer no catálogo.</p>
        <?php endif ?>
    </div>
    <div class="mt-4 grid gap-4 md:grid-cols-2">
        <a class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md sm:p-6" href="<?= site_url('professional/profile') ?>">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-700 group-hover:text-white" aria-hidden="true">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5" /><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0" /></svg>
            </span>
            <span class="mt-4 block text-base font-extrabold text-ink-950">Editar meu perfil</span>
            <span class="mt-2 block text-sm leading-6 text-slate-500">Atualize suas informações, contato, foto e visibilidade no catálogo.</span>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-brand-700 group-hover:text-brand-900">Acessar perfil <span aria-hidden="true">→</span></span>
        </a>
        <a class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md sm:p-6" href="<?= site_url('professional/services') ?>">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-700 group-hover:text-white" aria-hidden="true">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
            </span>
            <span class="mt-4 block text-base font-extrabold text-ink-950">Gerenciar serviços</span>
            <span class="mt-2 block text-sm leading-6 text-slate-500">Cadastre, edite, ative ou desative os serviços que você oferece.</span>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-brand-700 group-hover:text-brand-900">Ver meus serviços <span aria-hidden="true">→</span></span>
        </a>
    </div>
</section>
<?= $this->endSection() ?>
