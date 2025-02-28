<div x-data="{ 
    showDeleteModal: false, 
    showAddModal: false, 
    skillToDelete: null,
    selectedskill: null,
}">
    <x-app-layout>
        <div class="lg:col-span-3 space-y-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <x-profile-tab :activeTab="'profile'" />
                <x-succes />
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w">
                        <!-- Add skill Button -->
                        <div class="flex justify-end mb-4">
                            <button @click="showAddModal = true;"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add skill
                            </button>
                        </div>
                        <div class="grid grid-cols-s grid-cols-1 gap-6">
                            @forelse($skills as $skill)
                            <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow">
                                <span class="text-gray-900 dark:text-white font-medium">{{ $skill->name }}</span>

                                <button @click="skillToDelete = {{$skill->id}}; showDeleteModal = true;"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            @empty
                            <p class="text-gray-500 dark:text-gray-300">No programming programming Skill available.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
    </x-app-layout>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Confirm Delete</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this skill? This action cannot be undone.</p>

            <div class="mt-6 flex justify-center space-x-3">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2 border rounded-md h-full dark:text-white">Cancel</button>
                <form :action="`{{ url('skills') }}/${skillToDelete}`" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md h-full">Delete skill</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add skill Modal -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add Skill</h3>
                <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('skills.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <x-input-label for="skill_id" :value="__('Select skill')" />
                        <select id="skill_id" name="skill_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
                            <option value="">Choose a skill</option>
                            @forelse($availableSkills as $availableSkill)
                            <option value="{{ $availableSkill->id }}">{{ $availableSkill->name }}</option>
                            @empty
                            <option disabled>There are no available skills yet</option>
                            @endforelse
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showAddModal = false" class="px-4 py-2 border rounded-md dark:text-white">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add skill</button>
                </div>
            </form>
        </div>
    </div>
</div>