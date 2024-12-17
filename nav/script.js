// Toggle the collapse state for the sidebar
const sideNav = document.querySelector('.side-nav');
const collapseButton = document.querySelector('.collapse-button');

collapseButton.addEventListener('click', () => {
  // Toggle the collapsed state
  sideNav.classList.toggle('collapsed');

  // If the nav is collapsed, close any open dropdowns
  if (sideNav.classList.contains('collapsed')) {
    document.querySelectorAll('.dropdown.open').forEach((openDropdown) => {
      openDropdown.classList.remove('open');
    });
  }
});

// Handle dropdown menu toggle when clicked
document.querySelectorAll('.dropdown-toggle').forEach((toggle) => {
  toggle.addEventListener('click', function (event) {
    // Prevent default anchor link behavior
    event.preventDefault();

    // Only toggle the dropdown if the side nav is expanded
    if (!sideNav.classList.contains('collapsed')) {
      const dropdown = this.nextElementSibling;

      // Toggle the dropdown menu open/close
      if (dropdown.classList.contains('open')) {
        dropdown.classList.remove('open');
      } else {
        // Close all other open dropdowns
        document.querySelectorAll('.dropdown.open').forEach((openDropdown) => {
          openDropdown.classList.remove('open');
        });
        dropdown.classList.add('open');
      }
    } else {
      // If the nav is collapsed, we expand the nav and show the dropdown
      sideNav.classList.remove('collapsed'); // Expand the nav
      const dropdown = this.nextElementSibling;

      // Show the dropdown menu
      document.querySelectorAll('.dropdown.open').forEach((openDropdown) => {
        openDropdown.classList.remove('open');
      });
      dropdown.classList.add('open');
    }
  });
});
