<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5">
    <h2 class="font-bold text-xl">Generali</h2>

    <label for="name" class="mt-6 text-sm font-semibold">Titolo <span class="text-red-500">*</span></label>
    <input
        type="text"
        name="name"
        id="name"
        value="<?= $construction->name ?>"
        placeholder="Titolo per l'annuncio del cantiere"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    >

    <label for="description" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-bars"></i> Descrizione <span class="text-red-500">*</span></label>
    <textarea
        type="text"
        name="description"
        id="description"
        rows="5"
        placeholder="Descrizione per l'annuncio dell cantiere"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    ><?= $construction->description ?></textarea>
</div>