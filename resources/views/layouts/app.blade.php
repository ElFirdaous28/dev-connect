<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <x-navbar />

        <!-- Page Content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto pt-20 px-4">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    {{ $slot }}
                </div>
                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Job Recommendations -->
                    <x-job-recommendations/>
                    <!-- Suggested Connections -->
                    <x-suggested-connections/>
                </div>
            </div>
        </main>
    </div>
</body>

</html>