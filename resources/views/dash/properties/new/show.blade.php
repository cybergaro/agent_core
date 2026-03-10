@extends('dashboard')

@section('content')

<?php 
$propertyTypes = [
    'apartment',
    'single-family-house',
    'multi-family-house',
    'townhouse',
    'villa',
    'loft',
    'studio-apartment',
    'penthouse',
    'farmhouse',
    'cottage',
    'office',
    'shop',
    'commercial-space',
    'hotel',
    'restaurant',
    'showroom',
    'retail',
    'bar',
    'theater',
    'industrial-warehouse',
    'logistics-hub',
    'workshop',
    'agricultural-land',
    'building-land',
    'garage',
    'parking-lot',
    'storage-unit'
];
?>

<div class="p-10">
    <div class="mb-2 w-full max-w-4xl">
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/properties" class="text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna agli immobili</a>
    </div>
    
    <h1 class="font-bold text-2xl mb-4 mt-3">
        <?= $property->name ? 'Modifica "'.$property->name.'"' : "Nuovo immobile" ?>
    </h1>

    <?php if($property->imported_from) {?>
        <div class="items-center gap-2 text-yellow-600 bg-yellow-50 border border-yellow-300 rounded-2xl p-4 px-6 text-sm mt-4 max-w-4xl mb-6 flex gap-3">
            <i class="fa-solid fa-triangle-exclamation text-xl"></i>    
            <p>Questo immobile è stato importato da un servizio esterno (<?= $property->imported_from ?>). É probabile che le modifiche che farai verranno sovrascritte nel momento di una nuova sincronizzazione</p>
        </div>
    <?php } ?>
    
    <form method="POST">
        @csrf

        <input type="hidden" name="uuid" value="<?= $property->uuid ?>">

        @include('dash.properties.new.partials.general')

        <!-------------------- prezzo -------------------->
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Prezzo</h2>

            <div class="flex flex-col w-full">
                <label for="price" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-money-bill-1-wave"></i> Prezzo <span class="text-red-500">*</span></label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    placeholder="Prezzo dell'immobile"
                    value="<?= $property->price ?>"
                    min="0"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
            </div>

        </div>


        <!-------------------- costi -------------------->
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Costi</h2>

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="condominium_fees" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-hand-holding-dollar"></i> Spese condominiali</label>
                    <input
                        type="number"
                        name="condominium_fees"
                        id="condominium_fees"
                        value="<?= $property->condominium_fees ?>"

                        min="0"
                        placeholder="Spese condominiali"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>
            </div>
        </div>

        @include('dash.properties.new.partials.structure')
        @include('dash.properties.new.partials.details')
        @include('dash.properties.new.partials.energy')
        @include('dash.properties.new.partials.actualCondition')
        @include('dash.properties.new.partials.location')
        
        <button
            class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
        >
            <i class="fa-solid fa-upload"></i>
            Inserisci immobile
        </button>
    </form>
</div>  

@endsection