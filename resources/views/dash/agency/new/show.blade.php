@extends('dashboard')

@section('content')
<div class="flex h-screen w-full bg-gray-100 font-sans">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <!-- Form di Registrazione -->
        <form method="POST" action="/dashboard/agency/new" onsubmit="return validateForm()"
              class="flex flex-col w-full max-w-md bg-white rounded-2xl shadow-lg px-8 py-10">
            @csrf

            <h1 class="font-semibold text-3xl">Inserisci una nuova Angezia</h1>
            <p class="text-gray-500 mt-2 text-sm">Compila il modulo per creare una nuova agenzia</p>

            <!-- Contenitore per gli errori -->
            <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>

            <!-- Campo per il Nome -->
            <label for="name" class="mt-6 text-sm font-semibold">Ragione Sociale <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="name"
                id="name"
                placeholder="Es: Roma immobiliare"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Campo per l'Email -->
            <label for="email" class="mt-4 text-sm font-semibold">Email <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="email"
                id="email"
                placeholder="Email dell'agenzia"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <label for="phone" class="mt-4 text-sm font-semibold">Telefono <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="phone"
                id="phone"
                placeholder="Telefono dell'agenzia"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <label for="website" class="mt-4 text-sm font-semibold">Sito web</label>
            <input
                type="text"
                name="website"
                id="website"
                placeholder="Sito web dell'agenzia"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <label for="website" class="mt-4 text-sm font-semibold">Indirizzo</label>
            <input
                type="text"
                name="address"
                id="address"
                placeholder="Indirizzo dell'agenzia"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >

            <!-- Bottone di Registrazione -->
            <input type="submit"
                   value="Crea"
                   class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
            >
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

<script>
    const validateForm = () => {
        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const website = document.getElementById("website").value.trim();

        // Validazione: campi obbligatori
        if (!name || !email || !phone) {
            formError("Nome, email e telefono sono obbligatori");
            return false;
        }

        // Validazione: formato email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            formError("Inserisci un indirizzo email valido");
            return false;
        }

        // Validazione: formato telefono (consente numeri, spazi, + e -)
        const phoneRegex = /^[+]?[\d\s\-]{6,20}$/;
        if (!phoneRegex.test(phone)) {
            formError("Inserisci un numero di telefono valido");
            return false;
        }

        // Validazione: sito web (opzionale, ma se presente deve essere valido)
        if (website) {
            const urlRegex = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(\/.*)?$/;
            if (!urlRegex.test(website)) {
                formError("Inserisci un sito web valido (es: https://www.esempio.com)");
                return false;
            }
        }

        return true;
    }
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