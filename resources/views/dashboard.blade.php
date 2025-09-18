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

<body class="overflow-hidden">
    <div class="flex h-screen bg-gray-100 font-sans">

        <!-- Sidebar -->
        <?php if(!isset($header) || $header == true){ ?>
            <?php $uuid = request()->route('agencyUuid'); ?>
            <aside class="w-64 bg-white shadow-lg flex flex-col">
                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200">
                    <img src="/img/logoBlu.png" alt="Logo Agent Core" class="h-10 w-10">
                    <span class="text-xl font-semibold text-gray-800">Agent Core</span>
                </div>

                <!-- Menu -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    
                    <a href="/dashboard/<?= $uuid ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition">
                        <i class="fa-solid fa-home"></i> <span>Home</span>
                    </a>

                    <a href="/dashboard/<?= $uuid ?>/properties" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition">
                        <i class="fa-solid fa-shop"></i> <span>Immobili</span>
                    </a>

                    <a href="/dashboard/<?= $uuid ?>/properties" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition">
                        <i class="fa-solid fa-person-digging"></i> <span>Cantieri</span>
                    </a>

                    <a href="/dashboard/<?= $uuid ?>/social" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition">
                        <i class="fa-solid fa-share-nodes"></i> <span>Social & Condivisione</span>
                    </a>

                    <a href="/dashboard/<?= $uuid ?>/settings" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition">
                        <i class="fa-solid fa-gear"></i> <span>Impostazioni</span>
                    </a>
                </nav>

                <!-- Logout in basso -->
                <form method="GET" action="/logout" class="px-4 py-4 border-t border-gray-200">
                    <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg transition cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </aside>
        <?php } ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>