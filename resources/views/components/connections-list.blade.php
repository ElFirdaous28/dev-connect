<div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <h3 class="font-semibold mb-4 text-gray-900 dark:text-white">My Connections</h3>
    <div class="space-y-4">
        @forelse($connections as $connection)
        <div class="flex items-end justify-between" id="connection-{{ $connection['connection']->id }}">
            <div class="flex items-center space-x-3">
                @if($connection['user']->profile_link)
                <img src="{{ asset('storage/' . ( $connection['user']->profile_link ?? 'default/user.png')) }}" alt="User" class="w-12 h-12 rounded-full" />
                @else
                <!-- Default SVG Avatar -->
                <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A11.954 11.954 0 0112 15c2.5 0 4.847.776 6.879 2.096M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                @endif
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $connection['user']->name }}</h4>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">{{ Str::limit($connection['user']->headline ?? 'No headline', 20) }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <a href="" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">
                    Message
                </a>
                <!-- Delete Button -->
                <button onclick="deleteConnection('{{ $connection['connection']->id }}')" class="text-gray-700 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-600">
                &#10005;
                </button>
            </div>
        </div>
        <hr class="-mt-2 dark:text-gray-600">
        @empty
        <p class="text-gray-900 dark:text-gray-200">No accepted connections yet!</p>
        @endforelse
    </div>
</div>