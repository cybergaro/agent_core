<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5">
    <h2 class="font-bold text-xl">Generali</h2>

    <label for="name" class="mt-6 text-sm font-semibold">Titolo <span class="text-red-500">*</span></label>
    <input
        type="text"
        name="name"
        id="name"
        value="<?= $property->name ?>"
        placeholder="Titolo per l'annuncio dell'immobile"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    >

    <label for="description" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-bars"></i> Descrizione <span class="text-red-500">*</span></label>
    <textarea
        type="text"
        name="description"
        id="description"
        rows="5"
        placeholder="Descrizione per l'annuncio dell'immobile"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    ><?= $property->description ?></textarea>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="contract" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-file-contract"></i> Tipo contratto <span class="text-red-500">*</span></label>
            <select 
                name="contract" 
                id="contract"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
                <option value="sale" <?= $property->contract == "sale" ? "selected" : ""?>>Vendita</option>
                <option value="rent" <?= $property->contract == "rent" ? "selected" : ""?>>Affitto</option>
            </select>
        </div>
        <div class="flex flex-col w-full">
            <label for="type" class="mt-6 text-sm font-semibold">Tipologia immobile <span class="text-red-500">*</span></label>
            <select 
                name="type" 
                id="type"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
                <option value="residential" <?= $property->type == "residential" ? "selected" : ""?>>Residenziale</option>
                <option value="commercial" <?=  $property->type == "commercial" ? "selected" : ""?>>Commerciale</option>
                <option value="industrial" <?=  $property->type == "industrial" ? "selected" : ""?>>Industriale</option>
            </select>
        </div>

        <div class="flex flex-col w-full">
            <label for="category" class="mt-6 text-sm font-semibold">Categoria <span class="text-red-500">*</span></label>
            <select 
                name="category" 
                id="category"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
                <?php foreach ($propertyTypes as $category) { ?>
                    <option 
                        value="<?= $category ?>" 
                        <?= $property->category == $category ? "selected" : ""?>
                    ><?= __("property.".$category) ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>