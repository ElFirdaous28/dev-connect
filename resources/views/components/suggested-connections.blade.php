<div class="bg-white rounded-xl shadow-sm p-4">
    <h3 class="font-semibold mb-4">Suggested Connections</h3>
    <div class="space-y-4">
        @forelse($users as $user)
        <div class="flex items-start justify-between" id="user-{{ $user->id }}">
            <div class="flex items-center space-x-3">
                @if($user->profile_link)
                <img src="{{ asset('storage/' . $user->profile_link) }}" alt="User"
                    class="w-10 h-10 rounded-full" />
                @else
                <!-- Default SVG Avatar -->
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A11.954 11.954 0 0112 15c2.5 0 4.847.776 6.879 2.096M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                @endif
                <div>
                    <h4 class="font-medium">{{ $user->name }}</h4>
                    <p class="text-gray-500 text-sm">{{ $user->position ?? 'User' }}</p>
                </div>
            </div>


            @if ($user->connectionStatus)
            @if ($user->connectionStatus == 'accepted')
            <a href=""
                class="text-blue-500 hover:text-blue-600">
                Message
            </a>
            @elseif ($user->connectionStatus == 'pending')
            <span class="text-blue-500 hover:text-blue-600">Pending</span>
            @endif
            @else
            <button
                onclick="connect({{ $user->id }})"
                class="text-blue-500 hover:text-blue-600 connect-btn">
                Connect
            </button>
            @endif
        </div>
        @empty
        <p class="dark:text-white">No suggestions yet!</p>
        @endforelse
    </div>
</div>

<script>
    async function connect(userId) {
        try {
            const response = await fetch(`/connect/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                const userElement = document.getElementById(`user-${userId}`);

                if (userElement) {
                    const button = userElement.querySelector('.connect-btn');
                    if (button) {
                        button.remove();
                    }

                    const pendingText = document.createElement('span');
                    pendingText.className = "text-blue-500 hover:text-blue-600";
                    pendingText.textContent = "Pending";
                    userElement.appendChild(pendingText);
                }
            }
        } catch (error) {
            console.error('Error Connecting:', error);
        }
    }
</script>