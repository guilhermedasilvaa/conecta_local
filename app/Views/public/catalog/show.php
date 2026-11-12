<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="mx-auto max-w-5xl px-5 py-10 sm:px-8 sm:py-14">
    <a class="text-sm font-semibold text-teal-800 hover:underline" href="<?= site_url('profissionais') ?>">← Voltar ao catálogo</a>

    <article class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-teal-900 px-6 py-8 text-white sm:px-10 sm:py-10">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                <?php if ($professional['photo_url'] !== null): ?>
                    <img class="h-28 w-28 rounded-2xl object-cover ring-4 ring-white/20" src="<?= esc($professional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($professional['name']) ?>">
                <?php else: ?>
                    <div class="flex h-28 w-28 shrink-0 items-center justify-center rounded-2xl bg-teal-700 text-4xl font-bold text-teal-100" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($professional['name'], 0, 1))) ?></div>
                <?php endif ?>
                <div class="min-w-0">
                    <p class="text-sm font-semibold uppercase tracking-wider text-teal-200">Profissional local</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl"><?= esc($professional['name']) ?></h1>
                    <p class="mt-3 text-teal-100">
                        <?= esc($professional['city']) ?>
                        <?php if (! empty($professional['neighborhood'])): ?>
                            <span aria-hidden="true"> · </span><?= esc($professional['neighborhood']) ?>
                        <?php endif ?>
                    </p>
                </div>
                <?php if ($professional['whatsapp_url'] !== null): ?>
                    <a class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 font-semibold text-white transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-200 sm:ml-auto" href="<?= esc($professional['whatsapp_url'], 'attr') ?>" target="_blank" rel="noopener noreferrer">
                        <span aria-hidden="true">↗</span> Conversar no WhatsApp
                    </a>
                <?php else: ?>
                    <p class="text-sm text-teal-100 sm:ml-auto">WhatsApp indisponível para contato.</p>
                <?php endif ?>
            </div>
        </div>

        <div class="grid gap-10 p-6 sm:p-10 md:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
            <section>
                <h2 class="text-xl font-bold text-slate-900">Sobre o profissional</h2>
                <?php if (! empty($professional['description'])): ?>
                    <p class="mt-4 whitespace-pre-line leading-7 text-slate-600"><?= esc($professional['description']) ?></p>
                <?php else: ?>
                    <p class="mt-4 leading-7 text-slate-600">Este profissional ainda não adicionou uma descrição.</p>
                <?php endif ?>
                <p class="mt-6 text-sm text-slate-500">Atende em <?= esc($professional['city']) ?><?= ! empty($professional['neighborhood']) ? ', ' . esc($professional['neighborhood']) : '' ?>.</p>
            </section>

            <section>
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">O que oferece</p>
                        <h2 class="mt-1 text-xl font-bold text-slate-900">Serviços</h2>
                    </div>
                    <span class="text-sm text-slate-500"><?= count($professional['services']) ?> <?= count($professional['services']) === 1 ? 'serviço' : 'serviços' ?></span>
                </div>

                <?php if ($professional['services'] === []): ?>
                    <p class="mt-5 rounded-xl bg-slate-50 p-5 text-sm leading-6 text-slate-600">Este profissional ainda não publicou serviços. Você pode entrar em contato pelo WhatsApp para saber mais.</p>
                <?php else: ?>
                    <ul class="mt-5 space-y-4">
                        <?php foreach ($professional['services'] as $service): ?>
                            <li class="rounded-2xl border border-slate-200 p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <h3 class="font-semibold text-slate-900"><?= esc($service['title']) ?></h3>
                                    <?php if ($service['price'] !== null): ?>
                                        <span class="shrink-0 rounded-lg bg-teal-50 px-3 py-1 text-sm font-semibold text-teal-800">R$ <?= esc(number_format((float) $service['price'], 2, ',', '.')) ?></span>
                                    <?php endif ?>
                                </div>
                                <p class="mt-2 text-sm font-medium text-teal-800"><?= esc($service['category_name']) ?></p>
                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600"><?= esc($service['description']) ?></p>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </section>
        </div>
    </article>
</section>
<?= $this->endSection() ?>
