<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
    <h2 class="font-bold text-xl">Dettagli</h2>

    <div class="gap-6 grid grid-cols-3 mt-6">
        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="parking"
                id="parking"
                <?= $property->parking ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Parcheggio
            <i class="fa-solid fa-car-side"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="box"
                id="box"
                <?= $property->box ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Box auto
            <i class="fa-solid fa-car-side"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="elevator"
                id="elevator"
                <?= $property->elevator ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Ascensore
            <i class="fa-solid fa-elevator"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="air_conditioning"
                id="air_conditioning"
                <?= $property->air_conditioning ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Aria condizionata
            <i class="fa-solid fa-wind"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="garden"
                id="garden"
                <?= $property->garden ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Giardino
            <i class="fa-solid fa-tree"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="terrace"
                id="terrace"
                <?= $property->terrace ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Terrazzo
            <i class="fa-solid fa-sun text-yellow-400"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="independent"
                id="independent"
                <?= $property->independent ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Indipendente
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="green"
                id="green"
                <?= $property->eco ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            ECO sostenibile
            <i class="fa-solid fa-leaf text-green-600"></i>
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
            <input
                type="checkbox"
                name="luxury"
                id="luxury"
                <?= $property->luxury ? "checked" : "" ?>
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
            Lusso
            <i class="fa-regular fa-gem text-blue-700"></i>
        </label>
    </div>

</div>