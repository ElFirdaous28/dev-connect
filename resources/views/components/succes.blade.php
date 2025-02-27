<div x-data="{ showSuccess: false }" x-init="setTimeout(() => showSuccess = false, 3000)" x-show="showSuccess" class="fixed top-0 right-0 m-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-md rounded-md p-4 z-50">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4M5 12l2 2l4-4" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
</div>