document.addEventListener('DOMContentLoaded', function () {
    const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');

    if (userId) {
        window.Echo.private(`chat.${userId}`)
            .listen('.message.sent', (data) => {
                // console.log('New message received:', data);
                // alert(JSON.stringify(data));

                addMessageToUI(data.message,data.created_at);
            });
    }
});