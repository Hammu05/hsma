// ---------------------------------------------------------------- TRACKING TAB


function opentracking() {
    const panel = document.getElementById('trackingPanel');
    panel.style.height = '100%'; // Expands under the horizontal navigation bar
    panel.style.width = '350px'; // Set desired width
}

function closetracking() {
    const panel = document.getElementById('trackingPanel');
    panel.style.height = '0'; // Collapses the panel
}

// -------------------------------------------- EQUIPMENT USAGE

document.getElementById("add-btn").addEventListener("click", addInput);

function addInput() {
    const container = document.getElementById("dynamic-inputs");
    const firstInputGroup = container.querySelector(".input-group");

    // Clone the first input group (the template)
    const newInputGroup = firstInputGroup.cloneNode(true);

    // Clear the input field in the cloned group (we don't want to copy the text input value)
    newInputGroup.querySelector("input").value = "";

    // Attach the remove button's click event to the cloned "x" button
    const removeBtn = newInputGroup.querySelector(".remove-btn");
    removeBtn.onclick = function () {
        removeInput(removeBtn);
    };

    // Append the cloned input group to the container
    container.appendChild(newInputGroup);
}

function removeInput(button) {
    const container = document.getElementById("dynamic-inputs");
    const inputGroup = button.parentElement;
    
    // Get all the input groups in the container
    const allInputGroups = container.querySelectorAll(".input-group");

    // Only remove the input group if there is more than one input field
    if (allInputGroups.length > 1) {
        inputGroup.remove();
    } else {
        
    }
}


// -------------------------------------- REPORT MODAL 
// Get the modal
var modal = document.getElementById("myModal");

// Get the link that opens the modal
var btn = document.getElementById("additionalReport");

// Get the <span> element that closes the modal using the class .close.report
var span = document.querySelector(".close.report");

// When the user clicks on the link, open the modal and set opacity to 1
btn.onclick = function(event) {
    event.preventDefault(); // Prevent the default link action
    modal.style.display = "flex"; // Show modal (use flex to ensure it centers properly)
    modal.style.opacity = "1"; // Set opacity to 100% to make the modal fully visible
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none"; // Hide modal
    modal.style.opacity = "0"; // Reset opacity to 0 to hide the modal smoothly
}

// When the user clicks anywhere outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none"; // Hide modal
        modal.style.opacity = "0"; // Reset opacity to 0
    }
}

// ---------------------------------------- CREATE PROJECT MODAL 

// Get elements
const createProjectButton = document.getElementById('createProjectButton');
const projectModal = document.getElementById('projectModal');
const closeModal = document.getElementById('closeModal');

// Open modal
createProjectButton.addEventListener('click', (e) => {
    e.preventDefault();
    projectModal.style.display = 'flex';
  });
  

closeModal.addEventListener('click', () => {
  projectModal.style.display = 'none';
});


// Close modal when clicking outside content
window.addEventListener('click', (e) => {
    if (e.target === projectModal) {
      projectModal.style.display = 'none';
    }
  });
  
// =================================== EDIT PROJECT MODAL 

document.addEventListener("DOMContentLoaded", function () {
    const editButton = document.getElementById('editButton');
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');

    // Show the modal when "Edit" button is clicked
    editButton.addEventListener('click', function () {
        editModal.style.display = 'block';
    });

    // Close the modal when the "X" button is clicked
    closeModal.addEventListener('click', function () {
        editModal.style.display = 'none';
    });

    // Close the modal when clicking outside of it
    window.addEventListener('click', function (event) {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

});

// ===================================== VIEW PROJECT MODAL 

document.addEventListener("DOMContentLoaded", function() {
    // Select all "View" buttons
    const viewButtons = document.querySelectorAll('.view-button');

    // Loop through each button and add an event listener
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the modal element
            const modal = document.querySelector('.modal.viewproject');
            modal.style.display = 'block'; // Show the modal
        });
    });

    // Add event listener for the close button
    const closeButton = document.querySelector('.close.viewproject');
    closeButton.addEventListener('click', function() {
        // Get the modal element
        const modal = document.querySelector('.modal.viewproject');
        modal.style.display = 'none'; // Hide the modal
    });

    // Close modal if user clicks outside of it
    window.addEventListener('click', function(e) {
        const modal = document.querySelector('.modal.viewproject');
        if (e.target === modal) {
            modal.style.display = 'none'; // Hide the modal when clicking outside
        }
    });
});
