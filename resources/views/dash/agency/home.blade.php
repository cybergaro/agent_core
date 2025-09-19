@extends('dashboard')

@section('content')
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 py-5">
    <div class="bg-white rounded-3xl flex flex-col items-center p-5">
        <div class="relative w-[200px] h-[200px] flex items-center justify-center">
            <svg
                width="200"
                height="200"
                viewBox="0 0 200 200"
                class="-rotate-90"
            >
                <!-- Cerchio di sfondo -->
                <circle
                    cx="100"
                    cy="100"
                    r="80"
                    class="fill-none stroke-gray-200"
                    stroke-width="20"
                />
            
                <?php
                    $radius = 80;
                    $circumference = 2 * M_PI * $radius;
                    $total = $propertyType->sum('total');
                    $offset = 0;
            
                    foreach ($propertyType as $item){ 
                        $segment = $circumference * ($item->total/$total);
                ?>
                    <circle
                        cx="100"
                        cy="100"
                        r="<?= $radius ?>"
                        class="fill-none <?= $item->type == "residential" ? "stroke-blue-600" : ($item->type == "commercial" ? "stroke-yellow-400" : ($item->type == "industrial" ? "stroke-red-500" :""))?>"
                        stroke-width="20"
                        stroke-dasharray="<?= $segment ?> <?= $circumference - $segment ?>"
                        stroke-dashoffset="<?= -$offset ?>"
                    />
            
                <?php 
                        $offset += $segment; 
                    } 
                ?>
            </svg>

            <div class="absolute text-gray-700 text-center">
                <i class="fas fa-home text-3xl"></i>
                <p class="font-semibold">Immobili</p>
            </div>
        </div>

        <div class="flex gap-3 mt-3">
            <div class="flex items-center gap-1">
                <div class="h-3 w-3 bg-blue-600 rounded-xl"></div>
                <p>Residenziali (<?= $propertyType->where('type', 'residential')->first()?->total ?? 0?>)</p>
            </div>
            <div class="flex items-center gap-1">
                <div class="h-3 w-3 bg-yellow-400 rounded-xl"></div>
                <p>Commerciali (<?= $propertyType->where('type', 'commercial')->first()?->total ?? 0?>)</p>
            </div>
            <div class="flex items-center gap-1">
                <div class="h-3 w-3 bg-red-500 rounded-xl"></div>
                <p>Industriali (<?= $propertyType->where('type', 'industrial')->first()?->total ?? 0 ?>)</p>
            </div>
        </div>
    </div>
</div>


@endsection
