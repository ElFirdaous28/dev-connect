// Accept Connection
function acceptConnection(connectionId) {
    fetch(`/connection/${connectionId}/accept`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Connection accepted') {
                removeElementWithHr(`request-${connectionId}`);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Reject Connection
function rejectConnection(connectionId) {
    fetch(`/connection/${connectionId}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Connection rejected') {
                removeElementWithHr(`request-${connectionId}`);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Delete Connection
function deleteConnection(connectionId) {
    fetch(`/connection/${connectionId}/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Connection deleted') {
                removeElementWithHr(`connection-${connectionId}`);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Function to remove an element and its following <hr>
function removeElementWithHr(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        const nextElement = element.nextElementSibling;
        element.remove();
        if (nextElement && nextElement.tagName === "HR") {
            nextElement.remove();
        }
    }
}
