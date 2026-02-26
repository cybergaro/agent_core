@extends('dashboard')

@section('content')
<?php $uuid = request()->route('agencyUuid'); ?>

<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 p-10">
    <a href="/dashboard/<?= $uuid ?>/settings/import" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition">
                    <i class="fa-solid fa-download text-indigo-700"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Importazione immobili</h3>
                <p class="mt-1 text-sm text-gray-600">Collega il tuo account Agent Core ai tuoi gestionali esterni per importare i tuoi immobili e altre proprietà</p>
            </div>
        </div>
    </a>

    <a href="/dashboard/<?= $uuid ?>/settings/export" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-green-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition">
                    <i class="fa-solid fa-file-arrow-up"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Esportazione dati</h3>
                <p class="mt-1 text-sm text-gray-600">Collega servizi esterni come Google Sheet al tuo account Agent Core per l'estrazione dei dati</p>
            </div>
        </div>
    </a>

    <a href="/dashboard/<?= $uuid ?>/settings/agency" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-yellow-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-200 transition">
                    <i class="fa-solid fa-database"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Dati dell'agenzia</h3>
                <p class="mt-1 text-sm text-gray-600">Modifica il nome e altri dati publici e privati della tua agenzia</p>
            </div>
        </div>
    </a>

    <a href="/dashboard/user" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-red-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-red-100 flex items-center justify-center group-hover:bg-red-200 transition">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Dati personali</h3>
                <p class="mt-1 text-sm text-gray-600">Modifica il nome e altri dati relativi al tuo account</p>
            </div>
        </div>
    </a>

    <a href="/dashboard/user/password" class="group block rounded-2xl bg-white p-6 transform transition-all duration-200 hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="h-14 w-14 rounded-lg bg-indigo-100 flex items-center justify-center group-hover:bg-indigo-200 transition">
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900">Modifica password</h3>
                <p class="mt-1 text-sm text-gray-600">In questa sezione potrai modificare la password del tuo account</p>
            </div>
        </div>
    </a>

</div>
@endsection