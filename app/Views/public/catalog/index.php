<?= $this->extend('layouts/public') ?>
<?= $this->section('title') ?>Encontre profissionais<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="bg-gradient-to-br from-brand-900 to-brand-700 text-white">
    <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-14">
        <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-200">Catálogo local</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">Encontre o profissional certo</h1>
        <p class="mt-3 max-w-2xl text-sm leading-6 text-brand-100 sm:text-base">Busque por nome, serviço ou especialidade e entre em contato diretamente.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-11">
    <form class="grid gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5 md:grid-cols-2 xl:grid-cols-6 xl:items-end" action="<?= site_url('profissionais') ?>" method="get" role="search" data-location-fields>
        <div class="xl:col-span-2">
            <label class="mb-2 block text-sm font-bold text-ink-950" for="catalog-search">Profissional ou serviço</label>
            <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3.5 focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-50">
                <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" /><path stroke-linecap="round" d="m16 16 4.5 4.5" /></svg>
                <input class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-ink-950 outline-none placeholder:text-slate-400 focus:ring-0" id="catalog-search" name="q" type="search" maxlength="100" value="<?= esc($term) ?>" placeholder="Ex.: nome, serviço ou descrição">
            </div>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="catalog-category">Categoria</label>
            <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="catalog-category" name="category">
                <option value="">Todas as categorias</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['id']) ?>" <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="catalog-state">Estado</label>
            <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="catalog-state" name="state" data-location-state>
                <option value="">Todos os estados</option>
                <?php foreach ($states as $uf => $stateName): ?>
                    <option value="<?= esc($uf) ?>" data-state-name="<?= esc($stateName, 'attr') ?>" <?= $state === $uf ? 'selected' : '' ?>><?= esc($uf) ?> — <?= esc($stateName) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="catalog-city">Cidade</label>
            <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-50 disabled:cursor-not-allowed disabled:bg-slate-100" id="catalog-city" name="city" data-location-city disabled>
                <option value="<?= esc($city) ?>"><?= esc($city !== '' ? $city : 'Selecione um estado primeiro') ?></option>
            </select>
            <p class="sr-only" data-location-city-status role="status" aria-live="polite">Selecione um estado para carregar as cidades.</p>
            <button class="mt-1 text-xs font-bold text-brand-700 underline" type="button" data-location-city-retry hidden>Tentar carregar cidades novamente</button>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="catalog-neighborhood">Bairro</label>
            <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="catalog-neighborhood" name="neighborhood" type="text" maxlength="100" value="<?= esc($neighborhood) ?>" placeholder="Ex.: Centro" list="catalog-neighborhood-suggestions" data-location-neighborhood>
            <datalist id="catalog-neighborhood-suggestions" data-location-neighborhood-list></datalist>
            <p class="sr-only" data-location-neighborhood-status role="status" aria-live="polite">As sugestões de bairros podem estar incompletas. Você também pode digitar o bairro.</p>
            <p class="sr-only">Créditos das sugestões de bairros: <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">OpenStreetMap</a>.</p>
        </div>
        <div class="flex items-center gap-2 xl:col-span-6 xl:justify-end">
            <button class="inline-flex min-h-11 flex-1 items-center justify-center gap-2 rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 xl:flex-none" type="submit">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" /><path stroke-linecap="round" d="m16 16 4.5 4.5" /></svg>
                Buscar
            </button>
            <?php if ($term !== '' || $categoryId !== null || $state !== null || $city !== '' || $neighborhood !== ''): ?>
                <a class="rounded-xl px-3 py-3 text-sm font-bold text-slate-500 transition hover:bg-slate-100 hover:text-ink-950" href="<?= site_url('profissionais') ?>">Limpar</a>
            <?php endif ?>
        </div>
    </form>

    <div class="mt-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-700">Encontre quem resolve</p>
            <h2 class="mt-1 text-xl font-extrabold text-ink-950">Profissionais disponíveis</h2>
        </div>
        <?php if ($term !== '' || $categoryId !== null || $state !== null || $city !== '' || $neighborhood !== ''): ?>
            <p class="rounded-full bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-800">Resultados com os filtros selecionados</p>
        <?php endif ?>
    </div>

    <?php if ($professionals === []): ?>
        <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-700" aria-hidden="true">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.8" cy="10.8" r="6.8" /><path stroke-linecap="round" d="m16 16 4.5 4.5" /></svg>
            </span>
            <h3 class="mt-4 text-lg font-bold text-ink-950">Nenhum profissional encontrado</h3>
            <p class="mt-2 text-sm text-slate-500">Tente outros termos ou remova algum filtro para ampliar sua busca.</p>
            <a class="mt-5 inline-flex min-h-11 items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800" href="<?= site_url('profissionais') ?>">Ver todos</a>
        </div>
    <?php else: ?>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <?php foreach ($professionals as $professional): ?>
                <?= view('public/components/professional_card', ['professional' => $professional]) ?>
            <?php endforeach ?>
        </div>
        <div class="mt-9">
            <?= $pager->links('professionals', 'catalog') ?>
        </div>
    <?php endif ?>
</section>
<?= $this->endSection() ?>
