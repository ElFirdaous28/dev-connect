<div class="flex items-center space-x-2 border-b border-gray-300 mb-10">
    <a href="/posts"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->is('posts') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Posts
    </a>
    <a href="{{ route('profile.edit') }}"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->routeIs('profile.edit') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Profile
    </a>
    <a href="{{ route('projects.index') }}"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->routeIs('projects.index') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Projects
    </a>
    <a href="/skills"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->is('skills') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Skills
    </a>
    <a href="/languages"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->is('languages') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Programming Languages
    </a>
    <a href="/certificates"
        class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-t-lg {{ request()->is('certificates') ? 'bg-white dark:bg-gray-800 border-b-4 border-indigo-500' : '' }}">
        Certificates
    </a>
</div>