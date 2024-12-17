const sideNav = document.querySelector('.side-nav');
const collapseButton = document.querySelector('.collapse-button');
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');


// Dropdown toggle functionality
dropdownToggles.forEach(toggle => {
  toggle.addEventListener('click', (e) => {
    e.preventDefault();

    const dropdown = toggle.nextElementSibling;

    // Toggle current dropdown
    dropdown.classList.toggle('open');
    toggle.classList.toggle('rotate');

    // Close other dropdowns
    document.querySelectorAll('.dropdown').forEach(otherDropdown => {
      if (otherDropdown !== dropdown) {
        otherDropdown.classList.remove('open');
        otherDropdown.previousElementSibling.classList.remove('rotate');
      }
    });
  });
});
