@extends('dashboard')

@section('content')

<form method="POST" class="p-10 flex flex-col items-center">
    @csrf

    <div class="w-full">
        <a href="/dashboard" class="mb-2 text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna alla Dashboard</a>
    </div>

    <div class="flex flex-col bg-white rounded-2xl shadow-lg px-7 py-7">
        <h1 class="font-inter font-semibold text-2xl">Impostazioni <?= $user->name?></h1>

        <label for="name" class="text-sm font-semibold mt-5">Nome <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="name"
            id="name"
            value="<?= $user->name ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="surname" class="text-sm font-semibold mt-5">Cognome <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="surname"
            id="surname"
            value="<?= $user->surname ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label class="text-sm font-semibold mt-5">Email <span class="text-red-500">*</span></label>
        <input
            disabled
            type="email"
            value="<?= $user->email ?>"
            class="mt-1 border border-gray-300 bg-gray-200 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="phone" class="text-sm font-semibold mt-5">Telefono <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="phone"
            id="phone"
            value="<?= $user->phone ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >
    </div> 

    
    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
    
    <div class="mt-6">
        <p class="text-sm">Id: <span class="font-bold"><?= $user->id ?></span></p>
        <p class="text-sm">Lang: <span class="font-bold"><?= $user->lang ?></span></p>
        <p class="text-sm">Created at: <span class="font-bold"><?= $user->created_at ?></span></p>

    </div>
</form>
@endsection