@extends('dashboard')

@section('content')

<h1 class="font-inter font-semibold text-2xl pt-8 pl-10">Seleziona l'agenzia</h1>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 p-10 pt-5">
    <?php foreach ($agencies as $agency) { ?>
    
        <a href="/dashboard/<?= $agency->uuid ?>" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <img src="/img/logoBlu.png" alt="Logo" class="h-14 w-14 object-cover">
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900"><?= $agency->name ?></h3>
                    <p class="mt-1 text-sm text-gray-600">Visualizza i contenuti, modifica le impostazioni e guarda le statistiche di <?= $agency->name ?></p>
                </div>
            </div>
        </a>
    <?php }?>

    <a href="/dashboard/agency/new" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                    <i class="fa-solid fa-plus text-indigo-700"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Crea nuova agenzia</h3>
                <p class="mt-1 text-sm text-gray-600">Usa questo tasto per creare una nuova agenzia all'interno di Agent Core</p>
            </div>
        </div>
    </a>
</div>

@endsection