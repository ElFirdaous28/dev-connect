<x-app-layout>
    <div class="space-y-6">
        <x-profile />
        <x-tranding-tags />
    </div>
    <div class="lg:col-span-2 space-y-6">
        <x-post-create />

        <!-- posts -->
        <div class="max-w-7xl mx-auto">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
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
                                    <button @click="showComments = !showComments" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                        </svg>
                                        <span x-text="comments.length">{{ $post->comments->count() }}</span>
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
                                            <img :src="`/storage/${comment.user.profile_link || 'default/user.png'}`"
                                                alt="User Avatar" class="w-8 h-8 rounded-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <!-- Normal comment view -->
                                            <div x-show="!isEditing" class="bg-gray-50 p-3 rounded-lg">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-medium text-sm text-gray-800" x-text="comment.user.name"></h4>
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
        </div>
        <!-- </div> -->
</x-app-layout>

<script src="{{ asset('js/like.js') }}"></script>