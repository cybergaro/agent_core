<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= isset($title) ? $title." | ": "" ?> Agent Core</title>

    <link rel="shortcut icon" href="/img/logoBlu.png" type="image/x-icon">
    
    
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/3e5cf208fc.js" crossorigin="anonymous"></script>

    @vite('resources/css/app.css')

    @yield('after_head')

</head>
<?php 
$options = [
    ["name" => "Home Agenzia", "path" => "", "icon" => "fa-solid fa-home"],
    ["name" => "Immobili", "path" => "properties", "icon" => "fa-solid fa-shop"],
    ["name" => "Cantieri", "path" => "construction_sites", "icon" => "fa-solid fa-person-digging"],
    ["name" => "Sito web", "path" => "website", "icon" => "fa-solid fa-globe"],
    // ["name" => "Social & Condivisione", "path" => "social", "icon" => "fa-solid fa-share-nodes"],
    ["name" => "Impostazioni", "path" => "settings", "icon" => "fa-solid fa-gear"],
];
?>

<?php if(Auth::user()->role == "admin"){
    $options[] = ["name" => "Agenti", "path"=>"users", "icon" =>"fa-solid fa-users"];
} ?>

<body class="overflow-hidden">
    <div class="flex h-screen bg-gray-100 font-sans">

        <!-- Sidebar -->
        <?php if(!isset($header) || $header == true){ ?>
            <?php $uuid = request()->route('agencyUuid'); ?>
            <aside class="p-5 h-screen">
                <div class="w-64 flex flex-col h-full gap-2">
                    <!-- Logo -->

                    <div class="flex items-center gap-3 px-6 py-5 bg-white rounded-3xl">
                        <img src="/img/logoBlu.png" alt="Logo Agent Core" class="h-10 w-10">
                        <span class="text-xl font-semibold text-gray-800">Agent Core</span>
                    </div>

                    <!-- Menu -->
                    <nav class="flex-1 px-4 py-5 space-y-1 bg-white rounded-3xl">
                        <?php foreach ($options as $option) { ?>
                            <a href="/dashboard/<?= $uuid ?>/<?= $option["path"]?>" class="flex items-center gap-2 px-3 py-2 rounded-xl transition hover:outline-none hover:ring-2 hover:ring-offset-2 hover:ring-indigo-500">
                                <i class="<?= $option["icon"]?>"></i> <span><?= $option["name"]?></span>
                            </a>
                        <?php }?>
                    </nav>

                    <!-- Logout in basso -->
                    <div class="px-4 py-4 bg-white rounded-3xl">
                        <?php if(Auth::user()->role == "admin"){ ?>
                            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg transition cursor-pointer" onclick="location.href='/dashboard'">
                                <i class="fa-solid fa-repeat"></i>
                                <span>Cambia Agenzia</span>
                            </button>
                        <?php } ?>
                        <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg transition cursor-pointer" onclick="location.href='/logout'">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </aside>
        <?php } ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>