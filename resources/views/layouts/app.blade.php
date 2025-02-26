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
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Job Recommendations</h3>
                        <div class="space-y-4">
                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded" />
                                    <div>
                                        <h4 class="font-medium">Senior Full Stack Developer</h4>
                                        <p class="text-gray-500 text-sm">TechStart Inc.</p>
                                        <p class="text-gray-500 text-sm">Remote • Full-time</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">React</span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Node.js</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded" />
                                    <div>
                                        <h4 class="font-medium">DevOps Engineer</h4>
                                        <p class="text-gray-500 text-sm">CloudScale Solutions</p>
                                        <p class="text-gray-500 text-sm">San Francisco • Hybrid</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">AWS</span>
                                            <span
                                                class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Docker</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 w-full text-blue-500 hover:text-blue-600 text-sm font-medium">
                            View All Jobs
                        </button>
                    </div>

                    <!-- Suggested Connections -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Suggested Connections</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="https://avatar.iran.liara.run/public/boy" alt="User"
                                        class="w-10 h-10 rounded-full" />
                                    <div>
                                        <h4 class="font-medium">Emily Zhang</h4>
                                        <p class="text-gray-500 text-sm">Frontend Developer</p>
                                    </div>
                                </div>
                                <button class="text-blue-500 hover:text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>