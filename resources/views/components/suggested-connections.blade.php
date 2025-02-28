<div class="bg-white rounded-xl shadow-sm p-4">
    <h3 class="font-semibold mb-4">Suggested Connections</h3>
    <div class="space-y-4">
        @forelse($users as $user)
        <div class="flex items-start justify-between" id="user-{{ $user->id }}">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/' . $user->profile_link) }}" alt="User"
                    class="w-10 h-10 rounded-full" />
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