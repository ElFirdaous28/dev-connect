<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="relative">
        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
        @if(auth()->user()->profile_link)
        <img src="{{ asset('storage/' . auth()->user()->profile_link) }}" alt="Profile"
            class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md" />
        @else
        <div class="absolute -bottom-6 left-4 w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center border-4 border-white shadow-md">
            <svg class="w-10 h-10 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A11.954 11.954 0 0112 15c2.5 0 4.847.776 6.879 2.096M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        @endif

    </div>
    <div class="pt-14 p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('profile.edit') }}" class="text-xl font-bold">{{Auth::user()->name}}</a>
            @if(Auth::user()->github_link)
            <a href="{{Auth::user()->github_link}}" target="_blank" class="text-gray-600 hover:text-black">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                </svg>
            </a>
            @endif
        </div>
        <p class="text-gray-900 text-sm mt-1">{{ Auth::user()->headline }}</p>
        <p class="text-gray-500 text-sm mt-2">{{ Auth::user()->bio}}


        <div class="mt-4 pt-4 border-t">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Connections</span>
                <span class="text-blue-600 font-medium">487</span>
            </div>
            <div class="flex justify-between text-sm mt-2">
                <span class="text-gray-500">Posts</span>
                <span class="text-blue-600 font-medium">52</span>
            </div>
        </div>
    </div>
</div>