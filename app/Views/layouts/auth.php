<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#087e80">
    <title><?= esc($title) ?> | Conecta Local</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body class="min-h-screen bg-slate-50 text-ink-950 antialiased">
    <main class="mx-auto flex min-h-screen max-w-[100rem] flex-col lg:flex-row">
        <aside class="relative isolate flex min-h-64 flex-col justify-between overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 px-5 py-6 text-white sm:px-9 sm:py-8 lg:min-h-screen lg:w-[42%] lg:px-12 lg:py-11 xl:px-16">
            <div class="pointer-events-none absolute -right-20 -top-20 -z-10 h-72 w-72 rounded-full border-[48px] border-white/5"></div>
            <div class="pointer-events-none absolute -bottom-36 -left-20 -z-10 h-80 w-80 rounded-full bg-cyan-400/10 blur-2xl"></div>
            <a class="relative inline-flex w-fit items-center gap-2.5 text-lg font-extrabold tracking-tight" href="<?= site_url('/') ?>">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-xs ring-1 ring-white/15" aria-hidden="true">CL</span>
                Conecta Local
            </a>
            <div class="relative my-8 max-w-lg lg:my-auto">
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.16em] text-brand-200">Talentos perto de você</p>
                <h1 class="text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">O seu trabalho merece ser encontrado.</h1>
                <p class="mt-4 max-w-md text-sm leading-7 text-brand-100 sm:text-base">Crie sua presença profissional e conecte seus serviços a quem precisa deles na sua região.</p>
                <div class="mt-7 grid gap-3 text-sm font-medium text-white/90 sm:grid-cols-2 lg:grid-cols-1">
                    <span class="inline-flex items-center gap-2.5"><svg class="h-5 w-5 text-brand-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7" /></svg>Mostre seus serviços para sua região</span>
                    <span class="inline-flex items-center gap-2.5"><svg class="h-5 w-5 text-brand-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20 11.5a8.3 8.3 0 0 1-12.2 7.3L4 20l1.2-3.7A8.3 8.3 0 1 1 20 11.5Z" /></svg>Converse diretamente com clientes</span>
                </div>
            </div>
            <p class="relative text-xs text-brand-200">Conectando pessoas e serviços locais.</p>
        </aside>

        <section class="flex flex-1 items-center justify-center px-5 py-8 sm:px-8 sm:py-10 lg:px-12 lg:py-12">
            <div class="w-full max-w-lg">
                <div class="mb-7 lg:hidden">
                    <a class="inline-flex items-center gap-2.5 font-extrabold text-brand-800" href="<?= site_url('/') ?>">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-100 text-xs font-extrabold" aria-hidden="true">CL</span>
                        Conecta Local
                    </a>
                </div>
                <?= $this->renderSection('content') ?>
                <p class="mt-8 text-center text-xs leading-5 text-slate-400">Ao continuar, use a plataforma de forma responsável e mantenha seus dados de acesso seguros.</p>
            </div>
        </section>
    </main>
    <script src="<?= base_url('assets/js/location-fields.js') ?>" defer></script>
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
