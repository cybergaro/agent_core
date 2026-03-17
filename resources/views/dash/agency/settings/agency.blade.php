@extends('dashboard')

@section('content')

<form method="POST" class="p-10" enctype="multipart/form-data">
    @csrf

    <div class="flex flex-col w-full bg-white rounded-2xl shadow-lg px-7 py-7">
        <h1 class="font-inter font-semibold text-2xl">Impostazioni <?= $agency->name ?></h1>

        <label for="name" class="text-sm font-semibold mt-5">Nome <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="name"
            id="name"
            placeholder="Nome della tua agenzia"
            value="<?= $agency->name ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="email" class="text-sm font-semibold mt-5">Email <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="email"
            id="email"
            placeholder="Es: info@agenzia.com"
            value="<?= $agency->email ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="phone" class="text-sm font-semibold mt-5">Telefono <span class="text-red-500">*</span></label>
        <input
            type="text"
            name="phone"
            id="phone"
            placeholder="Es: 333 333 3333"
            value="<?= $agency->phone ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label for="website" class="text-sm font-semibold mt-5">Website</label>
        <input
            type="text"
            name="website"
            id="website"
            placeholder="Es: www.agenzia.com"
            value="<?= $agency->website ?>"
            class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
        >

        <label class="text-sm font-semibold mt-5">Logo Agenzia</label>
        <div id="drop-area" class="mt-1 relative flex justify-center items-center w-full h-40 px-4 transition bg-white border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-gray-50 focus:outline-none overflow-hidden">
            
            <img id="image-preview" 
                 src="<?= $agency->logo ? asset('storage/' . $agency->logo) : '' ?>" 
                 class="<?= $agency->logo ? 'block' : 'hidden' ?> max-h-full max-w-full object-contain p-2" 
                 alt="Logo Preview">

            <span id="default-content" class="<?= $agency->logo ? 'hidden' : 'flex' ?> flex-col items-center space-y-2 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <span class="font-medium text-gray-500 text-sm text-center" id="file-name">
                    Trascina qui il tuo logo oppure <span class="text-indigo-600 underline">clicca per sfogliare</span>
                </span>
            </span>
            
            <input type="file" name="logo" id="logo" class="hidden" accept="image/*">
        </div>
        <p class="text-xs text-gray-400 mt-1">Seleziona un'immagine per sostituire il logo attuale.</p>
    </div> 

    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
    
    <div class="mt-6">
        <p class="text-sm">Id: <span class="font-bold"><?= $agency->id ?></span></p>
        <p class="text-sm">Uuid: <span class="font-bold"><?= $agency->uuid ?></span></p>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('logo');
        const fileNameDisplay = document.getElementById('file-name');
        
        const imagePreview = document.getElementById('image-preview');
        const defaultContent = document.getElementById('default-content');

        // Apre il file manager se si clicca sull'area
        dropArea.addEventListener('click', () => fileInput.click());

        // Previene i comportamenti di default
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Effetti visivi per il drag & drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.add('border-indigo-500', 'bg-indigo-50');
                dropArea.classList.remove('border-gray-300');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.classList.remove('border-indigo-500', 'bg-indigo-50');
                dropArea.classList.add('border-gray-300');
            }, false);
        });

        // Gestione del Drop
        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files; // Assegna i file al campo input
                updateImagePreview(files[0]);
            }
        }, false);

        // Gestione Selezione Manuale
        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                updateImagePreview(this.files[0]);
            }
        });

        // Funzione per generare l'anteprima
        function updateImagePreview(file) {
            if(file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Nascondi l'icona di default e mostra l'immagine
                    defaultContent.classList.remove('flex');
                    defaultContent.classList.add('hidden');
                    
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    imagePreview.classList.add('block');
                }
                
                reader.readAsDataURL(file); // Legge il file per generare l'URL base64
            } else {
                alert("Per favore, seleziona un file immagine valido.");
                fileInput.value = ""; // Resetta l'input
            }
        }
    });
</script>

@endsection