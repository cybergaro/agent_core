@extends('dashboard')

@section('content')

<form method="POST" class="p-10">
    @csrf

    <div class="flex flex-col w-full bg-white rounded-2xl shadow-lg px-7 py-7">
        <h1 class="font-inter font-semibold text-2xl">Impostazioni <?= $agency->name ?></h1>

        <label for="name" class="text-sm font-semibold mt-5">Nome <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="name"
            id="name"
            placeholder="Nome della tua agenzia"
            value="<?= $agency->name ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="email" class="text-sm font-semibold mt-5">Email <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="email"
            id="email"
            placeholder="Es: info@agenzia.com"
            value="<?= $agency->email ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="phone" class="text-sm font-semibold mt-5">Telefono <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="phone"
            id="phone"
            placeholder="Es: 333 333 3333"
            value="<?= $agency->phone ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="website" class="text-sm font-semibold mt-5">Website</label>
        <input
            type="text"
            name="website"
            id="website"
            placeholder="Es: 333 333 3333"
            value="<?= $agency->website ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >
    </div> 

    
    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
    
    <div class="mt-6">
        <p class="text-sm">Id: <span class="font-bold"><?= $agency->id ?></span></p>
        <p class="text-sm">Uuid: <span class="font-bold"><?= $agency->uuid ?></span></p>
        <p class="text-sm">Id owner: <span class="font-bold"><?= $agency->id_user_owner ?></span></p>

    </div>
</form>
@endsection