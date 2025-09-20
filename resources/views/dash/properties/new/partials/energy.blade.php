<?php 
$ape = ["A4", "A3", "A2", "A1", "B", "C", "D", "E", "F", "G"]; 
$heatingSystemManagment = ['autonomous', 'centralized', 'semi-centralized'];
$heatingSystemType = ['radiators', 'underfloor', 'wall', 'ceiling', 'fan_coil', 'stove', 'fireplace', 'heat_pump'];
$heatingSystemPower = ['gas', 'gpl', 'diesel', 'electric', 'pellet', 'wood', 'solar', 'district'];
?>

<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
    <h2 class="font-bold text-xl">Consumi</h2>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="ape" class="mt-6 text-sm font-semibold">APE</label>
            <select 
                name="ape" 
                id="ape"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
                <option value=""></option>
                <?php foreach ($ape as $single) { ?>
                    <option value="<?= $single?>" <?= $single == $property->ape ? "selected" : "" ?>><?= $single?></option>
                <?php } ?>
            </select>
        </div>
        
    </div>
    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="heating_system_management" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-wrench"></i> Gestione sistema di risaldamento</label>
            <select 
                name="heating_system_management" 
                id="heating_system_management"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >   
                <option value=""></option>
                <?php foreach ($heatingSystemManagment as $single) { ?>
                    <option value="<?= $single ?>" <?= $property->heating_system_management == $single ? "selected" : ""?>><?= __("property.".$single) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="flex flex-col w-full">
            <label for="heating_system_type" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-file-contract"></i> Tipologia sistema di risaldamento</label>
            <select 
                name="heating_system_type" 
                id="heating_system_type"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >   
                <option value=""></option>
                <?php foreach ($heatingSystemType as $single) { ?>
                    <option value="<?= $single ?>" <?= $property->heating_system_type == $single ? "selected" : ""?>><?= __("property.".$single) ?></option>
                <?php } ?>
            </select>
        </div>

    </div>
    
    <div class="flex flex-col w-full">
        <label for="heating_system_power" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-file-contract"></i> Alimentazione sistema di risaldamento</label>
        <select 
            name="heating_system_power" 
            id="heating_system_power"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        >   
            <option value=""></option>
            <?php foreach ($heatingSystemPower as $single) { ?>
                <option value="<?= $single ?>" <?= $property->heating_system_power == $single ? "selected" : ""?>><?= __("property.".$single) ?></option>
            <?php } ?>
        </select>
    </div>
</div>