@extends('dashboard')

@section('content')
<div class="flex h-screen w-full bg-gray-100 font-sans">
    <div class="w-full md:w-1/2 flex items-center justify-center">
        <div>    
            <h1 class="font-semibold text-3xl">Verifica la tua Email</h1>
            <p class="text-gray-500 mt-2 text-sm">Ti abbiamo inviato un'email, segui la procedura indicata per continuare.</p>
        </div>
    </div>

    <!-- Sezione di destra con logo -->
    <div class="hidden md:flex w-1/2 bg-blue-700 items-center justify-center">
        <div class="flex items-center gap-4">
            <img src="/img/logoBianco.png" alt="Logo Agent Core" class="h-14 w-14">
            <p class="text-white font-semibold text-3xl">Agent Core</p>
        </div>
    </div>
</div>
@endsection