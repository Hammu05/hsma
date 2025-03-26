// ---------------------------------------------------------------- EDIT PROFILE MODAL
// Get the modal and link elements
var modal = document.getElementById("editProfileModal");
var link = document.getElementById("editProfileLink");
var closeBtn = document.getElementsByClassName("close")[0];

// When the user clicks the "Edit Profile" link, open the modal
link.onclick = function(event) {
  event.preventDefault(); // Prevent default link behavior
  modal.style.display = "block";
}

// When the user clicks on the close button, close the modal
closeBtn.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

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
  // ---------------------------------------------------------------- EDIT PROFILE MODAL



  // ---------------------------------------------------------------- PHONE NUMBER VALIDATION
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
  // ---------------------------------------------------------------- PHONE NUMBER VALIDATION
