<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">O que você oferece</p>
        <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl">Meus serviços</h1>
        <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">Gerencie os serviços que aparecem no seu perfil profissional.</p>
    </div>
    <a class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-brand-700 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 sm:px-5" href="<?= site_url('professional/services/new') ?>">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M12 5v14m-7-7h14" /></svg>
        Novo serviço
    </a>
</div>

<?php if ($services === []): ?>
    <section class="mt-7 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center sm:py-14">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-brand-700" aria-hidden="true">
            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M12 5v14m-7-7h14" /></svg>
        </span>
        <h2 class="mt-5 text-lg font-extrabold text-ink-950">Você ainda não cadastrou serviços</h2>
        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Adicione seu primeiro serviço para apresentar seu trabalho e ajudar clientes a encontrar você.</p>
        <a class="mt-6 inline-flex min-h-11 items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800" href="<?= site_url('professional/services/new') ?>">Cadastrar primeiro serviço</a>
    </section>
<?php else: ?>
    <section class="mt-6 grid gap-4">
        <?php foreach ($services as $service): ?>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="text-base font-extrabold text-ink-950 sm:text-lg"><?= esc($service['title']) ?></h2>
                            <span class="rounded-full px-2.5 py-1 text-xs font-bold <?= (int) $service['active'] === 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-500' ?>">
                                <?= (int) $service['active'] === 1 ? 'Ativo' : 'Inativo' ?>
                            </span>
                        </div>
                        <p class="mt-2 text-sm font-bold text-brand-700"><?= esc($service['category_name']) ?></p>
                        <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-500"><?= esc($service['description']) ?></p>
                        <p class="mt-4 text-sm font-bold text-ink-950">
                            <?= $service['price'] !== null ? 'R$ ' . esc(number_format((float) $service['price'], 2, ',', '.')) : 'Preço sob consulta' ?>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 border-t border-slate-100 pt-4 lg:justify-end lg:border-0 lg:pt-0">
                        <a class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 px-3.5 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-50" href="<?= site_url('professional/services/' . (int) $service['id'] . '/edit') ?>">Editar</a>
                        <form action="<?= site_url('professional/services/' . (int) $service['id'] . '/status') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="active" value="<?= (int) $service['active'] === 1 ? '0' : '1' ?>">
                            <button class="inline-flex min-h-10 items-center justify-center rounded-xl border px-3.5 py-2 text-sm font-bold transition <?= (int) $service['active'] === 1 ? 'border-amber-200 text-amber-800 hover:bg-amber-50' : 'border-emerald-200 text-emerald-800 hover:bg-emerald-50' ?>" type="submit">
                                <?= (int) $service['active'] === 1 ? 'Desativar' : 'Ativar' ?>
                            </button>
                        </form>
                        <form action="<?= site_url('professional/services/' . (int) $service['id'] . '/delete') ?>" method="post">
                            <?= csrf_field() ?>
                            <button class="inline-flex min-h-10 items-center justify-center rounded-xl border border-red-200 px-3.5 py-2 text-sm font-bold text-red-700 transition hover:bg-red-50" type="submit">Excluir</button>
                        </form>
                    </div>
                </div>
            </article>
        <?php endforeach ?>
    </section>
<?php endif ?>
<?= $this->endSection() ?>
