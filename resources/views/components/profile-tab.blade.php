<div x-data="{ activeTab: '{{ $activeTab ?? 'profile' }}' }">
    <div class="flex items-center space-x-2 border-b border-gray-300 mb-10">
        <!-- Tab Links -->

        <a href="#Posts"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'Posts'}"
            @click.prevent="activeTab = 'Posts'">
            Posts
        </a>

        <a href="#profile"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'profile'}"
            @click.prevent="activeTab = 'profile'">
            Profile
        </a>

        <a href="#projects"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'projects'}"
            @click.prevent="activeTab = 'projects'">
            Projects
        </a>

        <a href="#skills"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'skills'}"
            @click.prevent="activeTab = 'skills'">
            Skills
        </a>

        <a href="#languages"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'languages'}"
            @click.prevent="activeTab = 'languages'">
            Programming Languages
        </a>

        <a href="#certificates"
            class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg"
            :class="{'bg-white dark:bg-gray-800 border-b-4 border-indigo-500': activeTab === 'certificates'}"
            @click.prevent="activeTab = 'certificates'">
            Certificates
        </a>
    </div>
</div>
