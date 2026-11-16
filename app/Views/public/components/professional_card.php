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
$primaryCategory = $professional['primary_category'] ?? null;
?>
<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-lg hover:shadow-slate-900/5">
    <a class="absolute inset-0 z-0 rounded-2xl focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-brand-300" href="<?= site_url('profissionais/' . (int) $professional['id']) ?>" aria-label="Ver perfil de <?= esc($professional['name'], 'attr') ?>"></a>
    <div class="pointer-events-none relative z-10 flex flex-1 items-center gap-3.5 p-4 sm:p-5">
        <?php if (($professional['photo_url'] ?? null) !== null): ?>
            <img class="h-14 w-14 shrink-0 rounded-xl object-cover ring-1 ring-slate-100 sm:h-16 sm:w-16" src="<?= esc($professional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($professional['name']) ?>" loading="lazy">
        <?php else: ?>
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-2xl font-extrabold text-brand-800 ring-1 ring-brand-100 sm:h-16 sm:w-16" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($professional['name'], 0, 1))) ?></span>
        <?php endif ?>
        <span class="min-w-0 flex-1">
            <span class="block truncate text-base font-extrabold text-ink-950 transition group-hover:text-brand-800"><?= esc($professional['name']) ?></span>
            <span class="mt-1 flex items-center gap-1.5 text-sm text-slate-500">
                <svg class="h-4 w-4 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.3" /></svg>
                <span class="truncate"><?= esc($professional['city']) ?><?= ! empty($professional['state']) ? ', ' . esc($professional['state']) : '' ?><?= ! empty($professional['neighborhood']) ? ' · ' . esc($professional['neighborhood']) : '' ?></span>
            </span>
            <?php if (is_string($primaryCategory) && $primaryCategory !== ''): ?>
                <span class="mt-2 inline-flex max-w-full truncate rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-800"><?= esc($primaryCategory) ?></span>
            <?php endif ?>
        </span>
    </div>
    <?php if ($whatsappUrl !== null): ?>
        <div class="pointer-events-none relative z-10 px-4 pb-4 sm:px-5 sm:pb-5">
            <a class="pointer-events-auto inline-flex min-h-10 w-full items-center justify-center gap-1.5 rounded-xl bg-brand-700 px-3 py-2 text-xs font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 sm:text-sm" href="<?= esc($whatsappUrl, 'attr') ?>" target="_blank" rel="noopener noreferrer">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8.3 8.3 0 0 1-12.2 7.3L4 20l1.2-3.7A8.3 8.3 0 1 1 20 11.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 8.5c.6 2.2 2.3 3.9 4.5 4.5l1-1 2 .8-.2 1.5c-.1.5-.6.8-1.1.8-3.7-.5-6.7-3.5-7.2-7.2-.1-.5.3-1  .8-1.1l1.5-.2.8 2-1.1.9Z" /></svg>
                WhatsApp
            </a>
        </div>
    <?php endif ?>
</article>
