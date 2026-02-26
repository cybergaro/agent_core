<div class="flex flex-col w-full max-w-4xl bg-white rounded-2xl px-8 py-5 shadow-sm mt-6">
    <h2 class="font-bold text-xl mb-4">Documenti</h2>

    <div 
        id="dropzone" 
        class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer relative"
    >
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
            </svg>
            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clicca per caricare</span> o trascina qui i file</p>
            <p class="text-xs text-gray-400">PDF, DOCX, JPG, PNG</p>
        </div>
        <input id="file-input" name="documents[]" type="file" class="hidden" multiple />
    </div>

    <div id="deleted-documents-container" class="hidden"></div>

    <div class="mt-6">
        <h3 class="font-semibold text-gray-700 mb-3 text-lg hidden" id="list-title">Documenti Caricati:</h3>
        <ul id="file-list" class="flex flex-col gap-3">
            
            @if(isset($documents) && $documents->count() > 0)
                @foreach($documents as $doc)
                    <li class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200" id="existing-doc-{{ $doc->id }}">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div class="flex flex-col min-w-0">
                                <span class="text-sm font-medium text-gray-700 truncate">{{ $doc->name ?? 'Documento senza nome' }}</span>
                                <span class="text-xs text-gray-400">Già salvato</span>
                            </div>
                        </div>
                        
                        <button type="button" class="text-red-500 hover:text-red-700 p-1 delete-existing-btn" data-id="{{ $doc->id }}">
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
    const deletedContainer = document.getElementById('deleted-documents-container');

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
        if (files.length > 0) {
            listTitle.classList.remove('hidden');
            Array.from(files).forEach(file => uploadedFiles.push(file));
            updateFileList();
        }
    }

    function updateFileList() {
        // Pulisce solo i file nuovi caricati via JS, non tocca eventuali file esistenti stampati da Blade
        document.querySelectorAll('.new-file-item').forEach(el => el.remove());
        
        uploadedFiles.forEach((file, index) => {
            const sizeInKB = (file.size / 1024).toFixed(1);
            const li = document.createElement('li');
            li.className = "new-file-item flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200";
            
            li.innerHTML = `
                <div class="flex items-center gap-3 overflow-hidden">
                    <svg class="w-6 h-6 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-medium text-gray-700 truncate">${file.name}</span>
                        <span class="text-xs text-green-600 font-semibold">Nuovo file - ${sizeInKB} KB</span>
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

        // SINCRONIZZA L'INPUT NASCOSTO PER LARAVEL (Fondamentale!)
        syncFileInput();
    }

    // Questa funzione inserisce i file dell'array nell'input type="file" effettivo
    function syncFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
        
        // Nascondi il titolo se non ci sono file di nessun tipo
        if (fileList.children.length === 0) {
            listTitle.classList.add('hidden');
        } else {
            listTitle.classList.remove('hidden');
        }
    }

    // --- GESTIONE DEI FILE ESISTENTI NEL DATABASE ---
    document.querySelectorAll('.delete-existing-btn').forEach(button => {
        button.addEventListener('click', function() {
            const docId = this.getAttribute('data-id');
            
            // Crea un input nascosto con il nome richiesto da Laravel
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'documents_to_delete[]';
            hiddenInput.value = docId;
            deletedContainer.appendChild(hiddenInput);

            // Rimuovi visivamente l'elemento dalla lista
            const listItem = document.getElementById('existing-doc-' + docId);
            if(listItem) listItem.remove();

            // Aggiorna visibilità titolo
            if (fileList.children.length === 0) listTitle.classList.add('hidden');
        });
    });
});
</script>