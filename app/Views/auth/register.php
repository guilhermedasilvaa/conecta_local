<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-700">Faça parte da rede</p>
    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-ink-950">Crie sua conta profissional</h2>
    <p class="mt-2 text-sm leading-6 text-slate-500">Conte com o Conecta Local para aproximar seus serviços de novos clientes.</p>

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

    <form class="mt-6 space-y-4" action="<?= site_url('register') ?>" method="post" data-loading-form>
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="name">Nome completo</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="name" name="name" type="text" value="<?= esc($oldInput['name'] ?? '') ?>" autocomplete="name" maxlength="150" required>
            <?php if (isset($validationErrors['name'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="name-error"><?= esc($validationErrors['name']) ?></p>
            <?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="email">E-mail</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="email" name="email" type="email" value="<?= esc($oldInput['email'] ?? '') ?>" autocomplete="email" maxlength="150" required>
            <?php if (isset($validationErrors['email'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="email-error"><?= esc($validationErrors['email']) ?></p>
            <?php endif ?>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="password">Senha</label>
                <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="255" required>
                <?php if (isset($validationErrors['password'])): ?>
                    <p class="mt-1.5 text-sm font-medium text-red-700" id="password-error"><?= esc($validationErrors['password']) ?></p>
                <?php endif ?>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="password_confirm">Confirme a senha</label>
                <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="password_confirm" name="password_confirm" type="password" autocomplete="new-password" minlength="8" maxlength="255" required>
                <?php if (isset($validationErrors['password_confirm'])): ?>
                    <p class="mt-1.5 text-sm font-medium text-red-700" id="password-confirm-error"><?= esc($validationErrors['password_confirm']) ?></p>
                <?php endif ?>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="whatsapp">WhatsApp</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="whatsapp" name="whatsapp" type="tel" value="<?= esc($oldInput['whatsapp'] ?? '') ?>" autocomplete="tel" maxlength="20" placeholder="(00) 00000-0000" required>
            <?php if (isset($validationErrors['whatsapp'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="whatsapp-error"><?= esc($validationErrors['whatsapp']) ?></p>
            <?php endif ?>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
            <label class="mb-2 block text-sm font-bold text-ink-950" for="city">Cidade</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="city" name="city" type="text" value="<?= esc($oldInput['city'] ?? '') ?>" autocomplete="address-level2" maxlength="100" required>
            <?php if (isset($validationErrors['city'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="city-error"><?= esc($validationErrors['city']) ?></p>
            <?php endif ?>
            </div>
            <div>
                <label class="mb-2 block text-sm font-bold text-ink-950" for="state">Estado</label>
                <select class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-ink-950 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-50" id="state" name="state" autocomplete="address-level1" required>
                    <option value="">Selecione seu estado</option>
                    <?php foreach ($states as $uf => $stateName): ?>
                        <option value="<?= esc($uf) ?>" <?= ($oldInput['state'] ?? '') === $uf ? 'selected' : '' ?>><?= esc($stateName) ?> (<?= esc($uf) ?>)</option>
                    <?php endforeach ?>
                </select>
                <?php if (isset($validationErrors['state'])): ?>
                    <p class="mt-1.5 text-sm font-medium text-red-700" id="state-error"><?= esc($validationErrors['state']) ?></p>
                <?php endif ?>
            </div>
        </div>

        <div class="pt-1">
            <label class="flex items-start gap-3 text-sm leading-6 text-slate-500" for="accept_terms">
                <input class="mt-1 h-4 w-4 shrink-0 rounded border-slate-300 text-brand-700 focus:ring-brand-500" id="accept_terms" name="accept_terms" type="checkbox" value="1" <?= ($oldInput['accept_terms'] ?? '') === '1' ? 'checked' : '' ?> required>
                <span>Li e aceito os Termos de Uso e a Política de Privacidade.</span>
            </label>
            <?php if (isset($validationErrors['accept_terms'])): ?>
                <p class="mt-1.5 text-sm font-medium text-red-700" id="accept-terms-error"><?= esc($validationErrors['accept_terms']) ?></p>
            <?php endif ?>
        </div>

        <button class="flex min-h-12 w-full items-center justify-center rounded-xl bg-brand-700 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-4 focus:ring-brand-100 disabled:cursor-wait disabled:opacity-70" type="submit" data-loading-label="Criando sua conta...">Criar conta profissional</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">Já tem uma conta?
        <a class="font-bold text-brand-700 transition hover:text-brand-900 hover:underline" href="<?= site_url('login') ?>">Entrar</a>
    </p>
</div>
<?= $this->endSection() ?>
