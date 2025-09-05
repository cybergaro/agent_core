@extends('default')

@section('content')
<?php $uuid = request()->route('agencyUuid'); ?>

<form method="POST" action="/dashboard/<?= $uuid ?>/settings/import" class="p-10">
    <div class="flex flex-col w-full bg-white rounded-2xl shadow-lg px-7 py-7">
        @csrf

        <h1 class="font-inter font-semibold text-2xl">RealSmart</h1>

        <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>
       
        <div class="flex mt-4 gap-5">
            <div class="flex flex-col">
                <label for="email" class="text-sm font-semibold">XML Url <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="real_smart_xml_url"
                    id="real_smart_xml_url"
                    placeholder="Es: https://gestim2002.it/portali/xxx.xml"
                    value="<?= $agency->real_smart_xml_url ?>"
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
                >
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input
                    type="checkbox"
                    name="real_smart_remove_after_delete"
                    id="real_smart_remove_after_delete"
                    <?= $agency->real_smart_remove_after_delete ? "checked" : "" ?>
                    class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                >
                Elimina gli immobli non più presenti su RealSmart
            </label>

            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input
                    type="checkbox"
                    name="enable_real_smart_importer"
                    id="enable_real_smart_importer"
                    <?= $agency->enable_real_smart_importer ? "checked" : "" ?>
                    class="h-5 w-5 text-indigo-600 border-gray-400 rounded-lg focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                >
                Abilita l'importazione
            </label>
        </div>
    </div>

    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
</form>
@endsection