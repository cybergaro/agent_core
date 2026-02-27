@extends('dashboard')

@section('content')
<div class="flex h-screen w-full bg-gray-100 font-sans overflow-hidden">
    
    <div class="w-full md:w-1/2 h-full overflow-y-auto">
        <div class="h-10"></div>
        <div class="min-h-full flex items-center justify-center py-12 px-4">
            
            <form method="POST" action="/createAdmin" onsubmit="return validateForm()"
                  class="flex flex-col w-full max-w-md bg-white rounded-2xl shadow-lg px-8 py-10">
                @csrf

                <h1 class="font-semibold text-3xl">Benvenuto!!</h1>
                <p class="text-gray-500 mt-2 text-sm">Complimenti per aver completato l'installazione, crea l'utente amministratore</p>

                <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>

                <label for="name" class="mt-6 text-sm font-semibold">Nome <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Il tuo nome"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >

                <label for="surname" class="mt-6 text-sm font-semibold">Cognome <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="surname"
                    id="surname"
                    placeholder="Il tuo Cognome"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >

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

                <label for="password" class="mt-4 text-sm font-semibold">Password <span class="text-red-500">*</span></label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="La tua password"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >

                <label for="password_confirmation" class="mt-4 text-sm font-semibold">Conferma Password <span class="text-red-500">*</span></label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Conferma la tua password"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >

                <input type="submit" value="Continuiamo" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition">

            </form>
        </div>

        <div class="h-10"></div>

    </div>

    <div class="hidden md:flex w-1/2 h-full bg-blue-700 items-center justify-center">
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
        

        if (!name || !email || !password || !passwordConfirmation) {
            formError("Tutti i campi sono obbligatori");
            return false;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            formError("Inserisci un indirizzo email valido");
            return false;
        }

        if (password !== passwordConfirmation) {
            formError("Le password non corrispondono");
            return false;
        }

        return true;
    }

    const formError = (text) => {
        const error = document.getElementById("form-error");
        error.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> <span>${text}</span>`;
        error.classList.remove("hidden");
        error.classList.add("flex");
        // Scroll verso l'errore all'interno del contenitore scrollabile
        error.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    @if($errors->any())
        @foreach ($errors->all() as $errore)
            formError("{{ $errore }}");
        @endforeach
    @endif
</script>
@endsection