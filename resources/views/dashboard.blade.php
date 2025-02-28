<x-app-layout>

    <div class="space-y-6">
        <x-profile />
        <x-tranding-tags />
    </div>
    <div class="lg:col-span-2 space-y-6">
        <x-post-create />

        <!-- posts -->
        <div class="max-w-7xl mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Posts -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="" alt="User"
                                    class="w-12 h-12 rounded-full" />
                                <div>
                                    <h3 class="font-semibold">Alex Chen</h3>
                                    <p class="text-gray-500 text-sm">Senior Backend Developer at Tech Corp</p>
                                    <p class="text-gray-400 text-xs">1h ago</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-700">Just implemented a caching layer using Redis that reduced our
                                API
                                response time by 70%! Here's a simple example of how to implement caching in
                                Node.js:
                            </p>

                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                <pre>
                                        <code>
                                            const redis = require('redis');
                                            const client = redis.createClient();

                                            async function getCachedData(key) {
                                            const cached = await client.get(key);
                                            if (cached) {
                                                return JSON.parse(cached);
                                            }

                                            const data = await fetchDataFromDB();
                                            await client.setEx(key, 3600, JSON.stringify(data));
                                            return data;
                                            }
                                        </code>
                                    </pre>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">#nodejs</span>
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">#redis</span>
                                <span
                                    class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">#performance</span>
                            </div>

                            <div class="mt-4 flex items-center justify-between border-t pt-4">
                                <div class="flex items-center space-x-4">
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <span>42</span>
                                    </button>
                                    <button class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        <span>12</span>
                                    </button>
                                </div>
                                <button class="text-gray-500 hover:text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</x-app-layout>