<?= $this->extend('layouts/public') ?>
<?= $this->section('title') ?><?= esc($professional['name']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="mx-auto max-w-6xl px-5 py-8 sm:px-8 sm:py-11">
    <a class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 transition hover:text-brand-900" href="<?= site_url('profissionais') ?>">
        <svg class="h-4 w-4 rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
        Voltar ao catálogo
    </a>

    <article class="mt-5 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm">
        <header class="relative overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 px-5 py-8 text-white sm:px-9 sm:py-10">
            <div class="pointer-events-none absolute -right-20 -top-32 h-72 w-72 rounded-full border-[44px] border-white/5"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center">
                <?php if ($professional['photo_url'] !== null): ?>
                    <img class="h-24 w-24 shrink-0 rounded-2xl object-cover ring-4 ring-white/20 sm:h-28 sm:w-28" src="<?= esc($professional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($professional['name']) ?>">
                <?php else: ?>
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-4xl font-extrabold text-white ring-1 ring-white/20 sm:h-28 sm:w-28" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($professional['name'], 0, 1))) ?></div>
                <?php endif ?>
                <div class="min-w-0">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-200">Perfil profissional</p>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl"><?= esc($professional['name']) ?></h1>
                    <p class="mt-3 inline-flex items-center gap-2 text-sm text-white/85">
                        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.3" /></svg>
                        <?= esc($professional['city']) ?><?php if (! empty($professional['state'])): ?>, <?= esc($professional['state']) ?><?php endif ?><?php if (! empty($professional['neighborhood'])): ?><span aria-hidden="true"> · </span><?= esc($professional['neighborhood']) ?><?php endif ?>
                    </p>
                </div>
                <?php if ($professional['whatsapp_url'] !== null): ?>
                    <a class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50 focus:outline-none focus:ring-4 focus:ring-white/30 sm:ml-auto" href="<?= esc($professional['whatsapp_url'], 'attr') ?>" target="_blank" rel="noopener noreferrer">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8.3 8.3 0 0 1-12.2 7.3L4 20l1.2-3.7A8.3 8.3 0 1 1 20 11.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 8.5c.6 2.2 2.3 3.9 4.5 4.5l1-1 2 .8-.2 1.5c-.1.5-.6.8-1.1.8-3.7-.5-6.7-3.5-7.2-7.2-.1-.5.3-1  .8-1.1l1.5-.2.8 2-1.1.9Z" /></svg>
                        Falar pelo WhatsApp
                    </a>
                <?php else: ?>
                    <p class="text-sm text-white/75 sm:ml-auto">WhatsApp indisponível para contato.</p>
                <?php endif ?>
            </div>
        </header>

        <div class="grid gap-9 p-5 sm:p-8 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-12 lg:p-10">
            <section>
                <p class="text-xs font-bold uppercase tracking-[0.13em] text-brand-700">Conheça o profissional</p>
                <h2 class="mt-2 text-xl font-extrabold text-ink-950">Sobre</h2>
                <?php if (! empty($professional['description'])): ?>
                    <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600"><?= esc($professional['description']) ?></p>
                <?php else: ?>
                    <p class="mt-4 text-sm leading-7 text-slate-500">Este profissional ainda não adicionou uma descrição.</p>
                <?php endif ?>
                <div class="mt-6 flex items-start gap-3 rounded-2xl bg-brand-50 p-4">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.3" /></svg>
                    <p class="text-sm leading-6 text-brand-900">Atende em <strong><?= esc($professional['city']) ?><?= ! empty($professional['state']) ? ', ' . esc($professional['state']) : '' ?><?= ! empty($professional['neighborhood']) ? ', ' . esc($professional['neighborhood']) : '' ?></strong>.</p>
                </div>
            </section>

            <section>
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.13em] text-brand-700">O que oferece</p>
                        <h2 class="mt-2 text-xl font-extrabold text-ink-950">Serviços</h2>
                    </div>
                    <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600"><?= count($professional['services']) ?> <?= count($professional['services']) === 1 ? 'serviço' : 'serviços' ?></span>
                </div>

                <?php if ($professional['services'] === []): ?>
                    <p class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-5 text-sm leading-6 text-slate-600">Este profissional ainda não publicou serviços. Você pode entrar em contato pelo WhatsApp para saber mais.</p>
                <?php else: ?>
                    <ul class="mt-5 grid gap-3">
                        <?php foreach ($professional['services'] as $service): ?>
                            <li class="rounded-2xl border border-slate-200 p-4 transition hover:border-brand-200 sm:p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <h3 class="text-base font-bold text-ink-950"><?= esc($service['title']) ?></h3>
                                    <?php if ($service['price'] !== null): ?>
                                        <span class="shrink-0 rounded-full bg-brand-50 px-3 py-1 text-sm font-bold text-brand-800">R$ <?= esc(number_format((float) $service['price'], 2, ',', '.')) ?></span>
                                    <?php endif ?>
                                </div>
                                <p class="mt-2 text-xs font-bold text-brand-700"><?= esc($service['category_name']) ?></p>
                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-500"><?= esc($service['description']) ?></p>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </section>
        </div>
    </article>
</section>
<?= $this->endSection() ?>
