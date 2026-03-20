@extends('dashboard')

@section('after_head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
<div class="flex h-screen w-full bg-gray-100">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <form method="POST" action="/login" onsubmit="return login()"
              class="flex flex-col w-full max-w-md bg-white rounded-2xl shadow-lg px-8 py-10">
            @csrf

            <h1 class="font-inter font-semibold text-3xl">Accedi al tuo account</h1>
            <p class="text-gray-500 mt-2 text-sm">Inserisci email e password per accedere</p>

            <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>

            <label for="email" class="mt-6 text-sm font-semibold">Email <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="email"
                id="email"
                placeholder="La tua email"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <label for="password" class="mt-4 text-sm font-semibold">Password <span class="text-red-500">*</span></label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="La tua password"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <div class="flex items-center justify-between mt-5">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" id="remember" checked
                           class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    Ricordami
                </label>
                <a href="/password/reset" class="text-sm text-blue-600 hover:underline">Password dimenticata?</a>
            </div>

            <!-- Recaptcha -->
            <?php if(env("RECAPTCHA_ENABLE")){ ?>
                <div class="g-recaptcha mt-6" data-sitekey="<?= env('RECAPTCHA_PUBLIC_KEY') ?>"></div>
            <?php } ?>

            <input type="submit"
                   value="Accedi"
                   class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
            >
        </form>
    </div>

    <div class="hidden md:flex w-1/2 bg-blue-700 items-center justify-center">
        <div class="flex items-center gap-4">
            <img src="/img/logoBianco.png" alt="Logo Agent Core" class="h-14 w-14">
            <div>
                <p class="text-white font-semibold text-3xl">Agent Core</p>
                <p class="text-white text-sm opacity-80">By <a href="https://francescogarofolo.com" class="underline">Francesco Garofolo</a></p>
            </div>
        </div>
    </div>
</div>


<script>
    const login = () => {
        const email = document.getElementById("email").value,
            password = document.getElementById("password").value,
            captcha = document.getElementById("g-recaptcha-response").value;


        if (!email || !password) {
            formError("Tutti i campi sono obbligatori");
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            formError("Inserisci un indirizzo email valido");
            return false;
        }

        //  Validazione: captcha eseguito
        <?php if(env("RECAPTCHA_ENABLE")){ ?>
            if (!captcha) {
                formError("Completa il reCAPTCHA");
                return false;
            }
        <?php } ?>
    }

    const formError = (text) => {
        const error = document.getElementById("form-error");
        error.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> <span>${text}</span>`;
        error.classList.remove("hidden");
        error.classList.add("flex");
    }

    @if($errors->any())
        @foreach ($errors->all() as $errore)
            formError("{{ $errore }}");
        @endforeach
    @endif
</script>
@endsection
