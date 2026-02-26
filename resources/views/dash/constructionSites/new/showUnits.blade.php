@extends('dashboard')

@section('content')

<div class="p-10">    
    <div class="flex items-center">
        <h1 class="font-bold text-2xl mb-4 mt-3">
            <?= 'Modifica le unità di "'.$construction->name ?>
        </h1>
        <a 
            href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>/unit/new" 
            class="bg-blue-600 text-white text-md font-medium rounded-xl px-3 py-2 ml-5 h-fit"
        >
            <i class="fa-solid fa-plus"></i> 
            Aggiungi nuova unità
        </a>
    </div>
    
    <form method="POST">
        @csrf

        <input type="hidden" name="uuid" value="<?= $construction->uuid ?>">
        
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl pt-5 mt-6">
            <h2 class="font-bold text-xl ml-8">Unità</h2>
            <!-- lista -->
            <?php foreach ($units as $unit) { ?>
                @include('dash.constructionSites.new.unitPartials.unitSingle')
            <?php } ?>

            <?php if(!count($units)){?>
                <p class="p-8">Attualmente non ci sono unità presenti</p>
            <?php } ?>
        </div>
        
        <div class="flex gap-3">

            <a
                class="cursor-pointer border border-width-3 hover:bg-blue-600 hover:text-white text-blue-600 rounded-lg px-4 py-2 mt-6 font-medium transition"
                href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>"    
            >
                <i class="fa-solid fa-arrow-left"></i>
                Indietro
            </a>
            <button
                class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
            >
                Fine
                <i class="fa-solid fa-upload"></i>
            </button>
        </div>
    </form>
</div>  

@endsection