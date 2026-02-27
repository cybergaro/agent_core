@extends('dashboard')

@section('content')
<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Immobili</h1>
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/property/new" class="bg-blue-600 text-white text-md font-medium rounded-xl px-3 py-2 ml-5">
            <i class="fa-solid fa-plus"></i> 
            Aggiungi nuovo
        </a>
    </div>

    <table class="mt-4 border-collapse rounded-3xl overflow-hidden">
        <tbody class="w-full bg-white">
            <?php foreach ($properties as $property) { ?>
                <tr class="flex items-center px-5 py-5 hover:bg-gray-200 rounded-2xl cursor-pointer" onclick="window.location='/dashboard/<?=request()->route('agencyUuid')?>/property/<?= $property->uuid?>'">
                    <td>
                        <?php if($property->image_path){ ?>
                            <img src="/storage/properties_images/<?= $property->image_path?>" class="h-25 w-40 object-cover rounded-xl">
                        <?php }else{ ?>
                            <img src="/img/image_not_found.webp" class="h-25 w-40 object-cover rounded-xl">
                        <?php } ?>
                    </td>
                    <td class="ml-4 w-130">
                        <h2 class="font-semibold text-md"><?= $property->name ?></h2>
                        <p class="text-sm mt-1"><?= __("property.".$property->contract) ?> | <?= __("property.".$property->type) ?> | <?= __("property.".$property->category) ?></p>
                    </td>
                    <td class="w-30">
                        <p class="font-semibold">€ <?= number_format($property->price, 0, '', '.') ?></p>
                    </td>
                    <td class="flex gap-3 items-center">
                        <?php if($property->imported_from){ ?>
                            <i class="fa-solid fa-cloud-arrow-down text-sm" title="Importato da <?= $property->imported_from?>"></i>
                        <?php } ?>

                        <?php if($property->green){ ?>
                            <i class="fa-solid fa-leaf text-green-700" title="Contrassegnato come ecosostenibile"></i>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php if(count($properties)) { ?>
        <div class="rounded-xl h-10 flex items-center overflow-x-auto bg-white w-fit mt-5">
            <?php 
                $current = $properties->currentPage();
            ?>
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page=<?= $current > 1 ? $current-1 : "" ?>'">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            
            <?php for ($i=1; $i < $properties->lastPage()+1; $i++) {  ?>
                <button 
                    class="px-2 h-full w-10 cursor-pointer rounded-xl <?= $current == $i ? "bg-blue-600 text-white" : "hover:bg-gray-200 text-gray-600" ?> font-semibold" 
                    onclick="location.href='?page=<?=$i?>'"
                >
                    <?= $i ?>
                </button>
            <?php } ?>
            
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page=<?= $properties->lastPage() != $current ? $current+1 : $current ?>'">
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
    <?php } ?>
</div>  
@endsection