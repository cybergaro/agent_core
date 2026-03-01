@extends('dashboard')

@section('content')
<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Cantieri</h1>
        <a href="/dashboard/{{ request()->route('agencyUuid') }}/construction_site/new" class="bg-blue-600 text-white text-md font-medium rounded-xl px-3 py-2 ml-5 transition-colors hover:bg-blue-700">
            <i class="fa-solid fa-plus"></i> 
            Aggiungi nuovo
        </a>
    </div>

    <table class="mt-4 border-collapse rounded-3xl overflow-hidden w-full">
        <tbody class="w-full bg-white flex flex-col gap-1">
            @foreach ($sites as $site)
                <tr 
                    class="flex items-center px-5 py-5 hover:bg-gray-200 rounded-2xl cursor-pointer transition-colors" 
                    onclick="window.location='/dashboard/{{ request()->route('agencyUuid') }}/construction_site/{{ $site->uuid }}'"
                >
                    <td>
                        {{-- Corretto il bug: da $property a $site --}}
                        @if($site->image_path)
                            <img src="/storage/{{ $site->image_path }}" class="h-25 w-40 object-cover rounded-xl">
                        @else
                            <img src="/img/image_not_found.webp" class="h-25 w-40 object-cover rounded-xl">
                        @endif
                    </td>
                    
                    <td class="ml-4 w-130 flex-grow">
                        <h2 class="font-semibold text-md">{{ $site->name }}</h2>
                        
                        {{-- Qui usiamo l'helper Str::limit per tagliare a 100 caratteri --}}
                        <p class="text-sm text-gray-600 mt-1 mb-1">
                            {{ \Illuminate\Support\Str::limit($site->description, 300) }}
                        </p>
                        
                        <p class="text-sm text-gray-800">
                            <i class="fa-solid fa-location-dot text-red-500 mr-1"></i>
                            {{ $site->address }}
                        </p>
                    </td>
                    
                    {{-- Blocco la propagazione del click per il tasto elimina --}}
                    <td class="flex gap-3 items-center ml-auto" onclick="event.stopPropagation()">
                        <a href="/dashboard/{{ request()->route('agencyUuid') }}/construction_site/{{ $site->uuid }}/delete" title="Elimina cantiere" class="cursor-pointer">
                            <i class="fa-solid fa-trash text-red-500 hover:text-red-700 transition-colors"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($sites->count() > 0)
        <div class="rounded-xl h-10 flex items-center overflow-x-auto bg-white w-fit mt-5">
            @php 
                $current = $sites->currentPage();
            @endphp
            
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page={{ $current > 1 ? $current-1 : 1 }}'">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            
            @for ($i = 1; $i <= $sites->lastPage(); $i++)
                <button 
                    class="px-2 h-full w-10 cursor-pointer rounded-xl {{ $current == $i ? 'bg-blue-600 text-white' : 'hover:bg-gray-200 text-gray-600' }} font-semibold transition-colors" 
                    onclick="location.href='?page={{ $i }}'"
                >
                    {{ $i }}
                </button>
            @endfor
            
            <button class="rounded-xl cursor-pointer h-full text-gray-600 px-3 w-10 hover:bg-gray-200" onclick="location.href='?page={{ $sites->lastPage() != $current ? $current+1 : $current }}'">
                <i class="fa-solid fa-angle-right"></i>
            </button>
        </div>
    @endif
</div>  
@endsection