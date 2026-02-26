<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
    <h2 class="font-bold text-xl">Struttura</h2>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="size" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-up-right-and-down-left-from-center"></i> Dimensione (mq.) <span class="text-red-500">*</span></label>
            <input
                type="number"
                name="size"
                id="size"
                placeholder="Es: 135"
                value="<?= $unit->size?>"
                min="0"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>

        <div class="flex flex-col w-full">
            <label for="n_floors" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-stairs"></i> Piani dell'immobile</label>
            <input
                type="number"
                name="n_floors"
                id="n_floors"
                value="<?= $unit->n_floors?>"
                min="1"
                placeholder="Il numero di piani dell'immobile"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>
    </div>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="n_room" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-bed"></i> Numbero camere</label>
            <input
                type="number"
                name="n_room"
                id="n_room"
                value="<?= $unit->n_room?>"
                placeholder="Es: 2"
                min="0"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>

        <div class="flex flex-col w-full">
            <label for="n_bathroom" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-bath"></i> Numbero bagni</label>
            <input
                type="number"
                name="n_bathroom"
                id="n_bathroom"
                value="<?= $unit->n_bathroom?>"
                min="0"
                placeholder="Es: 3"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>
    </div>
</div>
