// public/js/admin.js - Admin panel client-side functionality

document.addEventListener('DOMContentLoaded', function() {
    // Function to confirm prize deletion
    function confirmPrizeDelete(event) {
        if (!confirm('Are you sure you want to delete this prize?')) {
            event.preventDefault();
        }
    }

    // Add event listeners to all prize delete buttons
    const deleteButtons = document.querySelectorAll('.delete-prize');
    deleteButtons.forEach(button => {
        button.addEventListener('click', confirmPrizeDelete);
    });

    // Function to preview uploaded image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Add event listener to image upload input
    const imageUpload = document.getElementById('prize_image');
    if (imageUpload) {
        imageUpload.addEventListener('change', previewImage);
    }

    // Function to validate form inputs
    function validateForm(event) {
        const winChance = document.getElementById('win_chance').value;
        const timeLimit = document.getElementById('time_limit').value;

        if (winChance < 0 || winChance > 100) {
            alert('Win chance must be between 0 and 100');
            event.preventDefault();
        }

        if (timeLimit < 1) {
            alert('Time limit must be at least 1 second');
            event.preventDefault();
        }
    }

    // Add event listener to settings form
    const settingsForm = document.getElementById('settingsForm');
    if (settingsForm) {
        settingsForm.addEventListener('submit', validateForm);
    }
});