// Get all "View Details" buttons
const viewDetailsButtons = document.querySelectorAll('.view-details');

// Get all modals
const modals = document.querySelectorAll('.modal.trackingViewDeatils');

// Get all close buttons
const closeButtons = document.querySelectorAll('.close.trackingViewDeatils');

// Open modal when the button is clicked
viewDetailsButtons.forEach((button) => {
    button.addEventListener('click', function () {
        const modalId = `modal${this.id.replace('trackingViewDetails', '')}`; // Create modal ID dynamically
        const modal = document.getElementById(modalId);
        modal.style.display = 'block';
    });
});

// Close modals when close button is clicked
closeButtons.forEach((button) => {
    button.addEventListener('click', function () {
        this.closest('.modal').style.display = 'none';
    });
});

// Close modals when clicking outside the modal content
window.addEventListener('click', function (e) {
    modals.forEach((modal) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
