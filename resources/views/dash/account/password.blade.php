@extends('dashboard')

@section('content')

<form method="POST" class="p-10 flex flex-col items-center" onsubmit="return check()">
    @csrf

    <div class="w-full">
        <a href="/dashboard" class="mb-2 text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna alla Dashboard</a>
    </div>

    <div class="flex flex-col bg-white rounded-2xl shadow-lg px-7 py-7">
        <h1 class="font-inter font-semibold text-2xl">Cambia password</h1>

        <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>

        <label for="old_pass" class="text-sm font-semibold mt-5">Vecchia password <span class="text-red-500">*</span></label>
        <input
            type="password"
            name="old_pass"
            id="old_pass"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="new_pass" class="text-sm font-semibold mt-5">Nuova password <span class="text-red-500">*</span></label>
        <input
            type="password"
            name="new_pass"
            id="new_pass"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="new_pass" class="text-sm font-semibold mt-5">Ripeti password <span class="text-red-500">*</span></label>
        <input
            type="password"
            name="re_new_pass"
            id="re_new_pass"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >
    </div> 

    
    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
</form>

<script>
    const check = () => {
        const old_pass = document.getElementById("old_pass").value
        const new_pass = document.getElementById("new_pass").value
        const re_new_pass = document.getElementById("re_new_pass").value

        if(!old_pass.trim() || !new_pass.trim() || !re_new_pass.trim()){
            formError("Tutti i campi sono obbligatori")
            return false
        }

        if(new_pass != re_new_pass){
            formError("Le password non corrispondono")
            return false
        }
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