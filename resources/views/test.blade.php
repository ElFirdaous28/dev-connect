<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Dropdown</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<div class="relative">
  <button id="notification-ring" class="flex items-center space-x-1 hover:text-blue-400 relative">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">
          3
      </span>
  </button>

  <!-- Dropdown Container -->
  <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border dark:border-gray-700 z-50">
      <div class="px-4 py-3 border-b dark:border-gray-700 flex justify-between items-center">
          <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notifications</h3>
          <button class="text-xs text-blue-500 hover:text-blue-700">
              Mark all as read
          </button>
      </div>

      <!-- Notification Items -->
      <div class="max-h-96 overflow-y-auto">
          <!-- Notification Item -->
          <div class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b last:border-b-0 dark:border-gray-700">
              <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0">
                      <img src="/path-to-avatar.jpg" class="w-8 h-8 rounded-full" alt="Avatar">
                  </div>
                  <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 dark:text-white">
                          New message from John Doe
                      </p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">
                          You have a new connection request
                      </p>
                      <p class="text-xs text-gray-400 dark:text-gray-500">
                          2 mins ago
                      </p>
                  </div>
              </div>
          </div>

          <!-- More Notification Items -->
          <div class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer border-b last:border-b-0 dark:border-gray-700">
              <div class="flex items-start space-x-3">
                  <div class="flex-shrink-0">
                      <img src="/path-to-avatar.jpg" class="w-8 h-8 rounded-full" alt="Avatar">
                  </div>
                  <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-900 dark:text-white">
                          Project Update
                      </p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">
                          Your project has been approved
                      </p>
                      <p class="text-xs text-gray-400 dark:text-gray-500">
                          1 hour ago
                      </p>
                  </div>
              </div>
          </div>
      </div>

      <div class="px-4 py-3 text-center border-t dark:border-gray-700">
          <a href="#" class="text-sm text-blue-500 hover:text-blue-700">
              View all notifications
          </a>
      </div>
  </div>
</div>

<script>
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
</script>
</body>
</html>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>

        @php
            $userId = auth()->check() ? auth()->user()->id:0;
       @endphp  
        console.log("yes it me" ,{{$userId}});

  Pusher.logToConsole = true;

  var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });


  var channel = pusher.subscribe('my-channel');
  channel.bind("Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", function(data) {
        
        
    console.log(data)

            alert(data.comment) 
      
  });
</script>