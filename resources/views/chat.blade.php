<x-app-layout>
    <div class="lg:col-span-3 space-y-6">
        <div class="flex-1 bg-white dark:bg-gray-800 p-6">
            <!-- Chat Header -->
            <div class="flex items-center justify-between border-b border-gray-300 pb-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gray-500"></div>
                    <div class="text-xl font-semibold" id="chatUserName">{{ $secondUser->name }}</div> <!-- Dynamically display user's name -->
                </div>
            </div>

            <!-- Messages -->
            <div id="chatMessages" class="space-y-4 max-h-96 overflow-y-auto scrollbar-hide mb-4" style="scrollbar-width: none; ">
                @foreach ($messages as $message)
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
                @endforeach
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
    document.addEventListener("DOMContentLoaded", function() {
        scrollToBottom();
        const sendMessageBtn = document.getElementById("sendMessageBtn");
        const messageInput = document.getElementById("messageInput");
        const chatMessages = document.getElementById("chatMessages");
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
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Append message to chat box with timestamp
                        chatMessages.innerHTML += `
                        <div class="flex justify-end">
                            <div class="bg-blue-500 text-white p-3 rounded-lg max-w-xs">
                                <p>${data.message}</p>
                                <small class="block text-xs">${data.time}</small>
                            </div>
                        </div>
                    `;
                        messageInput.value = "";
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }
                })
                .catch(error => console.error("Error sending message:", error));
        }
    });
</script>