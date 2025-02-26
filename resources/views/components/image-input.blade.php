<div class="flex flex-col items-center">
    <x-input-label for="profile_link" :value="__('Profile Image')" />

    <!-- Hidden file input -->
    <input
        type="file"
        name="profile_link"
        id="profile_link"
        class="opacity-0 absolute w-0 h-0"
        accept="image/*"
        onchange="previewImage(event)">


    <!-- Image preview -->
    <div id="image-preview" class="mt-2">
        <img id="preview"
            class="mt-2 w-32 h-32 object-cover rounded-full border-4 border-gray-200 shadow-lg"
            src="{{ $value ?? 'https://via.placeholder.com/150' }}"
            alt="Profile Placeholder">
    </div>

    <!-- Custom button to trigger file input -->
    <button
        type="button"
        class="mt-2 bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700 focus:outline-none"
        onclick="document.getElementById('profile_link').click();">
        Select Image
    </button>

    <x-input-error class="mt-2" :messages="$errors->get('profile_link')" />
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const preview = document.getElementById('preview');

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>