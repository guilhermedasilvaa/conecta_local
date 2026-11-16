<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(1);
$links = $pager->links();
?>
<nav class="flex flex-wrap items-center justify-center gap-2" aria-label="Paginação">
    <?php if ($pager->hasPrevious()): ?>
        <a class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100" href="<?= esc($pager->getPrevious(), 'attr') ?>" aria-label="Página anterior">Anterior</a>
    <?php endif ?>

    <?php foreach ($links as $link): ?>
        <a class="flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm font-bold focus:outline-none focus:ring-4 focus:ring-brand-100 <?= $link['active'] ? 'bg-brand-700 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-600 transition hover:bg-brand-50 hover:text-brand-800' ?>" href="<?= esc($link['uri'], 'attr') ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
            <?= esc($link['title']) ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()): ?>
        <a class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100" href="<?= esc($pager->getNext(), 'attr') ?>" aria-label="Próxima página">Próxima</a>
    <?php endif ?>
</nav>
