@extends('dashboard')

@section('content')
<div class="p-10">
    <div class="mb-2 w-full max-w-4xl">
        <a href="/dashboard/<?=request()->route('agencyUuid')?>/properties" class="text-blue-600"><i class="fa-solid fa-arrow-left"></i> Torna agli immobili</a>
    </div>
    
    <h1 class="font-bold text-2xl mb-4 mt-3">Nuovo immobile</h1>
    
    <form method="POST">
        @csrf

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
                    <label for="n_floors" class="mt-6 text-sm font-semibold"><i class="fa-solid fa-stairs"></i> Piani dell'immobile</label>
                    <input
                        type="number"
                        name="n_floors"
                        id="n_floors"
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

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="year_production" class="mt-6 text-sm font-semibold">Anno di costruzione</label>
                    <input
                        type="number"
                        name="year_production"
                        id="year_production"
                        placeholder="Es: 2025"
                        min="0"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    >
                </div>

                <div class="flex flex-col w-full">
                    <label for="" class="mt-6 text-sm font-semibold">Piano di ubicazione</label>
                    <input
                        type="number"
                        name="floor"
                        id="floor"
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
                name="green"
                id="green"
                class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
            >
                Immobile contrassegnato come ECO sostenibile
                <i class="fa-solid fa-leaf text-green-600"></i>
            </label>
        </div>

        <!-------------------- consumi -------------------->
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
                            <option value="<?= $single ?>"><?= __("property.".$single) ?></option>
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
                            <option value="<?= $single ?>"><?= __("property.".$single) ?></option>
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
                        <option value="<?= $single ?>"><?= __("property.".$single) ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

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
                        <option value="vacant">Libero</option>
                        <option value="occupied">Abitato</option>
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
                        <option value="new">Nuovo</option>
                        <option value="renovated">Ristrutturato</option>
                        <option value="good">Buono</option>
                        <option value="excellent">Eccellente</option>
                        <option value="original">Originale</option>
                        <option value="fair">Discreto</option>
                        <option value="to_be_renovated">Da ristrutturare</option>                    
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
                        <option value="furnished">Arredato</option>
                        <option value="partially-furnished">Parzialmente arredato</option>
                        <option value="unfurnished">Non arredato</option>
                    </select>
                </div>

            </div>
            
        </div>
        
        <div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
            <h2 class="font-bold text-xl">Posizione</h2>
            
            <label for="address" class="mt-6 text-sm font-semibold">Indirizzo <span class="text-red-500">*</span></label>
            <div class="flex w-full gap-3 items-center">
                <input
                    type="text"
                    name="address"
                    id="address"
                    placeholder="Es: Via Roma 33"
                    min="0"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-full"
                >
                <button id="search-button" 
                    class="cursor-pointer h-8 w-8" 
                    type="button"
                >
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <div class="flex gap-6">
                <div class="flex flex-col w-full">
                    <label for="zip_code" class="mt-6 text-sm font-semibold">CAP</label>
                    <input 
                        name="zip_code" 
                        id="zip_code"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    />
                </div>
            </div>

            <div class="flex gap-6">
                <div class="flex flex-col w-40">
                    <label for="lat" class="mt-6 text-sm font-semibold">Latitudine</label>
                    <input 
                        disabled
                        name="lat" 
                        id="lat"
                        class="mt-1 border border-gray-300 bg-gray-100 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    />
                </div>
                <div class="flex flex-col w-40">
                    <label for="lng" class="mt-6 text-sm font-semibold">Longitudine</label>
                    <input 
                        disabled
                        name="lng" 
                        id="lng"
                        class="mt-1 border border-gray-300 bg-gray-100 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    />
                </div>
            </div>

            <div id="map" class="h-100 w-full rounded-xl mt-6"></div>
        </div>
        
        <button
            class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
        >
            <i class="fa-solid fa-upload"></i>
            Inserisci immobile
        </button>
    </form>
</div>  

<script>

    let map;
    let geocoder;
    let marker;

    function initMap() {
        // Inizializza la mappa centrata sull'Italia
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 6,
            center: { lat: 41.9028, lng: 12.4964 },
        });
        
        geocoder = new google.maps.Geocoder();

        const searchButton = document.getElementById("search-button");
        searchButton.addEventListener("click", () => {
            geocodeAddress();
        });
    }

    function geocodeAddress() {
        const address = document.getElementById("address").value;

        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
                const location = results[0].geometry.location;
                const lat = location.lat();
                const lng = location.lng();
                const formattedAddress = results[0].formatted_address;

                let postalCode = '';
                let province = '';
                let region = '';
                
                result.address_components.forEach(component => {
                    if (component.types.includes('postal_code')) {
                        postalCode = component.long_name;
                    }
                    if (component.types.includes('administrative_area_level_2')) {
                        province = component.long_name;
                    }
                    if (component.types.includes('administrative_area_level_1')) {
                        region = component.long_name;
                    }
                });
                
                document.getElementById("lat").value = lat;
                document.getElementById("lng").value = lng;
                console.log(results[0])

                map.setCenter(location);
                map.setZoom(15);
                
                // Rimuovi il marker precedente se esiste e crea quello nuovo
                if (marker) {
                    marker.setMap(null);
                }
                marker = new google.maps.Marker({
                    map: map,
                    position: location
                });

            } else {
                // Gestisce gli errori
                alert("Geocode non riuscito per il seguente motivo: " + status);
            }
        });
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= env("GOOGLE_MAPS_API_KEY") ?>&libraries=geocoding&callback=initMap"></script>

@endsection