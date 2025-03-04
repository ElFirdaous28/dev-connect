
    document.addEventListener('DOMContentLoaded', function() {
        const notificationRing = document.getElementById('notification-ring');
        const notificationDropdown = document.getElementById('notification-dropdown');
    
        // Toggle dropdown on ring click
        notificationRing.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent immediate closing
            notificationDropdown.classList.toggle('hidden');
        });
    
        // Close dropdown if clicked outside
        document.addEventListener('click', function() {
            notificationDropdown.classList.add('hidden');
        });
    
        // Prevent dropdown from closing when clicked inside
        notificationDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
