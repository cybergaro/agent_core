@extends('dashboard')

@section('content')

<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Richieste di valutazione</h1>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl bg-white">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold">Nome</th>
                    <th class="px-6 py-4 text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-sm font-semibold">Telefono</th>
                    <th class="px-6 py-4 text-sm font-semibold">Numero locali</th>
                    <th class="px-6 py-4 text-sm font-semibold">Metri quadri</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emails as $email) { ?>
                    <tr class="hover:bg-gray-200 transition-colors cursor-pointer" onclick="viewEmail()">
                        <td class="px-6 py-4"><?= $email->name ?></td>
                        <td class="px-6 py-4"><?= $email->email ?></td>
                        <td class="px-6 py-4"><?= $email->tel ?></td>
                        <td class="px-6 py-4"><?= $email->n_room ?></td>
                        <td class="px-6 py-4"><?= $email->size ?> m²</td>
                        <td class="px-6 py-4"><i class="fa-regular fa-eye"></i></td>
                    </tr>
                <?php } ?>
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