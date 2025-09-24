@extends('dashboard')

@section('content')

<div class="p-10">
    <div class="mb-2 w-full max-w-4xl">
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/construction_sites" class="text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna ai cantieri</a>
    </div>
    
    <h1 class="font-bold text-2xl mb-4 mt-3">
        <?= $construction->name ? 'Modifica "'.$construction->name.'"' : "Nuovo cantiere" ?>
    </h1>
    
    <form method="POST">
        @csrf

        <input type="hidden" name="uuid" value="<?= $construction->uuid ?>">
        
        <button
            class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
        >
            <i class="fa-solid fa-upload"></i>
            Inserisci Cantiere
        </button>
    </form>
</div>  

@endsection