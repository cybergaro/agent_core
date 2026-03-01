<div
    class="flex px-8 py-4 overflow-hidden hover:bg-gray-100 transition rounded-2xl cursor-pointer gap-4 items-center"
    onclick="window.location='/dashboard/{{ request()->route('agencyUuid') }}/construction_site/{{ request()->route('siteUuid') }}/unit/{{ $unit->uuid }}'"
>
    {{-- Immagine --}}
    <div>
        <img 
            src="{{ $unit->getFirstImagePath() ? '/storage/' . $unit->getFirstImagePath() : '/img/image_not_found.webp' }}" 
            alt="Immagine" 
            class="h-20 w-35 object-cover rounded-lg"
        >
    </div>
        
    {{-- Info (flex-grow per occupare lo spazio centrale) --}}
    <div class="w-full flex-grow">
        <h2 class="font-semibold">{{ $unit->name }}</h2>
        
        {{-- Descrizione limitata per coerenza con il resto della UI --}}
        <p class="text-sm text-gray-600 mb-1">
            {{ \Illuminate\Support\Str::limit($unit->description, 200) }}
        </p>
        
        <div class="flex mt-1 text-gray-500 text-sm">
            <i class="fa-solid fa-maximize mt-1 mr-1"></i> <span class="mr-3">{{ $unit->size }} m²</span>
            <i class="fa-solid fa-bed mt-1 mr-1"></i> <span class="mr-3">{{ $unit->n_room }} Stanze</span>
            <i class="fa-solid fa-bath mt-1 mr-1"></i> <span class="mr-3">{{ $unit->n_bathroom }} Bagni</span>
            <i class="fa-solid fa-money-bill-wave mt-1 mr-1"></i> <span class="mr-3">{{ number_format($unit->price, 0, ',', '.') }}€</span>
        </div>
    </div>
    
    {{-- Tasto Elimina (Blocca il click principale con stopPropagation) --}}
    <div class="ml-auto" onclick="event.stopPropagation()">
        <a href="/dashboard/{{ request()->route('agencyUuid') }}/construction_site/{{ request()->route('siteUuid') }}/unit/{{ $unit->uuid }}/delete" title="Elimina unità" class="cursor-pointer block p-2">
            <i class="fa-solid fa-trash text-red-500 hover:text-red-700 transition-colors"></i>
        </a>
    </div>
</div>