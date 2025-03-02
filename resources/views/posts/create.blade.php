<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-profile-tab />
            <section>
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Create New Post') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Write your thoughts and share them with others.") }}
                    </p>
                </header>

                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="flex gap-2 justify-evenly">
                        <div class="w-full space-y-5">
                            <!-- Title Input -->
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" 
                                    value="{{ old('title') }}" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <!-- Quill Editor for Content -->
                            <div class="text-white">
                                <x-input-label for="content" :value="__('Content')" />
                                <div id="editor" class="mt-1 block w-full border border-gray-300 p-3 rounded-md">
                                    {!! old('content') !!} <!-- Populate with old content if available -->
                                </div>
                                <!-- Replace the hidden input with a textarea -->
                                <textarea name="content" id="content-input" class="hidden">{{ old('content') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('content')" />
                            </div>

                            <div>
                                <x-input-label for="hashtags" :value="__('Hashtags')" />
                                <x-text-input id="hashtags" name="hashtags" type="text" class="mt-1 block w-full" 
                                    value="{{ old('hashtags') }}" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('hashtags')" />
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <x-input-label for="image" :value="__('Post Image (Optional)')" />
                                <input type="file" id="image" name="image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" onchange="previewImage(event)" />
                                <x-input-error class="mt-2" :messages="$errors->get('image')" />
                            </div>

                            <!-- Image Preview -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview" src="{{ old('image') ? asset('storage/' . old('image')) : '' }}" alt="Image Preview" class="w-full h-64 object-cover rounded-md shadow-md" />
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button id="create-button">{{ __('Create Post') }}</x-primary-button>
                    </div>
                </form>
            </section>
        </div>
</x-app-layout>

<!-- Quill Editor JS and CSS -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script>
    // Initialize Quill Editor
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': '1' }, { 'header': '2' }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['bold', 'italic', 'underline'],
                [{ 'align': [] }],
                ['link'],
                ['blockquote', 'code-block'],
            ],
        }
    });

    // If there's any old content, set it in the Quill editor
    const oldContent = `{{ old('content') }}`;
    if (oldContent) {
        quill.root.innerHTML = oldContent;  // Populate the editor with old content
    }

    document.querySelector('#create-button').addEventListener('click', function(e) {
        // Get the HTML content directly from Quill
        const htmlContent = quill.root.innerHTML;
        const textArea = document.getElementById('content-input');
        textArea.value = htmlContent;  // Ensure this is set to textarea's value
    });

    // Image preview functionality
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            // Set the preview image source to the uploaded file
            document.getElementById('preview').src = e.target.result;
            // Show the preview
            document.getElementById('image-preview').style.display = 'block';
        };

        // Read the uploaded file as a data URL
        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
