<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">O que você oferece</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Meus serviços</h1>
        <p class="mt-2 text-slate-600">Gerencie os serviços que aparecem no seu perfil profissional.</p>
    </div>
    <a class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200" href="<?= site_url('professional/services/new') ?>">+ Novo serviço</a>
</div>

<?php if ($services === []): ?>
    <section class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-teal-50 text-2xl font-bold text-teal-800" aria-hidden="true">+</span>
        <h2 class="mt-5 text-xl font-bold text-slate-900">Você ainda não cadastrou serviços</h2>
        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">Adicione seu primeiro serviço para apresentar seu trabalho e ajudar clientes a encontrar você.</p>
        <a class="mt-6 inline-flex rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800" href="<?= site_url('professional/services/new') ?>">Cadastrar primeiro serviço</a>
    </section>
<?php else: ?>
    <section class="mt-7 space-y-4">
        <?php foreach ($services as $service): ?>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-lg font-bold text-slate-900"><?= esc($service['title']) ?></h2>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= (int) $service['active'] === 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-600' ?>">
                                <?= (int) $service['active'] === 1 ? 'Ativo' : 'Inativo' ?>
                            </span>
                        </div>
                        <p class="mt-2 text-sm font-medium text-teal-800"><?= esc($service['category_name']) ?></p>
                        <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600"><?= esc($service['description']) ?></p>
                        <p class="mt-4 text-sm font-semibold text-slate-800">
                            <?= $service['price'] !== null ? 'R$ ' . esc(number_format((float) $service['price'], 2, ',', '.')) : 'Preço sob consulta' ?>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 lg:justify-end">
                        <a class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="<?= site_url('professional/services/' . (int) $service['id'] . '/edit') ?>">Editar</a>
                        <form action="<?= site_url('professional/services/' . (int) $service['id'] . '/status') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="active" value="<?= (int) $service['active'] === 1 ? '0' : '1' ?>">
                            <button class="rounded-lg border px-3 py-2 text-sm font-semibold <?= (int) $service['active'] === 1 ? 'border-amber-200 text-amber-800 hover:bg-amber-50' : 'border-emerald-200 text-emerald-800 hover:bg-emerald-50' ?>" type="submit">
                                <?= (int) $service['active'] === 1 ? 'Desativar' : 'Ativar' ?>
                            </button>
                        </form>
                        <form action="<?= site_url('professional/services/' . (int) $service['id'] . '/delete') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50" type="submit">Excluir</button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
    </section>
<?php endif ?>
<?= $this->endSection() ?>
