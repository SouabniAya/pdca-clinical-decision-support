<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PDCA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="app-layout">

        <x-sidebar :active="$active ?? 'dashboard'" />

        <div class="app-layout__main">

            <x-header />

            <main class="app-layout__content">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>