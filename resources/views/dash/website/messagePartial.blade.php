<div id="evaluation-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 transition-opacity duration-300">

  <div id="modal-box" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col">
    
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
      <h2 class="text-xl font-semibold text-gray-800">
        Dettaglio messaggio
      </h2>
      <button id="close-icon" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <div class="px-6 py-6 overflow-y-auto max-h-[70vh]">
      
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div>
          <span class="block text-sm font-medium text-gray-500">Nome</span>
          <span class="block text-base text-gray-900"><?= $message->name ?? 'N/D' ?></span>
        </div>
        <div>
          <span class="block text-sm font-medium text-gray-500">Telefono</span>
          <span class="block text-base text-gray-900">{{ $message->tel ?? 'N/D' }}</span>
        </div>
        <div>
          <span class="block text-sm font-medium text-gray-500">Email</span>
          <span class="block text-base text-gray-900">{{ $message->email ?? 'N/D' }}</span>
        </div>
        <div>
          <span class="block text-sm font-medium text-gray-500">Categoria</span>
          <span class="block text-base text-gray-900"> {{ __("message.".$message->category) }} </span>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
        <span class="block text-sm font-medium text-gray-500 mb-1">Messaggio / Descrizione</span>
        <p class="text-gray-800 text-base">
          {{ $message->message ?? 'Nessun messaggio inserito dall\'utente.' }}
        </p>
      </div>

    </div>

    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
      <button id="close-btn" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Chiudi
      </button>
    </div>

  </div>
</div>
