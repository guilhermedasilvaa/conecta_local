<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f766e">
    <title><?= esc($title) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <main class="flex min-h-screen flex-col lg:flex-row">
        <aside class="relative flex min-h-64 flex-col justify-between overflow-hidden bg-teal-800 px-6 py-8 text-white sm:px-10 lg:min-h-screen lg:w-5/12 lg:px-14 lg:py-12">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-teal-700 opacity-70"></div>
            <div class="absolute -bottom-28 -left-20 h-80 w-80 rounded-full border-[40px] border-teal-700 opacity-70"></div>
            <a class="relative inline-flex w-fit items-center gap-3 text-lg font-bold tracking-tight" href="<?= site_url('/') ?>">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/15 text-xl" aria-hidden="true">+</span>
                Conecta Local
            </a>
            <div class="relative my-10 max-w-lg lg:my-auto">
                <p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-teal-200">Talentos perto de você</p>
                <h1 class="text-3xl font-bold leading-tight sm:text-4xl">O seu trabalho merece ser encontrado.</h1>
                <p class="mt-5 max-w-md text-base leading-7 text-teal-100">Crie sua presença profissional e conecte seus serviços a quem precisa deles na sua região.</p>
            </div>
            <p class="relative text-sm text-teal-200">Conectando pessoas e serviços locais.</p>
        </aside>

        <section class="flex flex-1 items-center justify-center px-5 py-10 sm:px-8 lg:px-12">
            <div class="w-full max-w-lg">
                <div class="mb-8 lg:hidden">
                    <a class="inline-flex items-center gap-2 font-bold text-teal-800" href="<?= site_url('/') ?>">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-100 text-xl" aria-hidden="true">+</span>
                        Conecta Local
                    </a>
                </div>
                <?= $this->renderSection('content') ?>
                <p class="mt-10 text-center text-xs leading-5 text-slate-500">Ao continuar, use a plataforma de forma responsável e mantenha seus dados de acesso seguros.</p>
            </div>
        </section>
    </main>
    <script {csp-script-nonce}>
        document.querySelectorAll('form[data-loading-form]').forEach((form) => {
            form.addEventListener('submit', () => {
                const button = form.querySelector('button[type="submit"]');
                if (!button) return;
                button.disabled = true;
                button.textContent = button.dataset.loadingLabel || 'Enviando...';
            });
        });
    </script>
</body>
</html>
