@extends('dashboard')

@section('content')

<div class="p-10">    
    <h1 class="font-bold text-2xl mb-4 mt-3">
        Aggiungi o modifica un unità
    </h1>
    
    <form method="POST">
        @csrf

        <input type="hidden" name="uuid" value="<?= $construction->uuid ?>">
        
        @include('dash.constructionSites.new.unitPartials.general')
        @include('dash.constructionSites.new.unitPartials.structure')
        @include('dash.constructionSites.new.unitPartials.energy')
        @include('dash.constructionSites.new.unitPartials.details')
        
        <div class="flex gap-3">

            <a
                class="cursor-pointer border border-width-3 hover:bg-blue-600 hover:text-white text-blue-600 rounded-lg px-4 py-2 mt-6 font-medium transition"
                href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>/units"    
            >
                <i class="fa-solid fa-arrow-left"></i>
                Indietro
            </a>
            <button
                class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
            >
                Aggiungi unità
                <i class="fa-solid fa-upload"></i>
            </button>
        </div>
    </form>
</div>  

@endsection