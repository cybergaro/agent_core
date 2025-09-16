@extends('default')

@section('content')
<div class="p-10">
    <div class="mb-2 w-full max-w-4xl">
        <a href="" class="text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna agli immobili</a>
    </div>
    
    <h1 class="font-bold text-2xl mb-4 mt-3">Nuovo immobile</h1>
    
    <form>

        <!---------------------- Generali ---------------------->

        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5">

            <h2 class="font-bold text-xl">Generali</h2>

            <label for="name" class="mt-6 text-sm font-semibold">Titolo <span class="text-red-500">*</span></label>
            <input
                type="text"
                name="name"
                id="name"
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
            ></textarea>

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="contract" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-file-contract"></i> Tipo contratto <span class="text-red-500">*</span></label>
                    <select 
                        name="contract" 
                        id="contract"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                        <option value="sale">Vendita</option>
                        <option value="rent">Affitto</option>
                    </select>
                </div>
                <div class="flex flex-col w-full">
                    <label for="type" class="mt-6 text-sm font-semibold">Tipologia immobile <span class="text-red-500">*</span></label>
                    <select 
                        name="type" 
                        id="type"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                        <option value="commercial">Commerciale</option>
                        <option value="industrial">Industriale</option>
                        <option value="redisential" selected>Residenziale</option>
                    </select>
                </div>

                <div class="flex flex-col w-full">
                    <label for="category" class="mt-6 text-sm font-semibold">Categoria <span class="text-red-500">*</span></label>
                    <select 
                        name="category" 
                        id="category"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                        <?php foreach ($propertyTypes as $type) { ?>
                            <option value="<?= $type ?>"><?= __("property.".$type) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <!-------------------- prezzo -------------------->

        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Prezzo</h2>

            <div class="flex flex-col w-full">
                <label for="price" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-money-bill-1-wave"></i> Prezzo <span class="text-red-500">*</span></label>
                <input
                    type="number"
                    name="price"
                    id="price"
                    placeholder="Prezzo dell'immobile"
                    min="0"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                >
            </div>

        </div>


        <!-------------------- costi -------------------->
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Costi</h2>

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="condominium_fees" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-hand-holding-dollar"></i> Spese condominiali</label>
                    <input
                        type="number"
                        name="condominium_fees"
                        id="condominium_fees"
                        min="0"
                        placeholder="Spese condominiali"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>
            </div>
        </div>

        <!-------------------- struttura -------------------->

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
                        min="0"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>

                <div class="flex flex-col w-full">
                    <label for="condominium_fees" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-stairs"></i> Piani dell'immobile</label>
                    <input
                        type="number"
                        name="condominium_fees"
                        id="condominium_fees"
                        min="1"
                        value="1"
                        placeholder="Spese condominiali"
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
                        min="0"
                        placeholder="Es: 3"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>
            </div>
        </div>

        <!-------------------- dettagli -------------------->
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Dettagli</h2>

            <div class="gap-6 grid grid-cols-3 mt-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input
                        type="checkbox"
                        name="parking"
                        id="parking"
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
                        class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    >
                    Giardino
                    <i class="fa-solid fa-tree"></i>
                </label>

                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input
                        type="checkbox"
                        name="independent"
                        id="independent"
                        class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                    >
                    L'immobile è indipendente
                </label>
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer mt-5">
            <input
                type="checkbox"
                name="independent"
                id="independent"
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
                Immobile contrassegnato come ECO sostenibile
                <i class="fa-solid fa-leaf text-green-600"></i>
            </label>
        </div>

        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Consumi</h2>

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="contract" class="mt-6 text-sm font-semibold">APE</label>
                    <select 
                        name="contract" 
                        id="contract"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                        <option value=""></option>
                        <option value="A4">A4</option>
                        <option value="A3">A3</option>
                        <option value="A2">A2</option>
                        <option value="A1">A1</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                    </select>
                </div>
                
            </div>
        </div>
    

    </form>
</div>  
@endsection