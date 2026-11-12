<a class="group flex items-start gap-4 rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md" href="<?= site_url('profissionais?category=' . (int) $category['id']) ?>">
    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-xl font-bold text-teal-800 transition group-hover:bg-teal-700 group-hover:text-white" aria-hidden="true">+</span>
    <span>
        <span class="block font-semibold text-slate-900"><?= esc($category['name']) ?></span>
        <span class="mt-1 block text-sm leading-5 text-slate-600"><?= esc($category['description'] ?: 'Veja profissionais desta categoria.') ?></span>
    </span>
</a>
