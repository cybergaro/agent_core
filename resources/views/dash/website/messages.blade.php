@extends('dashboard')

@section('content')

<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Messaggi</h1>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl bg-white">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold">Nome</th>
                    <th class="px-6 py-4 text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-sm font-semibold">Telefono</th>
                    <th class="px-6 py-4 text-sm font-semibold">Categoria</th>
                    <th class="px-6 py-4 text-sm font-semibold">Data</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr class="hover:bg-gray-200 transition-colors cursor-pointer" onclick="viewEmail(<?= $message->id ?>)">
                        <td class="px-6 py-4">{{ $message->name }}</td>
                        <td class="px-6 py-4">{{ $message->email }}</td>
                        <td class="px-6 py-4">{{ $message->tel }}</td>
                        
                        <td class="px-6 py-4">
                            {{ __("message.".$message->category) }} 
                        </td>
                        
                        {{-- Formattazione della data in dd/mm/yyyy tramite Carbon --}}
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                        </td>
                        
                        <td class="px-6 py-4"><i class="fa-regular fa-eye"></i></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="viewMessage">

    </div>

    @if($messages->count() > 0)
        <div class="rounded-xl h-10 flex items-center overflow-x-auto bg-white w-fit mt-5">
            @php 
                $current = $messages->currentPage();
            @endphp
            
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page={{ $current > 1 ? $current-1 : 1 }}'">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            
            @for ($i = 1; $i <= $messages->lastPage(); $i++)
                <button 
                    class="px-2 h-full w-10 cursor-pointer rounded-xl {{ $current == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200 text-gray-600' }} font-semibold transition-colors" 
                    onclick="location.href='?page={{ $i }}'"
                >
                    {{ $i }}
                </button>
            @endfor
            
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page={{ $messages->lastPage() != $current ? $current+1 : $current }}'">
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
    @endif
</div>

<script>
    const viewEmail = async (id) => {
        const container = document.getElementById('viewMessage');
        
        container.innerHTML = `
            <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/60 backdrop-blur-sm">
                <span class="text-white font-medium bg-gray-800 px-6 py-3 rounded-lg shadow-lg">Caricamento messaggio...</span>
            </div>
        `;

        try {
            const response = await fetch(`/dashboard/<?= $agency->uuid ?>/website/message/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' 
                }
            });

            if (!response.ok) {
                throw new Error(`Errore HTTP: ${response.status}`);
            }

            const htmlContent = await response.text();

            container.innerHTML = htmlContent;

            const modalOverlay = document.getElementById('evaluation-modal');
            const modalBox = document.getElementById('modal-box');
            const closeBtn = document.getElementById('close-btn');
            const closeIcon = document.getElementById('close-icon');

            const closeModal = () => {
                container.innerHTML = '';
            };

            if (modalOverlay && modalBox) {
                if (closeBtn) closeBtn.addEventListener('click', closeModal);
                if (closeIcon) closeIcon.addEventListener('click', closeModal);

                modalOverlay.addEventListener('click', function(event) {
                    if (!modalBox.contains(event.target)) {
                        closeModal();
                    }
                });
            }

        } catch (error) {
            console.error("Si è verificato un errore durante il recupero dell'email:", error);
            container.innerHTML = `
                <div class="fixed inset-0 z-50 flex justify-center items-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="p-6 bg-white text-red-600 rounded-xl shadow-2xl max-w-sm w-full text-center">
                        <p class="font-medium mb-4">Impossibile caricare il messaggio. Riprova più tardi.</p>
                        <button onclick="document.getElementById('viewMessage').innerHTML=''" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Chiudi</button>
                    </div>
                </div>
            `;
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const container = document.getElementById('viewMessage');
            if (container && container.innerHTML.trim() !== '') {
                container.innerHTML = '';
            }
        }
    });
</script>
@endsection