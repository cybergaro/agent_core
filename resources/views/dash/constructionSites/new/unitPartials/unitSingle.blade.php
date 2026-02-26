<div
    class="flex px-8 py-4 overflow-hidden hover:bg-gray-100 transition rounded-2xl cursor-pointer gap-4 items-center"
>
    <a href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>/unit/<?= $unit->uuid ?>" >
        <img src="/img/image_not_found.webp" alt="Immagine" srcset="" class="h-20 w-35 object-cover rounded-lg">
    </a>
        
    <a 
        class="w-full"
        href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>/unit/<?= $unit->uuid ?>"
    >
        <h2 class="font-semibold"><?= $unit->name ?></h2>
        <p class="text-sm"><?= $unit->description ?></p>
        <div class="flex mt-1 text-gray-500 text-sm">
            <i class="fa-solid fa-maximize mt-1 mr-1"></i> <span class="mr-3"><?= $unit->size ?> m²</span>
            <i class="fa-solid fa-bed mt-1 mr-1"></i> <span class="mr-3"><?= $unit->n_room ?> Stanze</span>
            <i class="fa-solid fa-bath mt-1 mr-1"></i> <span class="mr-3"><?= $unit->n_bathroom?> Bagni</span>
            <i class="fa-solid fa-money-bill-wave mt-1 mr-1"></i> <span class="mr-3"><?= number_format($unit->price, 0, ',', '.') ?>€</span>
        </div>
    </a>
    <div>
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?=request()->route('siteUuid')?>/unit/<?= $unit->uuid ?>/delete">
            <i class="fa-solid fa-trash text-red-600"></i>
        </a>
    </div>
</div>