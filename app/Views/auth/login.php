<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Boas-vindas de volta</p>
    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink-950">Entre na sua conta</h2>
    <p class="mt-2 text-sm leading-6 text-slate-500">Acesse sua área profissional no Conecta Local.</p>

    <?php if ($success !== null): ?>
        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm leading-5 text-emerald-800" role="status">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
            <?= esc($success) ?>
        </div>
    <?php endif ?>

    <?php if ($error !== null): ?>
        <div class="mt-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm leading-5 text-red-800" role="alert">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path stroke-linecap="round" d="M12 8v5m0 3h.01" /></svg>
            <?= esc($error) ?>
        </div>
    <?php endif ?>

    <?php if ($validationErrors !== []): ?>
        <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800" role="alert">
            <p class="font-bold">Confira os dados informados:</p>
            <ul class="mt-2 list-inside list-disc space-y-1">
                <?php foreach ($validationErrors as $message): ?>
                    <li><?= esc($message) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form class="mt-7 space-y-5" action="<?= site_url('login') ?>" method="post" data-loading-form>
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="email">E-mail</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-ink-950 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="email" name="email" type="email" value="<?= esc($oldInput['email'] ?? '') ?>" autocomplete="email" maxlength="150" required autofocus aria-describedby="<?= isset($validationErrors['email']) ? 'email-error' : '' ?>">
            <?php if (isset($validationErrors['email'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="email-error"><?= esc($validationErrors['email']) ?></p>
            <?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="password">Senha</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-ink-950 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="password" name="password" type="password" autocomplete="current-password" required>
            <?php if (isset($validationErrors['password'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="password-error"><?= esc($validationErrors['password']) ?></p>
            <?php endif ?>
        </div>

        <button class="flex min-h-12 w-full items-center justify-center rounded-xl bg-brand-700 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 disabled:cursor-wait disabled:opacity-70" type="submit" data-loading-label="Entrando...">Entrar</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">Ainda não tem uma conta?
        <a class="font-bold text-brand-700 transition hover:text-brand-900 hover:underline" href="<?= site_url('register') ?>">Cadastre-se</a>
    </p>
</div>
<?= $this->endSection() ?>
