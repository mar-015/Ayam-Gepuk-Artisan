function updateNotificationCount() {
    fetch('/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const countElement = document.getElementById('notification-count');
            if (data.count > 0) {
                countElement.textContent = data.count;
                countElement.style.display = 'inline-flex';
            } else {
                countElement.style.display = 'none';
            }
        });
}

// Update count every minute
document.addEventListener('DOMContentLoaded', () => {
    updateNotificationCount();
    setInterval(updateNotificationCount, 60000);
});
