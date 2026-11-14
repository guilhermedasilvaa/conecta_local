<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Seu espaço na rede local</p>
    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Meu perfil profissional</h1>
    <p class="mt-2 text-slate-600">Essas informações ajudam clientes da sua região a conhecer e encontrar você.</p>
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

<div class="mt-7 grid gap-6 xl:grid-cols-[minmax(0,1fr)_20rem]">
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <h2 class="text-lg font-bold text-slate-900">Informações públicas</h2>
        <form class="mt-6 space-y-5" action="<?= site_url('professional/profile') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="name">Nome completo</label>
                <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="name" name="name" type="text" maxlength="150" value="<?= esc($value('name')) ?>" autocomplete="name" required>
                <?php if (isset($validationErrors['name'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['name']) ?></p><?php endif ?>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="phone">Telefone</label>
                    <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="phone" name="phone" type="tel" maxlength="20" value="<?= esc($value('phone')) ?>" autocomplete="tel">
                    <?php if (isset($validationErrors['phone'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['phone']) ?></p><?php endif ?>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="whatsapp">WhatsApp</label>
                    <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="whatsapp" name="whatsapp" type="tel" maxlength="20" value="<?= esc($value('whatsapp')) ?>" autocomplete="tel" required>
                    <?php if (isset($validationErrors['whatsapp'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['whatsapp']) ?></p><?php endif ?>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="city">Cidade</label>
                    <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="city" name="city" type="text" maxlength="100" value="<?= esc($value('city')) ?>" autocomplete="address-level2" required>
                    <?php if (isset($validationErrors['city'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['city']) ?></p><?php endif ?>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700" for="neighborhood">Bairro <span class="font-normal text-slate-500">(opcional)</span></label>
                    <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="neighborhood" name="neighborhood" type="text" maxlength="100" value="<?= esc($value('neighborhood')) ?>" autocomplete="address-level3">
                    <?php if (isset($validationErrors['neighborhood'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['neighborhood']) ?></p><?php endif ?>
                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="description">Sobre seu trabalho <span class="font-normal text-slate-500">(opcional)</span></label>
                <textarea class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="description" name="description" rows="5" maxlength="5000" placeholder="Conte um pouco sobre sua experiência e como pode ajudar."><?= esc($value('description')) ?></textarea>
                <?php if (isset($validationErrors['description'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['description']) ?></p><?php endif ?>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="photo">Foto de perfil <span class="font-normal text-slate-500">(JPG, PNG ou WEBP; até 2 MB)</span></label>
                <input class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700 file:mr-4 file:border-0 file:bg-teal-50 file:px-4 file:py-3 file:font-semibold file:text-teal-800 hover:file:bg-teal-100" id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp">
                <?php if (isset($validationErrors['photo'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['photo']) ?></p><?php endif ?>
            </div>

            <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
                <a class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="<?= site_url('professional/dashboard') ?>">Cancelar</a>
                <button class="rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200" type="submit">Salvar alterações</button>
            </div>
        </form>
    </section>

    <aside class="space-y-5">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-bold text-slate-900">Visibilidade no catálogo</h2>
            <div class="mt-4 flex items-center gap-3">
                <?php if ($photoUrl !== null): ?>
                    <img class="h-16 w-16 rounded-xl object-cover" src="<?= esc($photoUrl, 'attr') ?>" alt="Foto de perfil" loading="lazy">
                <?php else: ?>
                    <span class="flex h-16 w-16 items-center justify-center rounded-xl bg-teal-50 text-2xl font-bold text-teal-800" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($profile['name'], 0, 1))) ?></span>
                <?php endif ?>
                <div>
                    <p class="font-semibold text-slate-900"><?= esc($profile['name']) ?></p>
                    <p class="text-sm text-slate-600"><?= esc($profile['city']) ?></p>
                </div>
            </div>
            <p class="mt-4 text-sm leading-6 text-slate-600">Seu perfil está <strong><?= (int) $profile['active'] === 1 ? 'ativo' : 'inativo' ?></strong>. Quando desativado, seu perfil não aparece no catálogo.</p>
            <form class="mt-5" action="<?= site_url('professional/profile/status') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="active" value="<?= (int) $profile['active'] === 1 ? '0' : '1' ?>">
                <button class="w-full rounded-xl border px-4 py-3 text-sm font-semibold transition <?= (int) $profile['active'] === 1 ? 'border-red-200 text-red-700 hover:bg-red-50' : 'border-emerald-200 text-emerald-800 hover:bg-emerald-50' ?>" type="submit">
                    <?= (int) $profile['active'] === 1 ? 'Desativar perfil' : 'Ativar perfil' ?>
                </button>
            </form>
        </section>
        <?php if ($photoUrl !== null): ?>
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="font-bold text-slate-900">Foto atual</h2>
                <img class="mt-4 aspect-square w-full rounded-xl object-cover" src="<?= esc($photoUrl, 'attr') ?>" alt="Foto atual de <?= esc($profile['name']) ?>" loading="lazy">
            </section>
        <?php endif ?>
    </aside>
</div>
<?= $this->endSection() ?>
