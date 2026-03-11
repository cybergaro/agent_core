@extends('dashboard')

@section('content')
<?php $uuid = request()->route('agencyUuid'); ?>

<form method="POST" action="/dashboard/<?= $uuid ?>/settings/export" class="p-10">
    <div class="flex flex-col w-full bg-white rounded-2xl px-7 py-7">
        @csrf

        <h1 
            class="font-inter font-semibold text-2xl"
            title="I messaggi provenienti dal sito web verranno automaticamente esportati sul foglio google che è indicato qui sotto"
        >
            <i class="fa-solid fa-circle-info" ></i>    
            Messaggi su Google Fogli
        </h1>

        <div id="form-error" class="hidden items-center gap-2 text-red-600 bg-red-100 border border-red-300 rounded-md p-3 text-sm mt-4"></div>
       
        <div class="mt-4 w-full">
            <div class="flex flex-col w-full">
                <label for="google_cloud_credentials" class="text-sm font-semibold">Credential JSON <span class="text-red-500">*</span></label>
                <textarea
                    rows="10"
                    type="text"
                    name="google_cloud_credentials"
                    id="google_cloud_credentials"
                    placeholder='Es: {
  "type": "service_account",
  "project_id": "il-tuo-progetto",
  "private_key_id": "ecc...",
  "private_key": "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n",
  "client_email": "tuo-servizio@il-tuo-progetto.iam.gserviceaccount.com",
  "client_id": "123456789",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "..."
}'
                    class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-full"
                ><?= $agency->google_cloud_credentials ?></textarea>
            </div>

            <div class="flex gap-6">
                <div class="flex flex-col mt-6">
                    <label for="google_sheet_id" class="text-sm font-semibold">Spreadsheet ID<span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="google_sheet_id"
                        id="google_sheet_id"
                        placeholder="Es: 1T_0_FYdIrfhM_vOKIM4bifUE5gXZwcmqDHxZp7mYYh0"
                        value="<?= $agency->google_sheet_id ?>"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
                    >
                </div>
                
                <div class="flex flex-col mt-6">
                    <label for="google_sheet_id" class="text-sm font-semibold">Sheet Name<span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="google_sheet_name"
                        id="google_sheet_name"
                        placeholder="Es: Tab 1"
                        value="<?= $agency->google_sheet_name ?>"
                        class="mt-1 border border-gray-300 rounded-lg outline-none px-4 py-3 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-100"
                    >
                </div>
            </div>
        </div>
    </div>

    <input type="submit"
        value="Salva"
        class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-6 font-medium transition"
    >
</form>
@endsection