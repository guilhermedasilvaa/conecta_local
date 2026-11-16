<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Seu espaço na rede local</p>
    <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl">Meu perfil profissional</h1>
    <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">Essas informações ajudam clientes da sua região a conhecer e encontrar você.</p>
</div>

<?php
$photoUrl = null;
$photo = $profile['photo'] ?? null;
if (is_string($photo) && trim($photo) !== '') {
    $scheme = parse_url($photo, PHP_URL_SCHEME);
    if ($scheme !== null && in_array(strtolower($scheme), ['http', 'https'], true)) {
        $photoUrl = $photo;
    } elseif ($scheme === null && ! str_contains($photo, '..') && ! str_contains($photo, "\0")) {
        $photoUrl = base_url(ltrim(str_replace('\\', '/', $photo), '/'));
    }
}
$value = static fn (string $key): mixed => old($key, $oldInput[$key] ?? $profile[$key] ?? '');
?>

<div class="mt-6 grid gap-5 xl:grid-cols-[minmax(0,1fr)_19rem] xl:gap-6">
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="border-b border-slate-100 pb-4">
            <p class="text-xs font-bold uppercase tracking-[0.12em] text-brand-700">Informações públicas</p>
            <h2 class="mt-1 text-lg font-extrabold text-ink-950">Apresente seu trabalho</h2>
        </div>
        <form class="mt-5 space-y-5" action="<?= site_url('professional/profile') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="name">Nome completo</label>
                <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="name" name="name" type="text" maxlength="150" value="<?= esc($value('name')) ?>" autocomplete="name" required>
                <?php if (isset($validationErrors['name'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['name']) ?></p><?php endif ?>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-ink-950" for="phone">Telefone</label>
                    <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($value('phone')) ?>" autocomplete="tel">
                    <?php if (isset($validationErrors['phone'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['phone']) ?></p><?php endif ?>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-ink-950" for="whatsapp">WhatsApp</label>
                    <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="whatsapp" name="whatsapp" type="tel" maxlength="20" value="<?= esc($value('whatsapp')) ?>" autocomplete="tel" required>
                    <?php if (isset($validationErrors['whatsapp'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['whatsapp']) ?></p><?php endif ?>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-bold text-ink-950" for="city">Cidade</label>
                    <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="city" name="city" type="text" maxlength="100" value="<?= esc($value('city')) ?>" autocomplete="address-level2" required>
                    <?php if (isset($validationErrors['city'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['city']) ?></p><?php endif ?>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-ink-950" for="state">Estado</label>
                    <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="state" name="state" autocomplete="address-level1" required>
                        <option value="">Selecione seu estado</option>
                        <?php foreach ($states as $uf => $stateName): ?>
                            <option value="<?= esc($uf) ?>" <?= $value('state') === $uf ? 'selected' : '' ?>><?= esc($stateName) ?> (<?= esc($uf) ?>)</option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($validationErrors['state'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['state']) ?></p><?php endif ?>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-ink-950" for="neighborhood">Bairro <span class="font-normal text-slate-500">(opcional)</span></label>
                    <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="neighborhood" name="neighborhood" type="text" maxlength="100" value="<?= esc($value('neighborhood')) ?>" autocomplete="address-level3">
                    <?php if (isset($validationErrors['neighborhood'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['neighborhood']) ?></p><?php endif ?>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="description">Sobre seu trabalho <span class="font-normal text-slate-500">(opcional)</span></label>
                <textarea class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-ink-950 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="description" name="description" rows="5" maxlength="5000" placeholder="Conte um pouco sobre sua experiência e como pode ajudar."><?= esc($value('description')) ?></textarea>
                <?php if (isset($validationErrors['description'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['description']) ?></p><?php endif ?>
            </div>

            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="photo">Foto de perfil</label>
                <p class="mb-2 text-xs text-slate-500">JPG, PNG ou WEBP; até 2 MB.</p>
                <input class="block w-full rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-brand-50 file:px-4 file:py-3 file:font-bold file:text-brand-800 hover:file:bg-brand-100" id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp">
                <?php if (isset($validationErrors['photo'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['photo']) ?></p><?php endif ?>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
                <a class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50" href="<?= site_url('professional/dashboard') ?>">Cancelar</a>
                <button class="inline-flex min-h-11 items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100" type="submit">Salvar alterações</button>
            </div>
        </form>
    </section>

    <aside class="space-y-4">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-sm font-extrabold text-ink-950">Visibilidade no catálogo</h2>
                <span class="rounded-full px-2.5 py-1 text-[11px] font-bold <?= (int) $profile['active'] === 1 ? 'bg-emerald-50 text-emerald-800' : 'bg-slate-100 text-slate-500' ?>"><?= (int) $profile['active'] === 1 ? 'Ativo' : 'Inativo' ?></span>
            </div>
            <div class="mt-4 flex min-w-0 items-center gap-3 rounded-xl bg-slate-50 p-3">
                <?php if ($photoUrl !== null): ?>
                    <img class="h-14 w-14 shrink-0 rounded-xl object-cover" src="<?= esc($photoUrl, 'attr') ?>" alt="Foto de perfil" loading="lazy">
                <?php else: ?>
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-xl font-extrabold text-brand-800" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($profile['name'], 0, 1))) ?></span>
                <?php endif ?>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold text-ink-950"><?= esc($profile['name']) ?></p>
                    <p class="mt-1 truncate text-xs text-slate-500"><?= esc($profile['city']) ?><?= ! empty($profile['state']) ? ', ' . esc($profile['state']) : '' ?></p>
                </div>
            </div>
            <p class="mt-4 text-xs leading-5 text-slate-500">Seu perfil está <strong class="text-slate-700"><?= (int) $profile['active'] === 1 ? 'ativo' : 'inativo' ?></strong>. Quando desativado, não aparece no catálogo.</p>
            <form class="mt-4" action="<?= site_url('professional/profile/status') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="active" value="<?= (int) $profile['active'] === 1 ? '0' : '1' ?>">
                <button class="w-full rounded-xl border px-4 py-3 text-sm font-bold transition <?= (int) $profile['active'] === 1 ? 'border-red-200 text-red-700 hover:bg-red-50' : 'border-emerald-200 text-emerald-800 hover:bg-emerald-50' ?>" type="submit">
                    <?= (int) $profile['active'] === 1 ? 'Desativar perfil' : 'Ativar perfil' ?>
                </button>
            </form>
        </section>
        <?php if ($photoUrl !== null): ?>
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-sm font-extrabold text-ink-950">Foto atual</h2>
                <img class="mt-4 aspect-square w-full rounded-xl object-cover" src="<?= esc($photoUrl, 'attr') ?>" alt="Foto atual de <?= esc($profile['name']) ?>" loading="lazy">
            </section>
        <?php endif ?>
    </aside>
</div>
<?= $this->endSection() ?>
