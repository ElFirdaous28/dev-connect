<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>



<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-profile-tab :activeTab="'profile'" />
            <x-succes />
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w">
                    <!-- Add New Post Button -->
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('posts.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold tracking-widest hover:bg-blue-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Post
                        </a>
                    </div>

                    <!-- Posts Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-6">
                        @forelse($posts as $post)
                        <div class="flex flex-col bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                            <!-- Post Image -->
                            @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                class="w-full h-40 object-cover rounded-md shadow">
                                @else
                                <div class="w-full h-40 object-cover rounded-md shadow"></div>
                            @endif

                            <!-- Post Title -->
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $post->title }}
                            </h3>

                            <!-- Post Content (Short Preview) -->
                            <div class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                <div class="ql-snow">
                                    <div class="ql-editor line-clamp-4 overflow-hidden" style="padding: 0 !important;">
                                        {!! $post->content !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center mt-auto">
                                <!-- View Post -->
                                <a href="{{ route('posts.show', $post) }}"
                                    class="text-blue-500 hover:text-blue-700 text-sm">
                                    Read More
                                </a>

                                <div class="flex space-x-3">
                                    <!-- Edit Button -->
                                    <a href="{{ route('posts.edit', $post) }}"
                                        class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <!-- Delete Button (Standard Form Submission) -->
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 dark:text-gray-300">No posts available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>