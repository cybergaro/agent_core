<?php 
$internalCondition = ["new","renovated", "good", "excellent", "original", "fair", "to_be_renovated"];
$furniture = ["furnished", "partially-furnished", "unfurnished"];
?>
<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
    <h2 class="font-bold text-xl">Condizione attuale</h2>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="occupancy_status" class="mt-6 text-sm font-semibold">Stato occupazione</label>
            <select 
                name="occupancy_status" 
                id="occupancy_status"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
                <option value="vacant" <?= $property->occupancy_status == "vacant" ? "selected" : "" ?>>Libero</option>
                <option value="occupied" <?= $property->occupancy_status == "occupied" ? "selected" : "" ?>>Abitato</option>
            </select>
        </div>
        
    </div>
    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="internal_condition" class="mt-6 text-sm font-semibold">Condizione interna</label>
            <select 
                name="internal_condition" 
                id="internal_condition"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >   
                <option value=""></option>
                <?php foreach ($internalCondition as $single) { ?>
                    <option value="<?= $single ?>" <?= $property->internal_condition == $single ? "selected" : "" ?>><?= __("property.".$single) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="flex flex-col w-full">
            <label for="furniture" class="mt-6 text-sm font-semibold">Arredamento</label>
            <select 
                name="furniture" 
                id="furniture"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >   
                <option value=""></option>
                <?php foreach ($furniture as $single) { ?>
                    <option value="<?= $single ?>" <?= $property->furniture == $single ? "selected" : "" ?>><?= __("property.".$single) ?></option>
                <?php } ?>
            </select>
        </div>

    </div>
    
</div>