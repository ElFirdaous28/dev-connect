import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const userId = document.querySelector('meta[name="user-id"]')?.getAttribute('content');

    if (userId) {
        // Listen for notifications on the user's private channel
        window.Echo.private(`user.${userId}`)
            .notification((notification) => {
                console.log('New notification received:', notification);

                // Increment notification counter
                incrementNotificationCounter();

                // Add notification to dropdown silently
                addNotificationToDropdown(notification);
            });
    }
});

/**
 * Increment the notification counter in the navbar
 */
function incrementNotificationCounter() {
    const counterElement = document.querySelector('#notification-counter');
    if (counterElement) {
        const currentCount = parseInt(counterElement.textContent || '0');
        counterElement.textContent = currentCount + 1;
    }
}

/**
 * Add a new notification to the dropdown menu
 */
function addNotificationToDropdown(notification) {
    const notificationContainer = document.querySelector('.max-h-96.overflow-y-auto');
    if (!notificationContainer) return;

    let notificationMessage = '';

    if (notification.type === 'like') {
        notificationMessage = `
            <a href="/posts/${notification.post_id}" class="text-blue-500 hover:text-blue-700">
                ${notification.user_name} liked your post.
            </a>`;
    } else if (notification.type === 'comment') {
        notificationMessage = `
            <a href="/posts/${notification.post_id}" class="text-blue-500 hover:text-blue-700">
                ${notification.user_name} commented on your post.
            </a>`;
    } else {
        notificationMessage = notification.content || 'New notification';
    }

    // Create notification element
    const notificationItem = document.createElement('div');
    notificationItem.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b last:border-b-0 dark:border-gray-700';

    // Set the HTML content of the notification
    notificationItem.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <img src="/storage/default/user.png" class="w-8 h-8 rounded-full" alt="Avatar">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    ${notification.user_name || 'User'}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    ${notificationMessage}
                </p>
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    just now
                </p>
            </div>
        </div>
    `;

    // Insert at the beginning of the container
    notificationContainer.insertBefore(notificationItem, notificationContainer.firstChild);
}
