document.addEventListener("DOMContentLoaded", function() {
    // Select all "View Details" buttons
    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');

    // Loop through each button and add an event listener
    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Get the modal ID from the button's data-modal attribute
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            // Show the modal
            modal.style.display = 'block';
        });
    });

    // Add event listeners for the close buttons inside the modals
    const closeButtons = document.querySelectorAll('.close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = document.getElementById(this.getAttribute('data-modal'));
            modal.style.display = 'none';
        });
    });

    // Close modal if user clicks outside of it
    window.addEventListener('click', function(e) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});



document.querySelector('.submit-btn').addEventListener('click', (event) => {
    event.preventDefault(); // Prevent form submission if used within a form.

    let total = 0;

    // Select all inputs related to Structural, Civil, Electrical, etc.
    const inputFields = document.querySelectorAll('.modal-sections input[type="number"]');
    inputFields.forEach(input => {
        const value = parseFloat(input.value) || 0; // Parse the input value or use 0 if empty
        total += value;
    });

    // Display the total amount
    document.getElementById('totalAmount').textContent = total.toFixed(2);
});


//----------------------------------------- SUM OF INPUTS

document.addEventListener('DOMContentLoaded', () => {
  // Function to calculate the total dynamically
  function calculateTotal() {
      const inputs = document.querySelectorAll('.sum-input');
      let total = 0;

      inputs.forEach(input => {
          const value = parseFloat(input.value);
          if (!isNaN(value)) {
              total += value;
          }
      });

      // Update the total amount in the DOM
      document.getElementById('totalAmount').textContent = total.toFixed(2);
  }

  // Restrict input to numbers and a single decimal
  function restrictToNumbers(event) {
      const input = event.target;
      let value = input.value;

      // Remove invalid characters and limit to one decimal point
      value = value.replace(/[^0-9.]/g, '');
      const decimalCount = (value.match(/\./g) || []).length;
      if (decimalCount > 1) {
          value = value.substring(0, value.lastIndexOf('.'));
      }

      input.value = value;
  }

  // Attach event listeners to all `.sum-input` fields
  document.querySelectorAll('.sum-input').forEach(input => {
      input.addEventListener('input', restrictToNumbers); // Sanitize input
      input.addEventListener('input', calculateTotal);    // Update total dynamically
  });
});

