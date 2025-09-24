@extends('dashboard')

@section('content')

<div class="p-10">
    <h1 class="font-inter font-semibold text-2xl">Social & Condivisione</h1>

    <!-- Facebook -->
    <div class="flex flex-col bg-white rounded-2xl px-7 py-7 mt-5 w-150">
        <h2 class="text-xl font-semibold mb-4">
            <i class="fa-brands fa-facebook text-blue-600"></i> Facebook
        </h2>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow w-60 cursor-pointer font-semibold">
            Collega il tuo account
        </button>
    </div>

    <!-- Instagram -->
    <div class="flex flex-col bg-white rounded-2xl px-7 py-7 mt-5 w-150">
        <h2 class="text-xl font-semibold mb-4">
            <i class="fa-brands fa-instagram"></i> Instagram
        </h2>

        <button class="cursor-pointer w-60 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-lg bg-gradient-to-r from-[#feda75] via-[#fa7e1e] via-[#d62976] via-[#962fbf] to-[#4f5bd5]">
            Collega il tuo account
        </button>
    </div>

    <!-- TikTok -->
    <div class="flex flex-col bg-white rounded-2xl px-7 py-7 mt-5 w-150">
        <h2 class="text-xl font-semibold mb-4">
            <i class="fa-brands fa-tiktok"></i> TikTok
        </h2>

        <button class="cursor-pointer w-60 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-lg bg-gradient-to-r rom-[#69C9D0] to-[#EE1D52]">
            Collega il tuo account
        </button>
    </div>
</div>

@endsection