<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Enak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">
    <header class="bg-white shadow-sm">
        <nav class="mx-auto max-w-screen-xl p-4">
            <a href="/menus" class="font-bold text-lg text-gray-800">Manajemen Menu Restoran</a>
        </nav>
    </header>

    <main class="flex-grow">
        <div class="mx-auto max-w-screen-xl py-10 px-4">
            {{ $slot }}
        </div>
    </main>
    
    <footer class="bg-gray-800 text-white p-4 text-center">
        &copy; {{ date('Y') }} Restoran Enak
    </footer>
</body>
</html>
