<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 mt-6">
    <h2 class="font-bold text-xl">Posizione</h2>
    
    <label for="address_search" class="mt-6 text-sm font-semibold">Cerca Indirizzo</label>
    <div class="flex w-full gap-3 items-center">
        <input
            type="text"
            name="address_search"
            id="address_search"
            placeholder="Es: Via Roma 33"
            min="0"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-full"
            onkeydown="if(event.key === 'Enter') { event.preventDefault(); geocodeAddress(); }"
        >
        <button id="search-button" 
            class="cursor-pointer h-8 w-8" 
            type="button"
        >
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>

    <div class="flex flex-col w-full">
        <label for="address" class="mt-6 text-sm font-semibold">Indirizzo <span class="text-red-500">*</span></label>
        <input 
            name="address" 
            id="address"
            value="<?= $construction->address ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
        />
    </div>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="city" class="mt-6 text-sm font-semibold">Città <span class="text-red-500">*</span></label>
            <input 
                name="city" 
                id="city"
                value="<?= $construction->city ?>"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>

        <div class="flex flex-col w-full">
            <label for="province" class="mt-6 text-sm font-semibold">Provincia <span class="text-red-500">*</span></label>
            <input 
                name="province" 
                id="province"
                value="<?= $construction->province ?>"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>
    </div>

    <div class="flex gap-6">
        <div class="flex flex-col w-full">
            <label for="area" class="mt-6 text-sm font-semibold">Quartiere / area</label>
            <input 
                name="area" 
                id="area"
                value="<?= $construction->area ?>"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>
        <div class="flex flex-col w-full">
            <label for="zip_code" class="mt-6 text-sm font-semibold">CAP <span class="text-red-500">*</span></label>
            <input 
                name="zip_code" 
                id="zip_code"
                value="<?= $construction->zip_code ?>"
                class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>
    </div>

    <div class="flex gap-6">
        <div class="flex flex-col w-40">
            <label for="lat" class="mt-6 text-sm font-semibold">Latitudine</label>
            <input 
                readonly
                name="lat" 
                id="lat"
                value="<?= $construction->latitude ?>"
                class="mt-1 border border-gray-300 bg-gray-100 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>
        <div class="flex flex-col w-40">
            <label for="lng" class="mt-6 text-sm font-semibold">Longitudine</label>
            <input 
                readonly
                name="lng" 
                id="lng"
                value="<?= $construction->longitude ?>"
                class="mt-1 border border-gray-300 bg-gray-100 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
            />
        </div>
    </div>

    <div id="map" class="h-100 w-full rounded-xl mt-6"></div>
</div>

<script>

    let map;
    let geocoder;
    let marker;

    function initMap() {
        // Inizializza la mappa
        map = new google.maps.Map(document.getElementById("map"), {
            <?php if($construction->latitude && $construction->longitude) {?>
                zoom: 15,
                center: { lat: <?= $construction->latitude?>, lng: <?= $construction->longitude?> },
            <?php }else{?>
                zoom: 6,
                center: { lat: 41.9028, lng: 12.4964 },
            <?php }?>
        });

        <?php if($construction->latitude && $construction->longitude) {?>
            new google.maps.Marker({
                map: map,
                position: { lat: <?= $construction->latitude?>, lng: <?= $construction->longitude?> }
            });
        <?php }?>

        
        geocoder = new google.maps.Geocoder();

        const searchButton = document.getElementById("search-button");
        searchButton.addEventListener("click", () => {
            geocodeAddress();
        });
    }

    function geocodeAddress() {
        const address = document.getElementById("address_search").value;

        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
                const location = results[0].geometry.location;
                const lat = location.lat();
                const lng = location.lng();
                const formattedAddress = results[0].formatted_address;
                
                let number = ''
                let address = '';
                let postalCode = '';
                let province = '';
                let region = '';
                let country = '';
                let city = ''

                results[0].address_components.forEach(component => {
                    if (component.types.includes('postal_code')) {
                        postalCode = component.long_name;
                    }else if (component.types.includes('street_number')) {
                        number = component.long_name;
                    }else if (component.types.includes('route')) {
                        address = component.long_name;
                    }else if (component.types.includes('administrative_area_level_3')) {
                        city = component.long_name;
                    }else if (component.types.includes('administrative_area_level_2')) {
                        province = component.short_name;
                    }else if (component.types.includes('administrative_area_level_1')) {
                        region = component.long_name;
                    }else if (component.types.includes('country')) {
                        country = component.long_name;
                    }
                });

                console.log(results[0].address_components);
                
                document.getElementById("lat").value = lat;
                document.getElementById("lng").value = lng;
                document.getElementById("address").value = `${address} ${number}`;
                document.getElementById("city").value = city;
                document.getElementById("province").value = province;
                document.getElementById("zip_code").value = postalCode;

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
