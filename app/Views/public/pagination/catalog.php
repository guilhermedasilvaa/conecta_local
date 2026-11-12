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
        <a class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-teal-100" href="<?= esc($pager->getPrevious(), 'attr') ?>" aria-label="Página anterior">Anterior</a>
    <?php endif ?>

    <?php foreach ($links as $link): ?>
        <a class="rounded-lg px-3 py-2 text-sm font-semibold focus:outline-none focus:ring-4 focus:ring-teal-100 <?= $link['active'] ? 'bg-teal-700 text-white' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50' ?>" href="<?= esc($link['uri'], 'attr') ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
            <?= esc($link['title']) ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()): ?>
        <a class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-teal-100" href="<?= esc($pager->getNext(), 'attr') ?>" aria-label="Próxima página">Próxima</a>
    <?php endif ?>
</nav>
