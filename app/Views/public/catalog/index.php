<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="bg-teal-900 text-white">
    <div class="mx-auto max-w-7xl px-5 py-12 sm:px-8 sm:py-16">
        <p class="text-sm font-semibold uppercase tracking-wider text-teal-200">Catálogo local</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Encontre o profissional certo</h1>
        <p class="mt-3 max-w-2xl leading-7 text-teal-100">Busque por nome, serviço ou especialidade e entre em contato diretamente.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:py-14">
    <form class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[minmax(0,1fr)_16rem_auto]" action="<?= site_url('profissionais') ?>" method="get" role="search">
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="catalog-search">Profissional ou serviço</label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-900 outline-none placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="catalog-search" name="q" type="search" maxlength="100" value="<?= esc($term) ?>" placeholder="Ex.: nome, serviço ou descrição">
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="catalog-category">Categoria</label>
            <select class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="catalog-category" name="category">
                <option value="">Todas as categorias</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['id']) ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="flex items-end gap-3">
            <button class="w-full rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200 md:w-auto" type="submit">Buscar</button>
            <?php if ($term !== '' || $categoryId !== null): ?>
                <a class="rounded-xl px-3 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100" href="<?= site_url('profissionais') ?>">Limpar</a>
            <?php endif ?>
        </div>
    </form>

    <div class="mt-8 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-bold text-slate-900">Profissionais disponíveis</h2>
        <?php if ($term !== '' || $categoryId !== null): ?>
            <p class="text-sm text-slate-600">Resultados com os filtros selecionados</p>
        <?php endif ?>
    </div>

    <?php if ($professionals === []): ?>
        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
            <h3 class="text-lg font-semibold text-slate-900">Nenhum profissional encontrado</h3>
            <p class="mt-2 text-sm text-slate-600">Tente outros termos ou remova algum filtro para ampliar sua busca.</p>
            <a class="mt-5 inline-flex rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800" href="<?= site_url('profissionais') ?>">Ver todos</a>
        </div>
    <?php else: ?>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($professionals as $professional): ?>
                <?= view('public/components/professional_card', ['professional' => $professional]) ?>
            <?php endforeach ?>
        </div>
        <div class="mt-10">
            <?= $pager->links('professionals', 'catalog') ?>
        </div>
    <?php endif ?>
</section>
<?= $this->endSection() ?>
