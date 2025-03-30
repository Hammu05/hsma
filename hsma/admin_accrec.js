document.addEventListener("DOMContentLoaded", function () {
    var addManagerModal = document.getElementById("addManagerModal");
    var addManagerButton = document.getElementById("addManagerButton");
    var closeAddManagerModal = document.getElementById("closeAddManagerModal");
  
    addManagerButton.onclick = function () {
        addManagerModal.style.display = "block";
    };
  
    closeAddManagerModal.onclick = function () {
        addManagerModal.style.display = "none";
    };
  
    window.onclick = function (event) {
        if (event.target == addManagerModal) {
            addManagerModal.style.display = "none";
        }
    };
  });
  
  function togglePassword(inputId, button) {
    const inputField = document.getElementById(inputId); // Get the input field by its ID
  
    if (inputField.type === 'password') {
      inputField.type = 'text'; // Show the password
      button.textContent = 'Hide'; // Update button text
    } else {
      inputField.type = 'password'; // Hide the password
      button.textContent = 'Show'; // Update button text
    }
  }
  