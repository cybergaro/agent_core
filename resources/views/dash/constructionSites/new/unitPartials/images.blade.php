<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 shadow-sm mt-6">
    <h2 class="font-bold text-xl mb-4">Immagini</h2>

    <div 
        id="dropzone" 
        class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer relative"
    >
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clicca per caricare</span> o trascina qui le immagini</p>
            <p class="text-xs text-gray-400">PNG, JPG, JPEG, HEIC</p>
        </div>
        <input id="file-input" name="images[]" type="file" class="hidden" multiple accept=".png, .jpg, .jpeg, .heic, image/png, image/jpeg, image/heic" />
    </div>

    <div id="deleted-images-container" class="hidden"></div>

    <div class="mt-6">
        <h3 class="font-semibold text-gray-700 mb-3 text-lg {{ (isset($images) && $images->count() > 0) ? '' : 'hidden' }}" id="list-title">Immagini Caricate:</h3>
        <ul id="file-list" class="flex flex-col gap-3">
            
            {{-- CICLO BLADE PER LE IMMAGINI GIÀ ESISTENTI NEL DATABASE --}}
            @if(isset($images) && $images->count() > 0)
                @foreach($images as $image)
                    <li class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200" id="existing-image-{{ $image->id }}">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Anteprima" class="w-20 h-20 object-cover rounded-md flex-shrink-0 bg-gray-100 shadow-sm border border-gray-200">
                            
                            <div class="flex flex-col min-w-0">
                                <span class="text-sm font-medium text-gray-700 truncate">Immagine caricata</span>
                                <span class="text-xs text-gray-400">Già salvata</span>
                            </div>
                        </div>
                        
                        <button type="button" class="text-red-500 hover:text-red-700 p-1 delete-existing-btn" data-id="{{ $image->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </li>
                @endforeach
            @endif

        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const listTitle = document.getElementById('list-title');
    const deletedContainer = document.getElementById('deleted-images-container');

    let uploadedFiles = [];

    // Apre la finestra file
    dropzone.addEventListener('click', () => fileInput.click());

    // Previene il comportamento default
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
    });

    // Effetti grafici
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, () => {
            dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        });
    });

    // Gestione Drop e Click
    dropzone.addEventListener('drop', (e) => handleFiles(e.dataTransfer.files));
    fileInput.addEventListener('change', function() { handleFiles(this.files); });

    function handleFiles(files) {
        // FILTRO: accetta solo immagini
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'heic'];
        
        let validFiles = Array.from(files).filter(file => {
            const ext = file.name.split('.').pop().toLowerCase();
            return allowedExtensions.includes(ext) || file.type.startsWith('image/');
        });

        if (validFiles.length > 0) {
            listTitle.classList.remove('hidden');
            validFiles.forEach(file => uploadedFiles.push(file));
            updateFileList();
        }

        if (validFiles.length < files.length) {
            alert('Alcuni file sono stati ignorati. Carica solo immagini PNG, JPG, JPEG o HEIC.');
        }
    }

    function updateFileList() {
        // Pulisce solo i file nuovi caricati via JS
        document.querySelectorAll('.new-file-item').forEach(el => el.remove());
        
        uploadedFiles.forEach((file, index) => {
            const sizeInKB = (file.size / 1024).toFixed(1);
            const li = document.createElement('li');
            li.className = "new-file-item flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200";
            
            // CREA L'URL PER L'ANTEPRIMA DELL'IMMAGINE
            const objectURL = URL.createObjectURL(file);
            
            // Nota HEIC: i browser web non supportano nativamente la visualizzazione dei file .heic nei tag <img>. 
            // In quel caso si vedrà l'icona di immagine rotta standard del browser, ma il caricamento funzionerà ugualmente.
            li.innerHTML = `
                <div class="flex items-center gap-3 overflow-hidden">
                    <img src="${objectURL}" alt="Anteprima" class="w-20 h-20 object-cover rounded-md flex-shrink-0 bg-gray-200 shadow-sm border border-gray-300">
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-medium text-gray-700 truncate">${file.name}</span>
                        <span class="text-xs text-green-600 font-semibold">Nuova immagine - ${sizeInKB} KB</span>
                    </div>
                </div>
                <button type="button" class="text-red-500 hover:text-red-700 p-1 remove-btn" data-index="${index}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            fileList.appendChild(li);
        });

        // Eventi per rimuovere i NUOVI file
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                const indexToRemove = parseInt(this.getAttribute('data-index'));
                uploadedFiles.splice(indexToRemove, 1);
                updateFileList();
            });
        });

        syncFileInput();
    }

    function syncFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
        
        if (fileList.children.length === 0) {
            listTitle.classList.add('hidden');
        } else {
            listTitle.classList.remove('hidden');
        }
    }

    document.querySelectorAll('.delete-existing-btn').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-id');
            
            // Crea un input nascosto con il nome esatto richiesto dal tuo codice PHP
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'images_to_delete[]';
            hiddenInput.value = imageId;
            deletedContainer.appendChild(hiddenInput);

            // Rimuovi visivamente l'elemento
            const listItem = document.getElementById('existing-image-' + imageId);
            if(listItem) listItem.remove();

            if (fileList.children.length === 0) listTitle.classList.add('hidden');
        });
    });
});
</script>