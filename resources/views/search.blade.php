<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-succes />
            <h3 class="font-semibold mb-4 text-gray-900 dark:text-white">Search Results for "{{ $value }}"</h3>

            <!-- Users Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Users</h4>
                @forelse($users as $user)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-3">
                        @if($user->profile_link)
                        <img src="{{ asset('storage/' . ( $user->profile_link ?? 'default/user.png')) }}" alt="User" class="w-12 h-12 rounded-full" />
                        @else
                        <!-- Default SVG Avatar -->
                        <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A11.954 11.954 0 0112 15c2.5 0 4.847.776 6.879 2.096M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        @endif
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ Str::limit($user->headline ?? 'No headline', 20) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('chat', $user->id) }}" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">
                            Message
                        </a>
                    </div>
                </div>
                <hr class="my-4 dark:text-gray-600">
                @empty
                <p class="text-gray-900 dark:text-gray-200">No users found.</p>
                @endforelse
            </div>

            <!-- Posts Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Posts</h4>
                @forelse($posts as $post)
                <div class="space-y-4 border border-gray-300 dark:border-gray-600 p-4 rounded-lg mb-4">
                    <h5 class="font-medium text-gray-900 dark:text-white">{{ $post->title }}</h5>
                    @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full rounded-lg mb-4">
                    @endif

                    <div class="flex space-x-2 mt-4">
                                @foreach($post->hashtags as $hashtag)
                                <a href="{{ route('search') }}?value=%23{{ $hashtag->name }}"
                                    class="text-sm bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-600 dark:text-blue-200 dark:hover:bg-blue-500 px-3 py-1 rounded-full transition duration-200">
                                    #{{ $hashtag->name }}
                                </a>
                                @endforeach
                            </div> 
                    <div class="ql-snow dark:text-gray-200">
                        <div class="ql-editor line-clamp-4" style="padding: 0 !important;">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300">Read More</a>
                </div>
                @empty
                <p class="text-gray-900 dark:text-gray-200">No posts found.</p>
                @endforelse
            </div>

        </div>
</x-app-layout>

<script src="{{ asset('js/connection.js') }}" defer></script>
