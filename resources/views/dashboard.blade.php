<x-app-layout>
    <div class="space-y-6">
        <x-profile />
        <x-tranding-tags />
    </div>
    <div class="lg:col-span-2 space-y-6">
        <x-post-create />

        <!-- posts -->
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" id="posts-container">
                <!-- Posts -->
                @forelse($posts as $post)
                <div x-data="{ 
                                showComments: false,
                                comments: {{ json_encode($post->comments) }},
                                newComment: '',
                                
                                async addComment() {
                                    try {
                                        const response = await fetch('{{ route('comments.store', $post->id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({ content: this.newComment })
                                        });
                                        
                                        const result = await response.json();
                                        
                                        if (result.success) {
                                            // Add new comment to the array with current user info
                                            this.comments.push({
                                                id: result.comment.id,
                                                content: this.newComment,
                                                created_at: 'Just now',
                                                user: {
                                                    id: {{ auth()->id() }},
                                                    name: '{{ auth()->user()->name }}',
                                                    profile_link: '{{ auth()->user()->profile_link ?? 'default/user.png' }}'
                                                },
                                                user_id: {{ auth()->id() }}
                                            });
                                            
                                            // Clear comment input
                                            this.newComment = '';
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                    }
                                },
                                
                                confirmDelete(commentId, index) {
                                    if (confirm('Are you sure you want to delete this comment?')) {
                                        this.deleteComment(commentId, index);
                                    }
                                },

                                async deleteComment(commentId, index) {
                                    try {
                                        const response = await fetch(`/comments/${commentId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        });
                                        
                                        const result = await response.json();
                                        
                                        if (result.success) {
                                            this.comments.splice(index, 1);
                                        }
                                    } catch (error) {
                                        console.error('Error:', error);
                                    }
                                }
                            }" class="mb-5">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('storage/' . ($post->user->profile_link ?? 'default/user.png') ) }}" alt="User" class="w-12 h-12 rounded-full" />
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
                        <!-- content and actions -->
                        <div>
                            <div> {{ $post->title }}</div>
                            <!-- hashtags -->
                            <div class="flex space-x-2 mt-4">
                                @foreach($post->hashtags as $hashtag)
                                <a href="{{ route('search') }}?value=%23{{ $hashtag->name }}"
                                    class="text-sm bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-blue-600 dark:text-blue-200 dark:hover:bg-blue-500 px-3 py-1 rounded-full transition duration-200">
                                    #{{ $hashtag->name }}
                                </a>
                                @endforeach
                            </div> 
                            <!-- content -->
                            <div class="ql-snow">
                                <div class="ql-editor" style="padding: 0 !important;">
                                    {!! $post->content !!}
                                </div>
                            </div>
                            <img src="{{ asset('storage/' . $post->image) }}" alt="">


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
                                    <button @click="showComments = !showComments" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        <span x-text="comments.length">{{ $post->comments->count() }}</span>
                                    </button>
                                </div>
                                <!-- share button -->
                                <div x-data="{ showShareOptions: false }" class="relative inline-block">
                                    <!-- Share Button -->
                                    <button @click="showShareOptions = !showShareOptions" class="text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </button>

                                    <!-- Share Options (Horizontal) -->
                                    <div x-show="showShareOptions" @click.away="showShareOptions = false"
                                        x-transition.duration.300ms
                                        class="absolute top-full right-0 mt-2 bg-white border border-gray-200 shadow-md rounded-lg p-2 flex space-x-3">

                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('posts.show', $post->id)) }}"
                                            target="_blank" class="p-2 hover:bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-5 h-5 fill-current text-blue-600">
                                                <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                                            </svg>
                                        </a>

                                        <!-- Twitter/X -->
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->id)) }}&text={{ urlencode($post->title) }}"
                                            target="_blank" class="p-2 hover:bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-5 h-5 fill-current text-gray-700">
                                                <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                            </svg>
                                        </a>

                                        <!-- LinkedIn -->
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('posts.show', $post->id)) }}"
                                            target="_blank" class="p-2 hover:bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-current text-blue-700">
                                                <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z" />
                                            </svg>
                                        </a>

                                        <!-- WhatsApp -->
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . route('posts.show', $post->id)) }}"
                                            target="_blank" class="p-2 hover:bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-current text-green-500">
                                                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- comment section -->
                    <div x-show="showComments" x-transition.duration.300ms class="bg-white rounded-xl shadow-sm mt-2">
                        <div class="bg-white text-gray-800 rounded-xl shadow-sm p-4">
                            <!-- Add Comment Form -->
                            <div class="mb-4">
                                <div class="flex items-start space-x-3">
                                    <!-- Default Avatar -->
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mt-4">
                                        <img src="{{ asset('storage/' . (auth()->user()->profile_link ??  'default/user.png')) }}"
                                            alt="User Avatar" class="w-8 h-8 rounded-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <textarea rows="2"
                                            x-model="newComment"
                                            class="w-full px-3 py-2 text-sm border border-gray-300 bg-gray-100 text-gray-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Add a comment..."></textarea>
                                        <div class="flex justify-end mt-2">
                                            <button @click="addComment()"
                                                class="px-4 py-1 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                                Post
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                <template x-for="(comment, index) in comments" :key="comment.id">
                                    <div x-data="{ isEditing: false, commentText: comment.content }" class="comment-item flex space-x-3 items-center">
                                        <!-- User Avatar -->
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <img :src="`/storage/${comment.user?.profile_link || 'default/user.png'}`"
                                                alt="User Avatar" class="w-8 h-8 rounded-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <!-- Normal comment view -->
                                            <div x-show="!isEditing" class="bg-gray-50 p-3 rounded-lg">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-medium text-sm text-gray-800" x-text="comment.user?.name || 'User'"></h4>
                                                    <div class="text-xs text-gray-400" x-text="comment.created_at"></div>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-600" x-text="commentText"></p>
                                            </div>

                                            <!-- Edit form -->
                                            <div x-show="isEditing" class="bg-gray-50 p-3 rounded-lg">
                                                <form @submit.prevent="
                                                    fetch(`/comments/${comment.id}`, {
                                                        method: 'PATCH',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON.stringify({ content: commentText })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.success) {
                                                            isEditing = false;
                                                            comment.content = commentText;
                                                        }
                                                    })
                                                    .catch(error => console.error('Error:', error))">
                                                    <textarea
                                                        x-model="commentText"
                                                        class="w-full px-3 py-2 text-sm border border-gray-300 bg-white text-gray-800 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                                        rows="2"></textarea>
                                                    <div class="flex justify-end mt-2 space-x-2">
                                                        <button type="button" @click="isEditing = false"
                                                            class="px-3 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none">
                                                            Cancel
                                                        </button>
                                                        <button type="submit"
                                                            class="px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-1 flex ml-3 space-x-4 text-xs">
                                                <template x-if="comment.user_id == {{ auth()->id() }}">
                                                    <div class="flex space-x-4">
                                                        <button @click="confirmDelete(comment.id, index)" class="text-gray-400 hover:text-red-500">Delete</button>
                                                        <button @click="isEditing = true" type="button" class="text-gray-400 hover:text-blue-500">Edit</button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <p x-show="comments.length === 0" class="text-gray-700 text-center">No comments yet!</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p>No posts available</p>
                @endforelse
            </div>

            <!-- Load More Indicator -->
            @if($posts->hasMorePages())
            <div id="load-more-container" class="py-4 text-center">
                <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-blue-500 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                    <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                </div>
                <p class="text-gray-500 mt-2">Loading more posts...</p>
            </div>
            <div id="load-more-trigger" class="h-10 w-full"></div>
            @endif
        </div>
        <!-- Pagination Next URL -->
        @if($posts->hasMorePages())
        <div id="next-page-url" data-url="{{ $posts->nextPageUrl() }}" class="hidden"></div>
        @endif
</x-app-layout>

<script src="{{ asset('js/like.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreTrigger = document.getElementById('load-more-trigger');
        const loadMoreContainer = document.getElementById('load-more-container');

        if (loadMoreTrigger && loadMoreContainer) {
            loadMoreContainer.style.display = 'none'; // Hide loading initially

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        loadMoreContainer.style.display = 'block'; // Show loading
                        const nextPageUrl = document.getElementById('next-page-url').dataset.url;
                        observer.unobserve(loadMoreTrigger); // Stop observing while loading

                        fetch(nextPageUrl)
                            .then(response => response.text())
                            .then(data => {
                                const doc = new DOMParser().parseFromString(data, 'text/html');
                                const newPosts = doc.querySelectorAll('#posts-container > div');
                                const postsContainer = document.getElementById('posts-container');
                                newPosts.forEach(post => postsContainer.appendChild(post));

                                const nextPageElement = doc.getElementById('next-page-url');
                                if (nextPageElement) {
                                    document.getElementById('next-page-url').dataset.url = nextPageElement.dataset.url;
                                    loadMoreContainer.style.display = 'none';
                                    observer.observe(loadMoreTrigger); // Resume observing
                                } else {
                                    loadMoreContainer.remove();
                                    loadMoreTrigger.remove();
                                }
                            })
                            .catch(() => {
                                loadMoreContainer.innerHTML = 'Error loading posts.';
                            });
                    }
                });
            }, {
                threshold: 0.1
            });

            observer.observe(loadMoreTrigger);
        }
    });
</script>