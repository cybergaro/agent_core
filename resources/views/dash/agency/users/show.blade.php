@extends('dashboard')

@section('content')

<div class="p-8">
    <div class="flex items-center">
        <h1 class="font-semibold text-2xl">Agenti</h1>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl bg-white">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-4 text-sm font-semibold">Nome</th>
                    <th class="px-6 py-4 text-sm font-semibold">Cognome</th>
                    <th class="px-6 py-4 text-sm font-semibold">Email</th>
                    <th class="px-6 py-4 text-sm font-semibold">Telefono</th>
                    <th class="px-6 py-4 text-sm font-semibold">Lingua</th>
                    <th class="px-6 py-4"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $users) { ?>
                    <tr class="hover:bg-gray-200 transition-colors cursor-pointer" onclick="viewEmail()">
                        <td class="px-6 py-4"><?= $user->name ?></td>
                        <td class="px-6 py-4"><?= $user->surname ?></td>
                        <td class="px-6 py-4"><?= $user->email ?></td>
                        <td class="px-6 py-4"><?= $user->phone ?></td>
                        <td class="px-6 py-4"><?= $user->lang ?></td>
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