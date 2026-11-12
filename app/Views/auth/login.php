<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Boas-vindas de volta</p>
    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Entre na sua conta</h2>
    <p class="mt-2 text-sm leading-6 text-slate-600">Acesse sua área profissional no Conecta Local.</p>

    <?php if ($success !== null): ?>
        <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
            <?= esc($success) ?>
        </div>
    <?php endif ?>

    <?php if ($error !== null): ?>
        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            <?= esc($error) ?>
        </div>
    <?php endif ?>

    <?php if ($validationErrors !== []): ?>
        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
            <p class="font-semibold">Confira os dados informados:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                <?php foreach ($validationErrors as $message): ?>
                    <li><?= esc($message) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form class="mt-8 space-y-5" action="<?= site_url('login') ?>" method="post" data-loading-form>
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="email">E-mail</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="email" name="email" type="email" value="<?= esc($oldInput['email'] ?? '') ?>" autocomplete="email" maxlength="150" required autofocus aria-describedby="<?= isset($validationErrors['email']) ? 'email-error' : '' ?>">
            <?php if (isset($validationErrors['email'])): ?>
                <p class="mt-2 text-sm text-red-700" id="email-error"><?= esc($validationErrors['email']) ?></p>
            <?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="password">Senha</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="password" name="password" type="password" autocomplete="current-password" required>
            <?php if (isset($validationErrors['password'])): ?>
                <p class="mt-2 text-sm text-red-700" id="password-error"><?= esc($validationErrors['password']) ?></p>
            <?php endif ?>
        </div>

        <button class="flex w-full items-center justify-center rounded-xl bg-teal-700 px-5 py-3.5 font-semibold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200 disabled:cursor-wait disabled:opacity-70" type="submit" data-loading-label="Entrando...">Entrar</button>
    </form>

    <p class="mt-7 text-center text-sm text-slate-600">Ainda não tem uma conta?
        <a class="font-semibold text-teal-700 hover:text-teal-900 hover:underline" href="<?= site_url('register') ?>">Cadastre-se</a>
    </p>
</div>
<?= $this->endSection() ?>
