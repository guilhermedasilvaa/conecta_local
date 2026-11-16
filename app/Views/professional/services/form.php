<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<?php
$isEditing = $service !== null;
$value = static fn (string $key, mixed $default = ''): mixed => old($key, $oldInput[$key] ?? ($service[$key] ?? $default));
$selectedCategory = (string) $value('category_id', $isEditing ? (string) $service['category_id'] : '');
$selectedActive = (string) $value('active', $isEditing ? (string) $service['active'] : '1');
?>
<div>
    <a class="inline-flex items-center gap-2 text-sm font-bold text-brand-800 transition hover:text-brand-900" href="<?= site_url('professional/services') ?>">
        <svg class="h-4 w-4 rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" /></svg>
        Voltar aos meus serviços
    </a>
    <p class="mt-5 text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Catálogo profissional</p>
    <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-ink-950 sm:text-3xl"><?= $isEditing ? 'Editar serviço' : 'Cadastrar serviço' ?></h1>
    <p class="mt-2 text-sm leading-6 text-slate-500 sm:text-base">Preencha as informações que os clientes verão no seu perfil.</p>
</div>

<section class="mt-6 max-w-3xl rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    <form class="space-y-5" action="<?= $isEditing ? site_url('professional/services/' . (int) $service['id']) : site_url('professional/services') ?>" method="post">
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="title">Título do serviço</label>
            <input class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="title" name="title" type="text" maxlength="150" value="<?= esc($value('title')) ?>" required>
            <?php if (isset($validationErrors['title'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['title']) ?></p><?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="description">Descrição</label>
            <textarea class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-6 text-ink-950 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="description" name="description" rows="6" maxlength="5000" required><?= esc($value('description')) ?></textarea>
            <?php if (isset($validationErrors['description'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['description']) ?></p><?php endif ?>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="category_id">Categoria</label>
                <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50" id="category_id" name="category_id" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>" <?= $selectedCategory === (string) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                    <?php endforeach ?>
                </select>
                <?php if (isset($validationErrors['category_id'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['category_id']) ?></p><?php endif ?>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="price">Preço <span class="font-normal text-slate-500">(opcional)</span></label>
                <div class="flex overflow-hidden rounded-xl border border-slate-200 bg-slate-50 transition focus-within:border-brand-500 focus-within:bg-white focus-within:ring-4 focus-within:ring-brand-50">
                    <span class="flex items-center border-r border-slate-200 px-3 text-sm font-bold text-slate-500">R$</span>
                    <input class="min-w-0 flex-1 bg-transparent px-4 py-3 text-sm text-ink-950 outline-none" id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" value="<?= esc($value('price')) ?>" placeholder="0,00">
                </div>
                <?php if (isset($validationErrors['price'])): ?><p class="mt-1.5 text-sm font-medium text-red-700"><?= esc($validationErrors['price']) ?></p><?php endif ?>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="active">Situação</label>
            <select class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-50 sm:max-w-xs" id="active" name="active">
                <option value="1" <?= $selectedActive === '1' ? 'selected' : '' ?>>Ativo — visível no catálogo</option>
                <option value="0" <?= $selectedActive === '0' ? 'selected' : '' ?>>Inativo — oculto do catálogo</option>
            </select>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
            <a class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50" href="<?= site_url('professional/services') ?>">Cancelar</a>
            <button class="inline-flex min-h-11 items-center justify-center rounded-xl bg-brand-700 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100" type="submit"><?= $isEditing ? 'Salvar alterações' : 'Cadastrar serviço' ?></button>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
