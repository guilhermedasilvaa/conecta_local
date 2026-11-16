<?= $this->extend('layouts/public') ?>
<?= $this->section('title') ?>Início<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $heroProfessional = $professionals[0] ?? null ?>
<section class="relative isolate overflow-hidden bg-gradient-to-br from-brand-50 via-white to-sky-50">
    <div class="pointer-events-none absolute -right-36 -top-32 -z-10 h-96 w-96 rounded-full bg-brand-100/70 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-48 left-1/4 -z-10 h-96 w-96 rounded-full bg-cyan-100/60 blur-3xl"></div>
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 py-12 sm:px-8 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:gap-14 lg:py-20">
        <div>
            <p class="inline-flex items-center gap-2 rounded-full border border-brand-100 bg-white/80 px-3.5 py-2 text-xs font-bold uppercase tracking-[0.12em] text-brand-800 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-brand-500" aria-hidden="true"></span>
                Talentos perto de você
            </p>
            <h1 class="mt-5 max-w-2xl text-4xl font-extrabold leading-[1.08] tracking-tight text-ink-950 sm:text-5xl lg:text-[3.5rem]">Encontre os melhores profissionais da sua região.</h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-slate-600 sm:text-lg">Serviços de qualidade, perto de você. Conheça profissionais locais e fale diretamente com quem pode ajudar.</p>

            <form class="mt-8 grid gap-2 rounded-2xl border border-slate-200 bg-white p-3 shadow-lg shadow-slate-900/5 sm:grid-cols-2 sm:p-4" action="<?= site_url('profissionais') ?>" method="get" role="search">
                <label class="flex min-w-0 items-center gap-3 rounded-xl px-2">
                    <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="10.8" cy="10.8" r="6.8" />
                        <path stroke-linecap="round" d="m16 16 4.5 4.5" />
                    </svg>
                    <span class="sr-only">Profissional ou serviço</span>
                    <input class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-ink-950 outline-none placeholder:text-slate-400 focus:ring-0" name="q" type="search" maxlength="100" placeholder="O que você precisa?">
                </label>
                <label class="flex min-w-0 items-center gap-3 rounded-xl border-t border-slate-100 px-2 sm:border-l sm:border-t-0 sm:border-slate-200 sm:pl-4">
                    <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" />
                        <circle cx="12" cy="10" r="2.3" />
                    </svg>
                    <span class="sr-only">Categoria</span>
                    <select class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-slate-600 outline-none focus:ring-0" name="category">
                        <option value="">Todas as categorias</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['id'] ?>"><?= esc($category['name']) ?></option>
                        <?php endforeach ?>
                    </select>
                </label>
                <div class="grid gap-2 sm:col-span-2 sm:grid-cols-2 lg:grid-cols-[0.7fr_1fr_1fr]">
                    <label class="flex min-w-0 items-center gap-3 rounded-xl border-t border-slate-100 px-2 sm:border-t-0">
                        <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z" />
                            <circle cx="12" cy="9" r="2.2" />
                        </svg>
                        <span class="sr-only">Estado</span>
                        <select class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-slate-600 outline-none focus:ring-0" name="state">
                            <option value="">Todos os estados</option>
                            <?php foreach ($states as $uf => $stateName): ?>
                                <option value="<?= esc($uf) ?>"><?= esc($uf) ?> — <?= esc($stateName) ?></option>
                            <?php endforeach ?>
                        </select>
                    </label>
                    <label class="flex min-w-0 items-center gap-3 rounded-xl border-t border-slate-100 px-2 sm:border-t-0 sm:border-l sm:border-slate-200 sm:pl-4">
                        <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 3l9 7.5v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 19.5v-9Z" />
                            <path stroke-linecap="round" d="M9 21v-6h6v6" />
                        </svg>
                        <span class="sr-only">Cidade</span>
                        <input class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-ink-950 outline-none placeholder:text-slate-400 focus:ring-0" name="city" type="text" maxlength="100" placeholder="Sua cidade">
                    </label>
                    <label class="flex min-w-0 items-center gap-3 rounded-xl border-t border-slate-100 px-2 sm:border-l sm:border-slate-200 sm:pl-4 lg:border-t-0">
                        <svg class="h-5 w-5 shrink-0 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20V9l8-5 8 5v11M2 20h20M9 20v-6h6v6M4 10h16" />
                        </svg>
                        <span class="sr-only">Bairro</span>
                        <input class="min-w-0 flex-1 border-0 bg-transparent py-3 text-sm text-ink-950 outline-none placeholder:text-slate-400 focus:ring-0" name="neighborhood" type="text" maxlength="100" placeholder="Seu bairro">
                    </label>
                </div>
                <button class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-brand-700 px-6 text-sm font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 sm:col-span-2" type="submit">
                    Buscar
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
                </button>
            </form>

            <div class="mt-6 flex flex-wrap gap-x-5 gap-y-3 text-xs font-semibold text-slate-600 sm:text-sm">
                <span class="inline-flex items-center gap-2"><svg class="h-4 w-4 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 8 3v5c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="m8.5 11.5 2.2 2.2 4.8-5" /></svg>Profissionais locais</span>
                <span class="inline-flex items-center gap-2"><svg class="h-4 w-4 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3 5 13h6l-1 8 9-12h-6l-1-6Z" /></svg>Contato direto</span>
                <span class="inline-flex items-center gap-2"><svg class="h-4 w-4 text-brand-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.2c0 5.1-7.5 10.3-7.5 10.3S4.5 15.3 4.5 10.2a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.3" /></svg>Atendimento na sua região</span>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-xl lg:max-w-none">
            <?php if ($heroProfessional !== null && $heroProfessional['photo_url'] !== null): ?>
                <div class="relative min-h-[19rem] overflow-hidden rounded-[2rem] bg-brand-100 shadow-2xl shadow-brand-900/15 sm:min-h-[25rem]">
                    <img class="absolute inset-0 h-full w-full object-cover" src="<?= esc($heroProfessional['photo_url'], 'attr') ?>" alt="Foto de <?= esc($heroProfessional['name']) ?>" fetchpriority="high">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/5 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-4 p-5 text-white sm:p-7">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-100">Profissional em destaque</p>
                            <p class="mt-1 text-xl font-bold sm:text-2xl"><?= esc($heroProfessional['name']) ?></p>
                            <p class="mt-1 text-sm text-white/85"><?= esc($heroProfessional['city']) ?><?= ! empty($heroProfessional['state']) ? ', ' . esc($heroProfessional['state']) : '' ?><?= ! empty($heroProfessional['neighborhood']) ? ' · ' . esc($heroProfessional['neighborhood']) : '' ?></p>
                        </div>
                        <a class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-brand-800 shadow-lg transition hover:scale-105" href="<?= site_url('profissionais/' . (int) $heroProfessional['id']) ?>" aria-label="Ver perfil de <?= esc($heroProfessional['name']) ?>">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
                        </a>
                    </div>
                    <div class="absolute right-4 top-4 rounded-full border border-white/50 bg-white/90 px-3 py-1.5 text-xs font-bold text-brand-800 shadow-sm sm:right-6 sm:top-6">Conecta Local</div>
                </div>
            <?php else: ?>
                <div class="relative flex min-h-[19rem] items-end overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-800 via-brand-700 to-cyan-700 p-6 text-white shadow-2xl shadow-brand-900/15 sm:min-h-[25rem] sm:p-8">
                    <div class="absolute -right-12 -top-12 h-60 w-60 rounded-full border-[34px] border-white/10"></div>
                    <div class="absolute -right-10 bottom-10 h-44 w-44 rounded-full bg-cyan-300/20 blur-2xl"></div>
                    <div class="relative">
                        <span class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/20 bg-white/10">
                            <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 11.25 10.5 9a2.12 2.12 0 0 1 3 0l.75.75m-6 1.5 3.75 3.75a2.12 2.12 0 0 0 3 0l3.75-3.75M3 9.75l4.5-4.5 3 3-4.5 4.5L3 9.75Zm18 0-4.5-4.5-3 3 4.5 4.5 3-3Z" /></svg>
                        </span>
                        <p class="mt-6 text-xs font-bold uppercase tracking-[0.16em] text-brand-100">Conexões locais</p>
                        <p class="mt-2 max-w-sm text-2xl font-bold leading-tight sm:text-3xl">Talentos da sua região, a um contato de distância.</p>
                        <p class="mt-3 max-w-sm text-sm leading-6 text-white/75">Descubra serviços locais e encontre a ajuda certa para o que você precisa.</p>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>

<section id="categorias" class="scroll-mt-24 mx-auto max-w-7xl px-5 py-14 sm:px-8 sm:py-16 lg:py-20">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Encontre por especialidade</p>
            <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl">Categorias em destaque</h2>
        </div>
        <a class="inline-flex items-center gap-2 text-sm font-bold text-brand-700 transition hover:text-brand-900" href="<?= site_url('profissionais') ?>">
            Ver todas as categorias
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
        </a>
    </div>
    <?php if ($categories === []): ?>
        <p class="mt-7 rounded-2xl border border-slate-200 bg-white p-6 text-sm text-slate-500">Novas categorias serão exibidas aqui em breve.</p>
    <?php else: ?>
        <div class="mt-7 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4 xl:grid-cols-6">
            <?php foreach ($categories as $category): ?>
                <?= view('public/components/category_card', ['category' => $category]) ?>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</section>

<section class="border-y border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-5 py-14 sm:px-8 sm:py-16 lg:py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Gente boa, perto de você</p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl">Profissionais em destaque</h2>
            </div>
            <a class="inline-flex items-center gap-2 text-sm font-bold text-brand-700 transition hover:text-brand-900" href="<?= site_url('profissionais') ?>">
                Explorar profissionais
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
            </a>
        </div>

        <?php if ($professionals === []): ?>
            <p class="mt-7 rounded-2xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-500">Estamos preparando a rede local. Volte em breve para encontrar profissionais.</p>
        <?php else: ?>
            <div class="mt-7 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($professionals as $professional): ?>
                    <?= view('public/components/professional_card', ['professional' => $professional]) ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>

<section id="sobre" class="scroll-mt-24 mx-auto max-w-7xl px-5 py-14 sm:px-8 sm:py-16 lg:py-20">
    <div class="relative overflow-hidden rounded-[2rem] bg-brand-800 px-6 py-9 text-white sm:px-10 sm:py-11 lg:flex lg:items-center lg:justify-between lg:px-14">
        <div class="pointer-events-none absolute -right-16 -top-28 h-72 w-72 rounded-full border-[44px] border-white/5"></div>
        <div class="relative max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-200">Você trabalha por conta própria?</p>
            <h2 class="mt-3 text-2xl font-extrabold tracking-tight sm:text-3xl">Seu trabalho merece ser encontrado.</h2>
            <p class="mt-3 max-w-xl text-sm leading-6 text-brand-100 sm:text-base">Crie seu perfil e apresente seus serviços para quem está procurando profissionais na sua região.</p>
        </div>
        <a class="relative mt-6 inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-brand-800 shadow-sm transition hover:bg-brand-50 focus:outline-none focus:ring-4 focus:ring-white/30 lg:mt-0" href="<?= site_url('register') ?>">
            Quero me cadastrar
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
        </a>
    </div>
</section>
<?= $this->endSection() ?>
