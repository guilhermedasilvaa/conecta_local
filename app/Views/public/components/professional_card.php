<article class="flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    <a class="flex flex-1 flex-col p-5" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>">
        <div class="flex items-center gap-4">
            <?php if (($professional['photo_url'] ?? null) !== null): ?>
                <img class="h-16 w-16 shrink-0 rounded-xl object-cover" src="<?= esc($professional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($professional['name']) ?>" loading="lazy">
            <?php else: ?>
                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-2xl font-bold text-teal-800" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($professional['name'], 0, 1))) ?></span>
            <?php endif ?>
            <span class="min-w-0">
                <span class="block truncate text-lg font-bold text-slate-900"><?= esc($professional['name']) ?></span>
                <span class="mt-1 block text-sm text-slate-600"><?= esc($professional['city']) ?><?= ! empty($professional['neighborhood']) ? ' · ' . esc($professional['neighborhood']) : '' ?></span>
            </span>
        </div>
        <span class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600">
            <?= esc($professional['description'] ?: 'Conheça os serviços deste profissional e fale diretamente pelo WhatsApp.') ?>
        </span>
        <span class="mt-5 border-t border-slate-100 pt-4">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Serviços</span>
            <?php if (($professional['services'] ?? []) === []): ?>
                <span class="mt-2 block text-sm text-slate-500">Consulte disponibilidade</span>
            <?php else: ?>
                <span class="mt-2 flex flex-wrap gap-2">
                    <?php foreach (array_slice($professional['services'], 0, 3) as $service): ?>
                        <span class="rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-semibold text-teal-800"><?= esc($service['title']) ?></span>
                    <?php endforeach ?>
                    <?php if (count($professional['services']) > 3): ?>
                        <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">+<?= count($professional['services']) - 3 ?></span>
                    <?php endif ?>
                </span>
            <?php endif ?>
        </span>
    </a>
    <a class="mx-5 mb-5 inline-flex items-center justify-center rounded-xl border border-teal-700 px-4 py-2.5 text-sm font-semibold text-teal-800 transition hover:bg-teal-50" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>">Ver perfil</a>
</article>
