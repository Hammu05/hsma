// Get the "Edit Profile" link and the modal
const editProfileLink = document.getElementById("editProfileLink");
const editProfileModal = document.getElementById("editProfileModal");

// Get the close button (X)
const closeProfileSpan = document.querySelector(".close.editProf");

// Show the modal when the "Edit Profile" link is clicked
editProfileLink.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent default link behavior
    editProfileModal.style.display = "block"; // Display the modal
});

// Close the modal when the close button (X) is clicked
closeProfileSpan.addEventListener("click", () => {
    editProfileModal.style.display = "none"; // Hide the modal
});

// Close the modal when clicking outside the modal content
window.addEventListener("click", (event) => {
    if (event.target === editProfileModal) {
        editProfileModal.style.display = "none"; // Hide the modal
    }
});


function togglePassword(inputId) {
    const inputField = document.getElementById(inputId);
    const button = inputField.nextElementSibling; // Get the button next to the input field
    
    if (inputField.type === 'password') {
      inputField.type = 'text'; // Show the password
      button.textContent = 'Hide'; // Change button text to 'Hide'
    } else {
      inputField.type = 'password'; // Hide the password
      button.textContent = 'Show'; // Change button text to 'Show'
    }
  }


function validatePhoneNumber(input) {
    const phoneError = document.getElementById("phoneError");

    // Remove any non-digit characters
    input.value = input.value.replace(/\D/g, "");

    // Show error message if the length is not 11
    if (input.value.length !== 11 && input.value.length > 0) {
        phoneError.style.display = "block";
    } else {
        phoneError.style.display = "none";
    }
}

function submitQuotation() {
    // Show the confirm dialog
    const userConfirmed = confirm("Please check your inputs before submitting.");
    
    // Redirect to the confirmation page if the user clicks "OK"
    if (userConfirmed) {
        window.location.href = "#";
    }
}