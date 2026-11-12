<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div>
    <p class="text-sm font-semibold uppercase tracking-wider text-teal-700">Faça parte da rede</p>
    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900">Crie sua conta profissional</h2>
    <p class="mt-2 text-sm leading-6 text-slate-600">Conte com o Conecta Local para aproximar seus serviços de novos clientes.</p>

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

    <form class="mt-7 space-y-4" action="<?= site_url('register') ?>" method="post" data-loading-form>
        <?= csrf_field() ?>
        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="name">Nome completo</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="name" name="name" type="text" value="<?= esc($oldInput['name'] ?? '') ?>" autocomplete="name" maxlength="150" required>
            <?php if (isset($validationErrors['name'])): ?>
                <p class="mt-2 text-sm text-red-700" id="name-error"><?= esc($validationErrors['name']) ?></p>
            <?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="email">E-mail</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="email" name="email" type="email" value="<?= esc($oldInput['email'] ?? '') ?>" autocomplete="email" maxlength="150" required>
            <?php if (isset($validationErrors['email'])): ?>
                <p class="mt-2 text-sm text-red-700" id="email-error"><?= esc($validationErrors['email']) ?></p>
            <?php endif ?>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="password">Senha</label>
                <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="255" required>
                <?php if (isset($validationErrors['password'])): ?>
                    <p class="mt-2 text-sm text-red-700" id="password-error"><?= esc($validationErrors['password']) ?></p>
                <?php endif ?>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700" for="password_confirm">Confirme a senha</label>
                <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="password_confirm" name="password_confirm" type="password" autocomplete="new-password" minlength="8" maxlength="255" required>
                <?php if (isset($validationErrors['password_confirm'])): ?>
                    <p class="mt-2 text-sm text-red-700" id="password-confirm-error"><?= esc($validationErrors['password_confirm']) ?></p>
                <?php endif ?>
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="whatsapp">WhatsApp</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="whatsapp" name="whatsapp" type="tel" value="<?= esc($oldInput['whatsapp'] ?? '') ?>" autocomplete="tel" maxlength="20" placeholder="(00) 00000-0000" required>
            <?php if (isset($validationErrors['whatsapp'])): ?>
                <p class="mt-2 text-sm text-red-700" id="whatsapp-error"><?= esc($validationErrors['whatsapp']) ?></p>
            <?php endif ?>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700" for="city">Cidade</label>
            <input class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-teal-600 focus:ring-4 focus:ring-teal-100" id="city" name="city" type="text" value="<?= esc($oldInput['city'] ?? '') ?>" autocomplete="address-level2" maxlength="100" required>
            <?php if (isset($validationErrors['city'])): ?>
                <p class="mt-2 text-sm text-red-700" id="city-error"><?= esc($validationErrors['city']) ?></p>
            <?php endif ?>
        </div>

        <div class="pt-1">
            <label class="flex items-start gap-3 text-sm leading-6 text-slate-600" for="accept_terms">
                <input class="mt-1 h-4 w-4 shrink-0 rounded border-slate-300 text-teal-700 focus:ring-teal-600" id="accept_terms" name="accept_terms" type="checkbox" value="1" <?= ($oldInput['accept_terms'] ?? '') === '1' ? 'checked' : '' ?> required>
                <span>Li e aceito os Termos de Uso e a Política de Privacidade.</span>
            </label>
            <?php if (isset($validationErrors['accept_terms'])): ?>
                <p class="mt-2 text-sm text-red-700" id="accept-terms-error"><?= esc($validationErrors['accept_terms']) ?></p>
            <?php endif ?>
        </div>

        <button class="flex w-full items-center justify-center rounded-xl bg-teal-700 px-5 py-3.5 font-semibold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-200 disabled:cursor-wait disabled:opacity-70" type="submit" data-loading-label="Criando sua conta...">Criar conta profissional</button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">Já tem uma conta?
        <a class="font-semibold text-teal-700 hover:text-teal-900 hover:underline" href="<?= site_url('login') ?>">Entrar</a>
    </p>
</div>
<?= $this->endSection() ?>
