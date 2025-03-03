document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.like-button').forEach(button => {
        const postId = button.dataset.postId;
        checkLikeStatus(postId);
    });
});


async function toggleLike(postId) {
    try {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
            const icon = button.querySelector('.like-icon');
            const count = button.querySelector('.likes-count');

            // Update like count
            count.textContent = data.likesCount;

            // Update icon state
            if (data.isLiked) {
                icon.style.fill = 'currentColor';
            } else {
                icon.style.fill = 'none';
            }
        }
    } catch (error) {
        console.error('Error toggling like:', error);
    }
}
async function checkLikeStatus(postId) {
    try {
        const response = await fetch(`/posts/${postId}/check-like`);
        const data = await response.json();

        const button = document.querySelector(`.like-button[data-post-id="${postId}"]`);
        const icon = button.querySelector('.like-icon');

        if (data.isLiked) {
            button.classList.replace('text-gray-500', 'text-blue-600');
            icon.style.fill = 'currentColor';
        }
    } catch (error) {
        console.error('Error checking like status:', error);
    }
}
