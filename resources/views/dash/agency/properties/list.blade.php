@extends('default')

@section('content')
<div class="p-8">
    <h1 class="font-semibold text-2xl">Immobili</h1>
    
    <div class="bg-white py-2 rounded-2xl mt-2">
        <?php foreach ($properties as $property) { ?>
            <a class="flex items-center px-5 py-3" href="/dashboard/property/<?= $property->uuid?>">
                <div>
                    <img src="/storage/properties_images/<?= $property->image_path?>" class="h-25 w-40 object-cover rounded-xl">
                </div>
                <div class="ml-4 w-130">
                    <h2 class="font-semibold text-md"><?= $property->name ?></h2>
                    <p class="text-sm mt-1"><?= __("property.".$property->contract) ?> | <?= __("property.".$property->type) ?> | <?= $property->category ?></p>
                </div>
                <div class="w-30">
                    <p class="font-semibold">€ <?= number_format($property->price, 0, '', '.') ?></p>
                </div>
                <div class="flex gap-3 items-center">
                    <?php if($property->imported_from){ ?>
                        <i class="fa-solid fa-cloud-arrow-down text-sm" title="Importato da <?= $property->imported_from?>"></i>
                    <?php } ?>

                    <?php if($property->green){ ?>
                        <i class="fa-solid fa-leaf text-green-700" title="Contrassegnato come ecosostenibile"></i>
                    <?php } ?>
                </div>
            </a>
        <?php } ?>
    </div>
</div>  
@endsection