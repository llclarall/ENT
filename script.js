
/* CONNEXION CLARA*/

// Fonction pour afficher ou masquer le mot de passe
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);

    // Vérifie le type actuel de l'input
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleElement.textContent = "🙈"; 
    } else {
        passwordInput.type = "password";
        toggleElement.textContent = "👁️"; 
    }
}




/* NAV ALY*/

document.addEventListener('DOMContentLoaded', () => {
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
});




/* EDT CLARA */


// Fonction pour convertir le format "14 January 2025 à 09h30" en objet Date
function parseDate(dateString) {
const months = {
"January": 0, "February": 1, "March": 2, "April": 3, "May": 4, "June": 5,
"July": 6, "August": 7, "September": 8, "October": 9, "November": 10, "December": 11
};

const parts = dateString.split(" à ");
const dateParts = parts[0].split(" ");
const timeParts = parts[1].split("h");

const day = parseInt(dateParts[0]);
const month = months[dateParts[1]];
const year = parseInt(dateParts[2]);
const hours = parseInt(timeParts[0]);
const minutes = parseInt(timeParts[1]);

// Créer un objet Date
return new Date(year, month, day, hours, minutes);
}

document.addEventListener('DOMContentLoaded', () => {
    fetch('edt_semaine.json')  // Charger le fichier JSON
        .then(response => response.json())
        .then(events => {
            // Correspondance entre jours en français et index des jours de la semaine
            const daysMapping = {
              "monday": 0,     
              "tuesday": 1,    
              "wednesday": 2,  
              "thursday": 3,   
              "friday": 4      
          };

            // Création d'un objet pour stocker la couleur unique de chaque cours
            const courseColors = {};

            // Fonction pour générer une couleur unique stable en utilisant un hash du titre
            function generateColor(courseTitle) {
                let hash = 0;
                for (let i = 0; i < courseTitle.length; i++) {
                    hash = (hash << 5) - hash + courseTitle.charCodeAt(i);
                    hash |= 0; // Convertir en 32 bits entier
                }
                // Créer une couleur à partir du hash
                return `#${((hash >> 8) & 0x00FFFFFF).toString(16).padStart(6, '0')}`;
            }

            // Parcourir les jours de la semaine
            Object.keys(daysMapping).forEach(dayKey => {
                const dayIndex = daysMapping[dayKey];
                const dayEvents = Array.isArray(events[dayKey]) ? events[dayKey] : [events[dayKey]];

                dayEvents.forEach(event => {
                    if (!event.titre || !event.debut || !event.fin) {
                        return;  // Ignorer les événements incomplets
                    }

                    const startTime = parseDate(event.debut);
                    const endTime = parseDate(event.fin);

                    if (!startTime || !endTime) {
                        console.error('Erreur: L\'heure de début ou de fin n\'est pas valide pour l\'événement:', event);
                        return;
                    }

                    // Attribuer une couleur unique au cours s'il n'en a pas encore
                    if (!courseColors[event.titre]) {
                        courseColors[event.titre] = generateColor(event.titre);
                    }

                    const cells = document.querySelectorAll('.edt-cell');
                    let eventDisplayed = false; // Flag pour vérifier si le texte est déjà affiché

                    cells.forEach(cell => {
                        const cellTime = cell.getAttribute('data-time');  // Heure de la cellule
                        const cellDay = parseInt(cell.getAttribute('data-day'));   // Jour de la cellule (entier)

                        if (!cellTime) {
                            /* console.error(`Erreur: L'attribut 'data-time' est absent ou invalide pour la cellule`, cell); */
                            return;
                        }

                        const [cellHour, cellMinute] = cellTime.split(':').map(part => parseInt(part));  // Récupérer l'heure et les minutes de la cellule
                        const cellTimeInMinutes = cellHour * 60 + cellMinute;  // Convertir l'heure de la cellule en minutes

                        const eventStartInMinutes = startTime.getHours() * 60 + startTime.getMinutes();  // Heure de début en minutes
                        const eventEndInMinutes = endTime.getHours() * 60 + endTime.getMinutes();  // Heure de fin en minutes

                        // Vérifier si l'événement se trouve dans le bon jour
                        if (cellDay === dayIndex) {
                            // Vérifier si l'événement doit apparaître dans cette cellule
                            if (cellTimeInMinutes >= eventStartInMinutes && cellTimeInMinutes < eventEndInMinutes) {
                                // Si l'événement est dans la première cellule, afficher le texte
                                if (!eventDisplayed) {
                                    cell.innerHTML = event.titre + "<br>" + (event.lieu || "Lieu non précisé");
                                    eventDisplayed = true; // Marquer l'événement comme affiché
                                }

                                // Colorier la cellule
                                cell.style.backgroundColor = courseColors[event.titre];  // Appliquer la couleur unique
                                cell.style.color = '#000'; // Contraste pour le texte
                            }
                        }
                    });
                });
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des événements:', error);
        });
});

