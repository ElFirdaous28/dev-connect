<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ showModal: false, showDeleteModal: false, editMode: false, formData: {title: '',description: '',link: '',code_link: '' }, 
    openEditModal(project) {this.editMode = true;this.formData = {title: project.title,description: project.description,link: project.link,code_link: project.code_link,currentProjectId:project.id};this.showModal = true;},
    openDeleteModal(project) {this.currentProject = project;this.showDeleteModal = true;}}">
    <x-app-layout>
        <div class="lg:col-span-3 space-y-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <x-profile-tab :activeTab="'profile'" />
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w">
                        <!-- Add Project Button -->
                        <div class="flex justify-end mb-4">
                            <button @click="showModal = true; editMode = false; formData = {title: '', description: '', link: '', code_link: ''};" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Project
                            </button>
                        </div>
                        <div class="grid grid-cols-s md:grid-cols-2 gap-6">
                            @forelse($projects as $project)
                            <!-- projects carsds -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Project Details -->
                                    <div class="w-full flex flex-col h-full">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $project->title}}</h3>
                                            <div class="flex space-x-2">
                                                <button @click="openEditModal({{ json_encode($project) }})" class="text-gray-500 hover:text-blue-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </button>
                                                <button @click="openDeleteModal({{ json_encode($project) }})" class="text-gray-500 hover:text-red-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $project->description }}</p>

                                        <div class="mt-4 flex flex-wrap gap-2">
                                        </div>

                                        <div class="flex justify-between items-center mt-0">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <span>{{ $project->created_at->diffForHumans()}}</span>
                                            </div>

                                            <div class="flex space-x-3 mt-auto">
                                                <a href="{{ $project->demo_link }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                    Live Demo
                                                </a>
                                                <a href="{{ $project->code_link}}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                                    </svg>
                                                    Code
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p>No projects yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
    </x-app-layout>

    <!-- Add/Edit Project Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 dark:text-white" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="editMode ? 'Edit Project' : 'Add New Project'"></h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form x-bind:action="editMode ? '{{ route('projects.update', ':id') }}'.replace(':id', formData.currentProjectId) : '{{ route('projects.store') }}'" method="POST">
                @csrf
                <!-- Method Override if in edit mode -->
                <template x-if="editMode">
                    @method('PUT')
                </template>
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title *')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $project->title ?? '')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 p-2 text-left" :value="editMode ? '{{ old('description', trim($project->description ?? '')) }}' : ''"> </textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <!-- Demo Link -->
                    <div>
                        <x-input-label for="demo_link" :value="__('Demo Link')" />
                        <x-text-input id="demo_link" name="demo_link" type="url" class="mt-1 block w-full" :value="old('demo_link', $project->demo_link ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('demo_link')" />
                    </div>

                    <!-- Code Link -->
                    <div>
                        <x-input-label for="code_link" :value="__('Code Link')" />
                        <x-text-input id="code_link" name="code_link" type="url" class="mt-1 block w-full" :value="old('code_link', $project->code_link ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('code_link')" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 border rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        <span x-text="editMode ? 'Update Project' : 'Add Project'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Confirm Delete</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this project? This action cannot be undone.</p>

            <div class="mt-6 flex justify-center space-x-3">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2 border rounded-md h-full dark:text-white">Cancel</button>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md h-full">Delete Project</button>
                </form>
            </div>

        </div>
    </div>
</div>