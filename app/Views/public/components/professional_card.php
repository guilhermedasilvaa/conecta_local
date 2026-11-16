<?php
$whatsappNumber = preg_replace('/\D+/', '', (string) ($professional['whatsapp'] ?? '')) ?? '';
$whatsappNumber = ltrim($whatsappNumber, '0');
if (str_starts_with($whatsappNumber, '550') && in_array(strlen($whatsappNumber), [13, 14], true)) {
    $whatsappNumber = '55' . substr($whatsappNumber, 3);
}
if (! (str_starts_with($whatsappNumber, '55') && in_array(strlen($whatsappNumber), [12, 13], true))) {
    $whatsappNumber = '55' . $whatsappNumber;
}
$whatsappUrl = in_array(strlen($whatsappNumber), [12, 13], true) ? 'https://wa.me/' . $whatsappNumber : null;
?>
<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:shadow-slate-900/5">
    <a class="flex flex-1 flex-col p-5 sm:p-6" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>">
        <span class="flex items-start gap-4">
            <?php if (($professional['photo_url'] ?? null) !== null): ?>
                <img class="h-[4.25rem] w-[4.25rem] shrink-0 rounded-2xl object-cover ring-1 ring-slate-100" src="<?= esc($professional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($professional['name']) ?>" loading="lazy">
            <?php else: ?>
                <span class="flex h-[4.25rem] w-[4.25rem] shrink-0 items-center justify-center rounded-2xl bg-brand-50 text-2xl font-extrabold text-brand-800 ring-1 ring-brand-100" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($professional['name'], 0, 1))) ?></span>
            <?php endif ?>
            <span class="min-w-0 flex-1 pt-1">
                <span class="block truncate text-base font-extrabold text-ink-950 transition group-hover:text-brand-800"><?= esc($professional['name']) ?></span>
                <span class="mt-1.5 flex items-center gap-1.5 text-sm text-slate-500">
                    <svg class="h-4 w-4 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.3" /></svg>
                    <span class="truncate"><?= esc($professional['city']) ?><?= ! empty($professional['state']) ? ', ' . esc($professional['state']) : '' ?><?= ! empty($professional['neighborhood']) ? ' · ' . esc($professional['neighborhood']) : '' ?></span>
                </span>
            </span>
        </span>
        <span class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600"><?= esc($professional['description'] ?: 'Conheça os serviços deste profissional e fale diretamente pelo WhatsApp.') ?></span>
        <span class="mt-5 border-t border-slate-100 pt-4">
            <span class="block text-[11px] font-bold uppercase tracking-[0.12em] text-slate-400">Serviços oferecidos</span>
            <?php if (($professional['services'] ?? []) === []): ?>
                <span class="mt-2 block text-sm text-slate-500">Consulte disponibilidade</span>
            <?php else: ?>
                <span class="mt-2 flex flex-wrap gap-2">
                    <?php foreach (array_slice($professional['services'], 0, 3) as $service): ?>
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-800"><?= esc($service['title']) ?></span>
                    <?php endforeach ?>
                    <?php if (count($professional['services']) > 3): ?>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">+<?= count($professional['services']) - 3 ?></span>
                    <?php endif ?>
                </span>
            <?php endif ?>
        </span>
    </a>
    <div class="grid grid-cols-2 gap-2 border-t border-slate-100 p-4 sm:p-5">
        <a class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50 sm:text-sm" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>">Ver perfil</a>
        <?php if ($whatsappUrl !== null): ?>
            <a class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-brand-700 px-3 py-2 text-xs font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 sm:text-sm" href="<?= esc($whatsappUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8.3 8.3 0 0 1-12.2 7.3L4 20l1.2-3.7A8.3 8.3 0 1 1 20 11.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 8.5c.6 2.2 2.3 3.9 4.5 4.5l1-1 2 .8-.2 1.5c-.1.5-.6.8-1.1.8-3.7-.5-6.7-3.5-7.2-7.2-.1-.5.3-1  .8-1.1l1.5-.2.8 2-1.1.9Z" /></svg>
                WhatsApp
            </a>
        <?php else: ?>
            <a class="inline-flex min-h-10 items-center justify-center rounded-xl bg-brand-50 px-3 py-2 text-xs font-bold text-brand-800 transition hover:bg-brand-100 sm:text-sm" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>">Ver contato</a>
        <?php endif ?>
    </div>
</article>
