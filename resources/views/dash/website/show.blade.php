@extends('dashboard')

@section('content')

<?php if(!$agency->website_connection){?>

<div class="flex flex-col items-center justify-center h-screen w-full">
    <i class="fa-solid fa-globe text-5xl mb-2"></i>
    <h1 class="text-3xl font-semibold mb-3">Sito web non attivo</h1>
    <p>Momentaneamente non puoi vedere statistiche e informazioni relative al tuo sito web, se si tratta di un errore contattaci</p>
</div>

<?php }else{ ?>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 p-10">
    <a href="/dashboard/<?= $agency->uuid ?>/website/emails" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                    <i class="fa-solid fa-comment-dots text-indigo-700"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Richieste di valutazione</h3>
                <p class="mt-1 text-sm text-gray-600">Visualizza le richieste di valutazione che sono state inoltrate alla tua email dal sito</p>
            </div>
        </div>
    </a>

</div>

<?php }?>

@endsection