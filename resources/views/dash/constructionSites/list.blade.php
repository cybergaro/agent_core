@extends('dashboard')

@section('content')
<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Cantieri</h1>
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/new" class="bg-blue-600 text-white text-md font-medium rounded-xl px-3 py-2 ml-5">
            <i class="fa-solid fa-plus"></i> 
            Aggiungi nuovo
        </a>
    </div>

    <table class="mt-4 border-collapse rounded-3xl overflow-hidden">
        <tbody class="w-full bg-white">
            <?php foreach ($constructionSites as $construction) { ?>
                
            <?php } ?>
        </tbody>
    </table>
</div>  
@endsection