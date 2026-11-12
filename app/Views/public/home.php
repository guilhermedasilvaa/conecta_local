<?= $this->extend('layouts/public') ?>
<?= $this->section('title') ?>Início<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="relative overflow-hidden bg-teal-900 text-white">
    <div class="absolute -right-32 -top-40 h-96 w-96 rounded-full bg-teal-700/50"></div>
    <div class="absolute -bottom-48 left-1/3 h-96 w-96 rounded-full border-[56px] border-teal-800/70"></div>
    <div class="relative mx-auto grid max-w-7xl gap-12 px-5 py-16 sm:px-8 sm:py-24 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:py-28">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-teal-200">Talentos perto de você</p>
            <h1 class="mt-5 max-w-2xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">Encontre quem resolve, bem aí na sua região.</h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-teal-100">Descubra profissionais locais, conheça seus serviços e fale direto com quem entende do assunto.</p>

            <form class="mt-9 flex flex-col gap-3 rounded-2xl bg-white p-3 shadow-xl sm:flex-row" action="<?= site_url('profissionais') ?>" method="get" role="search">
                <label class="sr-only" for="home-search">Profissional ou serviço</label>
                <input class="min-w-0 flex-1 rounded-xl border border-slate-200 px-4 py-3.5 text-slate-900 outline-none placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="home-search" name="q" type="search" maxlength="100" placeholder="Ex.: eletricista, manicure, aulas...">
                <button class="rounded-xl bg-teal-700 px-6 py-3.5 font-semibold text-white transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200" type="submit">Buscar serviços</button>
            </form>
        </div>
        <div class="hidden justify-center lg:flex" aria-hidden="true">
            <div class="flex h-80 w-80 items-center justify-center rounded-full border border-white/15 bg-white/5">
                <div class="flex h-60 w-60 items-center justify-center rounded-full border border-white/20 bg-teal-800 text-8xl font-bold text-teal-200">+</div>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:py-20">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Encontre por especialidade</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">O que você precisa hoje?</h2>
        </div>
        <a class="text-sm font-semibold text-teal-800 hover:underline" href="<?= site_url('profissionais') ?>">Ver todos os profissionais</a>
    </div>

    <?php if ($categories === []): ?>
        <p class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 text-slate-600">Novas categorias serão exibidas aqui em breve.</p>
    <?php else: ?>
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($categories as $category): ?>
                <?= view('public/components/category_card', ['category' => $category]) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Profissionais locais</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Gente boa, perto de você</h2>
            </div>
            <a class="text-sm font-semibold text-teal-800 hover:underline" href="<?= site_url('profissionais') ?>">Explorar catálogo</a>
        </div>

        <?php if ($professionals === []): ?>
            <p class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-slate-600">Estamos preparando a rede local. Volte em breve para encontrar profissionais.</p>
        <?php else: ?>
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($professionals as $professional): ?>
                    <?= view('public/components/professional_card', ['professional' => $professional]) ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>

<section class="mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:py-20">
    <div class="overflow-hidden rounded-3xl bg-teal-800 px-6 py-10 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold uppercase tracking-wider text-teal-200">Você trabalha por conta própria?</p>
            <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Mais pessoas podem conhecer o seu trabalho.</h2>
            <p class="mt-4 leading-7 text-teal-100">Crie seu perfil gratuitamente e apresente seus serviços para quem está procurando na sua região.</p>
        </div>
        <a class="mt-7 inline-flex shrink-0 items-center justify-center rounded-xl bg-white px-6 py-3.5 font-semibold text-teal-900 transition hover:bg-teal-50 focus:outline-none focus:ring-4 focus:ring-white/30 lg:mt-0" href="<?= site_url('register') ?>">Cadastre-se grátis</a>
    </div>
</section>
<?= $this->endSection() ?>
