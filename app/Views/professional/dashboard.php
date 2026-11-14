<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-start justify-between gap-4">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Área profissional</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Olá, <?= esc($profile['name']) ?>!</h1>
        <p class="mt-2 text-slate-600">Acompanhe seu perfil e gerencie os serviços que você oferece.</p>
    </div>
    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-sm font-semibold <?= (int) $profile['active'] === 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-200 text-slate-700' ?>">
        <span class="h-2 w-2 rounded-full <?= (int) $profile['active'] === 1 ? 'bg-emerald-500' : 'bg-slate-500' ?>" aria-hidden="true"></span>
        Perfil <?= (int) $profile['active'] === 1 ? 'ativo' : 'inativo' ?>
    </span>
</div>

<section class="mt-8 grid gap-4 sm:grid-cols-2">
    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">Serviços cadastrados</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-slate-900"><?= (int) $totalServices ?></p>
        <p class="mt-2 text-sm text-slate-600">Todos os serviços do seu perfil.</p>
    </article>
    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-medium text-slate-500">Serviços ativos</p>
        <p class="mt-3 text-4xl font-bold tracking-tight text-teal-800"><?= (int) $activeServices ?></p>
        <p class="mt-2 text-sm text-slate-600">Visíveis no catálogo quando seu perfil está ativo.</p>
    </article>
</section>

<section class="mt-8">
    <h2 class="text-lg font-bold text-slate-900">Acesso rápido</h2>
    <div class="mt-4 grid gap-4 md:grid-cols-2">
        <a class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-teal-200 hover:shadow-md" href="<?= site_url('professional/profile') ?>">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl font-bold text-teal-800" aria-hidden="true">01</span>
            <span class="mt-4 block text-lg font-bold text-slate-900">Editar meu perfil</span>
            <span class="mt-2 block text-sm leading-6 text-slate-600">Atualize suas informações, contato, foto e visibilidade no catálogo.</span>
            <span class="mt-4 block text-sm font-semibold text-teal-800 group-hover:underline">Acessar perfil →</span>
        </a>
        <a class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-teal-200 hover:shadow-md" href="<?= site_url('professional/services') ?>">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-xl font-bold text-teal-800" aria-hidden="true">02</span>
            <span class="mt-4 block text-lg font-bold text-slate-900">Gerenciar serviços</span>
            <span class="mt-2 block text-sm leading-6 text-slate-600">Cadastre, edite, ative ou desative os serviços que você oferece.</span>
            <span class="mt-4 block text-sm font-semibold text-teal-800 group-hover:underline">Ver meus serviços →</span>
        </a>
    </div>
</section>
<?= $this->endSection() ?>
