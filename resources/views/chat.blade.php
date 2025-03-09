<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="flex-1 bg-white dark:bg-gray-800 p-6">
            <!-- Chat Header -->
            <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-6 dark:text-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full bg-gray-200">
                        <img src="{{ asset('storage/' . ($secondUser->profile_link ?? 'default/user.png') ) }}" alt="User" class="w-12 h-12 rounded-full" />
                    </div>
                    <div class="flex flex-col">
                        <div class="text-xl font-semibold" id="chatUserName">{{ $secondUser->name }}</div>
                        <small id="chatUserHeadline">{{ $secondUser->headline }}</small>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div id="chatMessages" class="space-y-4 max-h-96 min-h-96 overflow-y-auto scrollbar-hide mb-4 flex flex-col" style="scrollbar-width: none; ">
                @forelse ($messages as $message)
                @if ($message->sender_id == auth()->id())
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">
                        <p>{{ $message->message }}</p>
                        <small class="block text-xs">{{ $message->created_at->format('H:i') }}</small>
                    </div>
                </div>
                @else
                <div class="flex justify-start">
                    <div class="bg-gray-200 text-gray-900 p-3 rounded-lg max-w-xs">
                        <p>{{ $message->message }}</p>
                        <small class="block text-xs">{{ $message->created_at->format('H:i') }}</small>
                    </div>
                </div>
                @endif
                @empty
                <p id="no-messages" class="dark:text-gray-200 text-center mt-auto">No messages yet</p>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="flex items-center space-x-4">
                <input type="text" id="messageInput" name="message" class="flex-1 p-3 border rounded-lg text-sm bg-gray-100 text-gray-900 focus:outline-none" placeholder="Type a message...">
                <button id="sendMessageBtn" class="text-blue-500 hover:text-blue-600 text-lg">Send</button>
            </div>
        </div>
</x-app-layout>

<script>
    function scrollToBottom() {
        const chatContainer = document.getElementById('chatMessages');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function addMessageToUI(message, time) {
        const chatMessages = document.getElementById("chatMessages");
        document.getElementById('no-messages').remove();
        chatMessages.innerHTML += `
            <div class="flex justify-end">
                <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">
                    <p>${message}</p>
                    <small class="block text-xs">${time}</small>
                </div>
            </div>
        `;
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    document.addEventListener("DOMContentLoaded", function() {
        scrollToBottom();
        const sendMessageBtn = document.getElementById("sendMessageBtn");
        const messageInput = document.getElementById("messageInput");
        const receiverId = "{{ $secondUser->id }}"; // The other user in the chat

        sendMessageBtn.addEventListener("click", function() {
            sendMessage();
        });

        messageInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                sendMessage();
            }
        });

        function sendMessage() {
            const message = messageInput.value.trim();
            if (message === "") return;

            fetch("{{ route('chat.send') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        message: message,
                    }),
                })
                .then(response => response.json().catch(() => {
                    throw new Error("Invalid JSON response");
                }))
                .then(data => {
                    if (data.success) {
                        addMessageToUI(data.message, data.time);
                        messageInput.value = "";
                    } else {
                        console.error("Server Error:", data.error || "Unknown error");
                    }
                })
                .catch(error => {
                    console.error("Error sending message:", error);
                    alert("Error sending message: " + error.message);
                });
        }
    });
</script>