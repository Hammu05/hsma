const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnlogin-popup');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', ()=> {
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-popup');
});

// =================================== TAC MODAL 
// Get elements
const termsLink = document.getElementById("termsLink");
const termsModal = document.getElementById("termsModal");
const closeModal = document.querySelector(".close.tac");

// Open modal when link is clicked
termsLink.addEventListener("click", function (e) {
    e.preventDefault(); // Prevent default link behavior
    termsModal.style.display = "block";
});

// Close modal when "x" is clicked
closeModal.addEventListener("click", function () {
    termsModal.style.display = "none";
});

// Close modal when clicking outside the modal content
window.addEventListener("click", function (e) {
    if (e.target === termsModal) {
        termsModal.style.display = "none";
    }
});
