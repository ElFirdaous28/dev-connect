<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Edit Post') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Update your post details below.") }}
                    </p>
                </header>

                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="w-full space-y-5">
                        <!-- Title Input -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                value="{{ old('title', $post->title) }}" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Quill Editor for Content -->
                        <div class="text-white">
                            <x-input-label for="content" :value="__('Content')" />
                            <div id="editor" class="mt-1 block w-full border border-gray-300 p-3 rounded-md">
                                {!! old('content', $post->content) !!}
                            </div>
                            <textarea name="content" id="content-input" class="hidden"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <div>
                            <x-input-label for="hashtags" :value="__('Hashtags')" />
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Both spaces and # are treated as separators.
                            </p>

                            <x-text-input id="hashtags" name="hashtags" type="text" class="mt-1 block w-full"
                                value="{{ old('hashtags', implode(' ', $post->hashtags->pluck('name')->toArray())) }}"
                                required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('hashtags')" />
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <x-input-label for="image" :value="__('Update Post Image (Optional)')" />
                            <input type="file" id="image" name="image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" onchange="previewImage(event)" />
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <!-- Current Image Preview -->
                        @if($post->image)
                        <div id="image-preview" class="mt-3">
                            <img id="preview" src="{{ asset('storage/' . $post->image) }}" alt="Image Preview" class="w-full h-64 object-cover rounded-md shadow-md" />
                        </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button id="update-button">{{ __('Update Post') }}</x-primary-button>
                        <a href="{{ route('posts.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
</x-app-layout>


<!-- Quill Editor JS and Image Preview Script -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<script>
    // Initialize Quill Editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{
                    'header': '1'
                }, {
                    'header': '2'
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['bold', 'italic', 'underline'],
                [{
                    'align': []
                }],
                ['link'],
                ['blockquote', 'code-block'],
            ],
        }
    });

    document.querySelector('#update-button').addEventListener('click', function(e) {
        // Get the HTML content directly from Quill
        const htmlContent = quill.root.innerHTML;
        const textArea = document.getElementById('content-input');
        textArea.value = htmlContent; // Ensure this is set to textarea's value
    });

    // Image preview functionality
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('image-preview').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>