document.addEventListener('DOMContentLoaded', function() {
    const profilePicture = document.getElementById('profile');
    const options = document.getElementById('options');

    function toggleOptions() {
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }

    profilePicture.addEventListener('click', function(e) {
        e.preventDefault();
        toggleOptions();
    });

    document.addEventListener('click', function(e) {
        if (!options.contains(e.target) && e.target !== profilePicture) {
            options.style.display = 'none';
        }
    });

    const notesContainers = document.querySelectorAll('.notes-container');

    notesContainers.forEach((notesContainer) => {
        const setts = notesContainer.querySelectorAll('.setts');
        const optionsMenus = notesContainer.querySelectorAll('.options-menu');

        setts.forEach((settsItem, index) => {
            settsItem.addEventListener('click', function(e) {
                const rect = settsItem.getBoundingClientRect();
                const optionsMenu = optionsMenus[index];
                if (optionsMenu.style.display === 'block') {
                    optionsMenu.style.display = 'none';
                } else {
                    optionsMenu.style.display = 'block';
                    optionsMenu.style.top = rect.bottom + 'px';
                    optionsMenu.style.left = rect.left + 'px';
                }
            });
        });

        document.addEventListener('click', function(e) {
            setts.forEach((settsItem, index) => {
                const optionsMenu = optionsMenus[index];
                if (!settsItem.contains(e.target) && !optionsMenu.contains(e.target)) {
                    optionsMenu.style.display = 'none';
                }
            });
        });
    });

    const modalBox = document.getElementById("modalBox");
    const addNoteButton = document.getElementById("addNoteButton");

    addNoteButton.addEventListener('click', function() {
        overlay.style.display = "block";
        modalBox.style.display = "block";
    });
});

function showEditOverlay() {
    document.getElementById('editOverlay').style.display = 'block';
    document.getElementById('editModalBox').style.display = 'block';
}

function hideEditOverlay() {
    document.getElementById('editOverlay').style.display = 'none';
    document.getElementById('editModalBox').style.display = 'none';
}

function showEditOverlay(noteId) {
    const editOverlay = document.getElementById('editOverlay');
    const editModalBox = document.getElementById('editModalBox');
    
    // Set the value of the hidden input field
    document.getElementById('editNoteId').value = noteId;
    
    // Make AJAX request to fetch note data
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'getnote.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                console.error(response.error);
            } else {
                // Populate form fields with retrieved data
                document.getElementById('editFormTitle').value = response.note_title;
                document.getElementById('editDescription').value = response.note_desc;
                
                // Show edit overlay and modal box
                editOverlay.style.display = 'block';
                editModalBox.style.display = 'block';
            }
        } else {
            console.error('Failed to fetch note data');
        }
    };
    xhr.send('note_id=' + noteId);
}
 
function changeFilter(status) {
    window.location.href = "dashboard.php?status=" + status;
}

function showPrompt(noteId) {
    var promptOverlay = document.getElementById('promptOverlay');
    promptOverlay.style.display = 'block';
}

function hidePrompt() {
    var promptOverlay = document.getElementById('promptOverlay');
    promptOverlay.style.display = 'none';
}

function toggleHeartAndStatus(noteId) {
    var currentStatusElement = document.getElementById('status_' + noteId);
    var currentStatus = currentStatusElement.innerText.trim();
    var heartIcon = document.getElementById('heart_' + noteId);
    
    if (currentStatus === 'Favorites') {
        // Show prompt to remove from favorites
        showRemoveFromFavoritesPrompt(noteId);
    } else {
        // Send AJAX request to update status to 'Favorites'
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'updatefavoritestatus.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Status updated to Favorites');
                // Change status text and heart icon color to red
                currentStatusElement.innerText = 'Favorites';
                heartIcon.classList.add('red-heart');
            } else {
                // Handle update failure
                console.error('Failed to update status');
            }
        };
        xhr.send('note_id=' + noteId);
    }
}

function showRemoveFromFavoritesPrompt(noteId) {
    var removePromptOverlay = document.getElementById('removePromptOverlay');
    removePromptOverlay.style.display = 'block';
    removePromptOverlay.dataset.noteId = noteId; // Store noteId in the overlay's dataset
}

function hideRemoveFromFavoritesPrompt() {
    var removePromptOverlay = document.getElementById('removePromptOverlay');
    removePromptOverlay.style.display = 'none';
}

function confirmRemoveFromFavorites() {
    var noteId = document.getElementById('removePromptOverlay').dataset.noteId;
    // Send AJAX request to update status to 'Added'
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'updatefavoritestatus.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Status updated to Added');
            // Change status text and remove red color from heart icon
            var currentStatusElement = document.getElementById('status_' + noteId);
            var heartIcon = document.getElementById('heart_' + noteId);
            currentStatusElement.innerText = 'Added';
            heartIcon.classList.remove('red-heart');
            // Hide remove prompt overlay
            hideRemoveFromFavoritesPrompt();
        } else {
            // Handle update failure
            console.error('Failed to update status');
        }
    };
    xhr.send('note_id=' + noteId);
}


function validateNote() {
    const title = document.getElementById('formTitle').value.trim();
    const description = document.getElementById('description').value.trim();
    const whitespacePrompt = document.getElementById('whitespacePrompt');

    if (/^\s*$/.test(title) || /^\s*$/.test(description)) {
        // Title or description contains only whitespace characters
        whitespacePrompt.style.display = 'block';
        return false; // Prevent form submission
    }

    // Hide the whitespace prompt if everything is valid
    whitespacePrompt.style.display = 'none';
    return true; // Allow form submission
}


