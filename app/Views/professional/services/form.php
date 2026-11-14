<?= $this->extend('layouts/professional') ?>

<?= $this->section('content') ?>
<?php
$isEditing = $service !== null;
$value = static fn (string $key, mixed $default = ''): mixed => old($key, $oldInput[$key] ?? ($service[$key] ?? $default));
$selectedCategory = (string) $value('category_id', $isEditing ? (string) $service['category_id'] : '');
$selectedActive = (string) $value('active', $isEditing ? (string) $service['active'] : '1');
?>
<div>
    <a class="text-sm font-semibold text-teal-800 hover:underline" href="<?= site_url('professional/services') ?>">← Voltar aos meus serviços</a>
    <p class="mt-5 text-sm font-semibold uppercase tracking-wider text-teal-700">Catálogo profissional</p>
    <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900"><?= $isEditing ? 'Editar serviço' : 'Cadastrar serviço' ?></h1>
    <p class="mt-2 text-slate-600">Preencha as informações que os clientes verão no seu perfil.</p>
</div>

<section class="mt-7 max-w-3xl rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    <form class="space-y-5" action="<?= $isEditing ? site_url('professional/services/' . (int) $service['id']) : site_url('professional/services') ?>" method="post">
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="title">Título do serviço</label>
            <input class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="title" name="title" type="text" maxlength="150" value="<?= esc($value('title')) ?>" required>
            <?php if (isset($validationErrors['title'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['title']) ?></p><?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="description">Descrição</label>
            <textarea class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="description" name="description" rows="6" maxlength="5000" required><?= esc($value('description')) ?></textarea>
            <?php if (isset($validationErrors['description'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['description']) ?></p><?php endif ?>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="category_id">Categoria</label>
                <select class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="category_id" name="category_id" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>" <?= $selectedCategory === (string) $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                    <?php endforeach ?>
                </select>
                <?php if (isset($validationErrors['category_id'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['category_id']) ?></p><?php endif ?>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="price">Preço <span class="font-normal text-slate-500">(opcional)</span></label>
                <div class="flex overflow-hidden rounded-xl border border-slate-300 focus-within:border-teal-600 focus-within:ring-4 focus-within:ring-teal-100">
                    <span class="flex items-center border-r border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-600">R$</span>
                    <input class="min-w-0 flex-1 px-4 py-3 outline-none" id="price" name="price" type="number" min="0" max="99999999.99" step="0.01" value="<?= esc($value('price')) ?>" placeholder="0,00">
                </div>
                <?php if (isset($validationErrors['price'])): ?><p class="mt-1 text-sm text-red-700"><?= esc($validationErrors['price']) ?></p><?php endif ?>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="active">Situação</label>
            <select class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none focus:border-teal-600 focus:ring-4 focus:ring-teal-100 sm:max-w-xs" id="active" name="active">
                <option value="1" <?= $selectedActive === '1' ? 'selected' : '' ?>>Ativo — visível no catálogo</option>
                <option value="0" <?= $selectedActive === '0' ? 'selected' : '' ?>>Inativo — oculto do catálogo</option>
            </select>
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
            <a class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50" href="<?= site_url('professional/services') ?>">Cancelar</a>
            <button class="rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200" type="submit"><?= $isEditing ? 'Salvar alterações' : 'Cadastrar serviço' ?></button>
        </div>
    </form>
</section>
<?= $this->endSection() ?>
