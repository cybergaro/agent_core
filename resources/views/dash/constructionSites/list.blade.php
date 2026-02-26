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
            <?php foreach ($sites as $site) { ?>
                <tr class="flex items-center px-5 py-5 hover:bg-gray-200 rounded-2xl cursor-pointer" onclick="window.location='/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?= $site->uuid?>'">
                    <td>
                        <?php if($site->image_path){ ?>
                            <img src="/storage/properties_images/<?= $property->image_path?>" class="h-25 w-40 object-cover rounded-xl">
                        <?php }else{ ?>
                            <img src="/img/image_not_found.webp" class="h-25 w-40 object-cover rounded-xl">
                        <?php } ?>
                    </td>
                    <td class="ml-4 w-130">
                        <h2 class="font-semibold text-md"><?= $site->name ?></h2>
                        <p class="text-sm"><?= $site->description ?></p>
                        <p class="text-sm">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= $site->address ?>
                        </p>
                    </td>
                    <td class="flex gap-3 items-center">
                        <a href="/dashboard/<?=request()->route('agencyUuid')?>/construction_site/<?= $site->uuid?>/delete">
                            <i class="fa-solid fa-trash text-red-600"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>  
@endsection