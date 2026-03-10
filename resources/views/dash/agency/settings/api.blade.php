@extends('dashboard')

@section('content')
<?php $uuid = request()->route('agencyUuid'); ?>

<form method="POST" action="/dashboard/<?= $uuid ?>/settings/api" class="p-10">
    <div class="flex flex-col w-full bg-white rounded-2xl px-7 py-7">
        @csrf

        <h1 class="font-inter font-semibold text-2xl">Generale</h1>

        <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>
       
        <div class="flex mt-4 gap-5">

            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input
                    type="checkbox"
                    name="website_connection"
                    id="website_connection"
                    <?= $agency->website_connection ? "checked" : "" ?>
                    class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                >
                Abilita l'uso delle API
            </label>
        </div>
    </div>
    <div class="flex flex-col w-full bg-white rounded-2xl px-7 py-7 mt-6">
        <h1 class="font-inter font-semibold text-2xl">Re-Captcha</h1>
        <p class="mt-2 text-sm">
            Alcune API Agent Core supportano la validazione delle richieste con il sistema Google Re-Captcha, tra cui: <br>
            ~/child_website/message <br>
            ~/child_website/evalutation_email <br>
            Da questa sezione potrai abilitare la verifica del recaptcha ed inserire la PRIVATE_KEY
        </p>
        <div class="flex mt-4 gap-5">
            <div class="flex flex-col">
                <label for="captcha_key" class="text-sm font-semibold">Private Key <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="captcha_key"
                    id="captcha_key"
                    placeholder="Inserisci la private key del tuo captcha"
                    value="<?= $agency->captcha_key ?>"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
                >
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input
                    type="checkbox"
                    name="enable_captcha"
                    id="enable_captcha"
                    <?= $agency->enable_captcha ? "checked" : "" ?>
                    class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                >
                Abilita la verifica del captcha sulle API
            </label>
        </div>
    </div>

    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
</form>
@endsection