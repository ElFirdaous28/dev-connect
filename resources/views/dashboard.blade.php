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
                @forelse($posts as $post)
                <div class="bg-white rounded-xl shadow-sm mb-5">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">

                                <img src="{{ asset('storage/' . $post->user->profile_link) }}" alt="User"
                                    class="w-12 h-12 rounded-full" />


                                <div>
                                    <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                                    <p class="text-gray-500 text-sm">{{ auth()->user()->headline }}</p>
                                    <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                </svg>
                            </button>
                        </div>

                        <div class="">
                            <!-- content -->
                            <div class="ql-snow">
                                <div class="ql-editor" style="padding: 0 !important;">
                                    {!! $post->content !!}
                                </div>
                            </div>


                            <div class="flex items-center justify-between border-t pt-4">
                                <div class="flex items-center space-x-4">

                                    <button onclick="toggleLike('{{ $post->id }}')"
                                        class="like-button text-gray-500 flex items-center space-x-2 hover:text-blue-600"
                                        data-post-id="{{ $post->id }}">
                                        <svg class="h-5 w-5 like-icon" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span class="likes-count">{{ $post->likes->count() }}</span>
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
                @empty
                <p>No posts availibale</p>
                @endforelse
            </div>
        </div>
</x-app-layout>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.like-button').forEach(button => {
            const postId = button.dataset.postId;
            checkLikeStatus(postId);
        });
    });


    async function toggleLike(postId) {
        try {
            const response = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
                const icon = button.querySelector('.like-icon');
                const count = button.querySelector('.likes-count');

                // Update like count
                count.textContent = data.likesCount;

                // Update icon state
                if (data.isLiked) {
                    icon.style.fill = 'currentColor';
                } else {
                    icon.style.fill = 'none';
                }
            }
        } catch (error) {
            console.error('Error toggling like:', error);
        }
    }
    async function checkLikeStatus(postId) {
        try {
            const response = await fetch(`/posts/${postId}/check-like`);
            const data = await response.json();

            const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
            const icon = button.querySelector('.like-icon');

            if (data.isLiked) {
                button.classList.replace('text-gray-500', 'text-blue-600');
                icon.style.fill = 'currentColor';
            }
        } catch (error) {
            console.error('Error checking like status:', error);
        }
    }
</script>