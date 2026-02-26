<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5">
    <h2 class="font-bold text-xl">Generali</h2>

    <label for="name" class="mt-6 text-sm font-semibold">Titolo <span class="text-red-500">*</span></label>
    <input
        type="text"
        name="name"
        id="name"
        value="<?= $unit->name ?>"
        placeholder="Titolo dell'unità"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    >

    <label for="description" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-bars"></i> Descrizione <span class="text-red-500">*</span></label>
    <textarea
        type="text"
        name="description"
        id="description"
        rows="5"
        placeholder="Descrizione dell'unità"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
    ><?= $unit->description ?></textarea>

    <label for="price" class="mt-6 text-sm font-semibold">Prezzo <span class="text-red-500">*</span></label>
    <input
        type="text"
        name="price"
        id="price"
        placeholder="Prezzo dell'unità"
        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        value="<?= $unit->price ?>"
    >

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="start_date" class="mt-6 text-sm font-semibold">Data inizio <span class="text-red-500">*</span></label>
            <input
                type="date"
                name="start_date"
                id="start_date"
                value="<?= $unit->start_date ?>"
                placeholder="Data di inizio di costruzione"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>
        <div class="flex flex-col w-full">
            <label for="completion_date" class="mt-6 text-sm font-semibold">Data fine (prevista) <span class="text-red-500">*</span></label>
            <input
                type="date"
                name="completion_date"
                id="completion_date"
                value="<?= $unit->completion_date ?>"
                placeholder="Data di finie prevista dell'unità"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            >
        </div>
    </div>
</div>