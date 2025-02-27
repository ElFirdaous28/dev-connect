<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<div x-data="{ showModal: false, showDeleteModal: false, editMode: false, currentCertificate: {}, formData: {title: '', provider: '', date: '', currentCertificateId: ''},
                openEditModal(certificate) { this.editMode = true; this.formData = {title: certificate.title, provider: certificate.provider, date: certificate.date, currentCertificateId: certificate.id}; this.showModal = true; },
                openAddModal() {this.editMode = false;this.formData = {title: '', provider: '', date: '', currentCertificateId: ''};this.showModal = true;},
                openDeleteModal(certificate) {this.currentCertificate = certificate;this.showDeleteModal = true;} }">

    <x-app-layout>
        <div class="lg:col-span-3 space-y-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <x-profile-tab :activeTab="'profile'" />
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w">
                        <!-- Add Certificate Button -->
                        <div class="flex justify-end mb-4">
                            <button @click="openAddModal()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Certificate
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($certificates as $certificate)
                            <!-- Certificate Cards -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Certificate Details -->
                                    <div class="w-full flex flex-col h-full">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $certificate->title }}</h3>
                                            <div class="flex space-x-2">
                                                <button @click="openEditModal({{ json_encode($certificate) }})" class="text-gray-500 hover:text-blue-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </button>
                                                <button @click="openDeleteModal({{ json_encode($certificate) }})" class="text-gray-500 hover:text-red-500 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <p class="text-gray-600 dark:text-gray-300 mt-2">Provider: {{ $certificate->provider }}</p>
                                        <p class="text-gray-600 dark:text-gray-300 mt-2">Issued on: {{ $certificate->date->diffForHumans() }}</p>

                                        <div class="mt-4 flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="dark:text-gray-100">No certificates yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
    </x-app-layout>

    <!-- Add/Edit Certificate Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 dark:text-white" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white" x-text="editMode ? 'Edit Certificate' : 'Add New Certificate'"></h3>
                <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form x-bind:action="editMode ? '{{ route('certificates.update', ':id') }}'.replace(':id', formData.currentCertificateId) : '{{ route('certificates.store') }}'" method="POST">
                @csrf
                <!-- Method Override if in edit mode -->
                <template x-if="editMode">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title *')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" x-model="formData.title" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <!-- Provider -->
                    <div>
                        <x-input-label for="provider" :value="__('Provider')" />
                        <x-text-input id="provider" name="provider" type="text" class="mt-1 block w-full" x-model="formData.provider" />
                        <x-input-error class="mt-2" :messages="$errors->get('provider')" />
                    </div>

                    <!-- Date -->
                    <div>
                        <x-input-label for="date" :value="__('Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', $certificate->date ? $certificate->date->format('Y-m-d') : '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('date')" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 border rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                        <span x-text="editMode ? 'Update Certificate' : 'Add Certificate'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75" x-transition>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Confirm Delete</h3>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Are you sure you want to delete this certificate? This action cannot be undone.</p>

            <div class="mt-6 flex justify-center space-x-3">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2 border rounded-md h-full dark:text-white">Cancel</button>
                <form :action="'{{ route('certificates.destroy', '') }}/' + currentCertificate.id" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md h-full">Delete Certificate</button>
                </form>
            </div>
        </div>
    </div>
</div>