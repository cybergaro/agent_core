@extends('dashboard')

@section('content')
<div class="flex h-screen w-full bg-gray-100 font-sans">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <!-- Form di Registrazione -->
        <form method="POST" action="/registration" onsubmit="return validateForm()"
              class="flex flex-col w-full max-w-md bg-white rounded-2xl shadow-lg px-8 py-10">
            @csrf

            <h1 class="font-semibold text-3xl">Crea un nuovo account</h1>
            <p class="text-gray-500 mt-2 text-sm">Compila il modulo per registrarti</p>

            <!-- Contenitore per gli errori -->
            <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>

            <!-- Campo per il Nome -->
            <label for="name" class="mt-6 text-sm font-semibold">Nome <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="name"
                id="name"
                placeholder="Il tuo nome"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Cognome -->
            <label for="surname" class="mt-6 text-sm font-semibold">Cognome <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="surname"
                id="surname"
                placeholder="Il tuo Cognome"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Campo per l'Email -->
            <label for="email" class="mt-4 text-sm font-semibold">Email <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="email"
                id="email"
                placeholder="La tua email"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <label for="phone" class="mt-4 text-sm font-semibold">Telefono <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="phone"
                id="phone"
                placeholder="Il tuo telefono"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Campo per la Password -->
            <label for="password" class="mt-4 text-sm font-semibold">Password <span class="text-red-500">*</span></label>
            <input
                type="password"
                name="password"
                id="password"
                placeholder="La tua password"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Campo per la Conferma Password -->
            <label for="password_confirmation" class="mt-4 text-sm font-semibold">Conferma Password <span class="text-red-500">*</span></label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                placeholder="Conferma la tua password"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Recaptcha -->
            <?php if(env("RECAPTCHA_ENABLE")){ ?>
                <div class="g-recaptcha mt-6" data-sitekey="<?= env('RECAPTCHA_SITE_KEY') ?>"></div>
            <?php } ?>

            <!-- Bottone di Registrazione -->
            <input type="submit"
                   value="Registrati"
                   class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
            >

            <!-- Link per il Login -->
            <p class="text-center text-sm mt-4 text-gray-600">
                Hai già un account?
                <a href="/login" class="text-blue-600 hover:underline">Accedi</a>
            </p>
        </form>
    </div>

    <!-- Sezione di destra con logo -->
    <div class="hidden md:flex w-1/2 bg-blue-700 items-center justify-center">
        <div class="flex items-center gap-4">
            <img src="/img/logoBianco.png" alt="Logo Agent Core" class="h-14 w-14">
            <p class="text-white font-semibold text-3xl">Agent Core</p>
        </div>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    /**
     * @brief Funzione per validare il modulo di registrazione lato client.
     * @return {boolean} True se il modulo è valido, altrimenti False.
     */
    const validateForm = () => {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const passwordConfirmation = document.getElementById("password_confirmation").value;
        const captcha = document.getElementById("g-recaptcha-response").value;

        // Validazione: tutti i campi sono obbligatori
        if (!name || !email || !password || !passwordConfirmation) {
            formError("Tutti i campi sono obbligatori");
            return false;
        }

        // Validazione: formato email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            formError("Inserisci un indirizzo email valido");
            return false;
        }

        // Validazione: le password devono corrispondere
        if (password !== passwordConfirmation) {
            formError("Le password non corrispondono");
            return false;
        }

        //  Validazione: captcha eseguito
        <?php if(env("RECAPTCHA_ENABLE")){ ?>
            if (!captcha) {
                formError("Completa il reCAPTCHA");
                return false;
            }
        <?php } ?>

        return true;
    }

    /**
     * @brief Funzione per mostrare un messaggio di errore nel modulo.
     * @param {string} text Il testo dell'errore da visualizzare.
     */
    const formError = (text) => {
        const error = document.getElementById("form-error");
        error.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> <span>${text}</span>`;
        error.classList.remove("hidden");
        error.classList.add("flex");
    }

    // Gestione degli errori di Laravel (passati dalla sessione)
    @if($errors->any())
        @foreach ($errors->all() as $errore)
            formError("{{ $errore }}");
        @endforeach
    @endif
</script>
@endsection