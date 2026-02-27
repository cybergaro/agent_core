@extends('dashboard')

@section('content')

@php
    $categoryTranslations = [
        'buy'          => 'Cerco un immobile da acquistare',
        'sell'         => 'Vorrei vendere il mio immobile',
        'evaluation'   => 'Richiesta valutazione gratuita',
        'visit_buy'    => 'Visita per annuncio di vendita',
        'rent'         => 'Cerco un immobile in affitto',
        'let'          => 'Propongo il mio immobile per l\'affitto',
        'visit_rent'   => 'Visita per annuncio di affitto',
        'management'   => 'Gestione affitti / Property Management',
        'mortgage'     => 'Informazioni su mutui e finanziamenti',
        'technical'    => 'Informazioni tecniche o burocratiche',
        'construction' => 'Cantieri e nuove costruzioni',
        'job'          => 'Lavora con noi / Candidatura',
        'other'        => 'Informazioni generali / Altra richiesta'
    ];
@endphp

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
                    <tr class="hover:bg-gray-200 transition-colors cursor-pointer" onclick="viewEmail()">
                        <td class="px-6 py-4">{{ $message->name }}</td>
                        <td class="px-6 py-4">{{ $message->email }}</td>
                        <td class="px-6 py-4">{{ $message->tel }}</td>
                        
                        {{-- Traduzione della categoria con fallback in caso di chiave non trovata --}}
                        <td class="px-6 py-4">
                            {{ $categoryTranslations[$message->category] ?? 'Categoria sconosciuta' }}
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
</div>  

<script>
    const viewEmail = () => {
        console.log("ok")
    }
</script>
@endsection