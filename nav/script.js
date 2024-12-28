const sideNav = document.querySelector('.side-nav');
const toggleMenu = document.querySelector('.toggle-menu');
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

// Basculer la visibilité du menu sur mobile
toggleMenu.addEventListener('click', () => {
  sideNav.classList.toggle('hidden'); // Basculer la classe 'hidden' pour afficher/masquer la barre latérale
});

// Fonctionnalité de bascule des menus déroulants
dropdownToggles.forEach(toggle => {
  toggle.addEventListener('click', (e) => {
    e.preventDefault();

    const dropdown = toggle.nextElementSibling;

    // Basculer l'affichage du menu déroulant actuel
    dropdown.classList.toggle('open');
    toggle.classList.toggle('rotate');

    // Fermer les autres menus déroulants
    document.querySelectorAll('.dropdown').forEach(otherDropdown => {
      if (otherDropdown !== dropdown) {
        otherDropdown.classList.remove('open');
        otherDropdown.previousElementSibling.classList.remove('rotate');
      }
    });
  });
});
