@extends('dashboard')

@section('content')

<?php if(!$agency->website_connection){?>

<div class="flex flex-col items-center justify-center h-screen w-full">
    <i class="fa-solid fa-globe text-5xl mb-2"></i>
    <h1 class="text-3xl font-semibold mb-3">Sito web non attivo</h1>
    <p>Il tuo sito web non è stato attivato. L'amministratore potrà farlo attivando i servizi API situati all'interno della sezione impostazioni</p>
</div>

<?php }else{ ?>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 p-10">
    <a href="/dashboard/<?= $agency->uuid ?>/website/messages" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                    <i class="fa-solid fa-comment-dots text-indigo-700"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Messaggi</h3>
                <p class="mt-1 text-sm text-gray-600">Visualizza i messaggi che sono stati inviati dagli utenti attraverso il sito web</p>
            </div>
        </div>
    </a>

</div>

<?php }?>

@endsection