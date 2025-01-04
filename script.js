
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
  
    // Assurez-vous que la barre latérale est visible lorsque la fenêtre dépasse 1130px
    window.addEventListener('resize', () => {
      if (window.innerWidth > 1130) {
        sideNav.classList.remove('hidden');
      }
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





/* RENDUS CLARA */

/* modale */
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    
    // Ouvrir la modale lorsque l'on clique sur le bouton "Ajouter un rendu"
    openModalBtn.addEventListener('click', () => {
        modal.style.display = 'flex'; // Afficher la modale
    });

    // Fermer la modale lorsque l'on clique sur le bouton de fermeture
    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none'; // Cacher la modale
    });

    // Fermer la modale si l'on clique en dehors de la fenêtre modale
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});


// Fonction pour pin un rendu
function pinRendu(renduId) {
    var renduElement = document.getElementById("rendu-" + renduId);
    var container = document.querySelector('.rendus-container');
    var ajouterRenduDiv = document.getElementById('openModalBtn'); // La div ajouter-rendu

    if (renduElement.classList.contains("pinned")) {
        // Si l'élément est déjà épinglé, le dé-pincer
        renduElement.classList.remove("pinned");
        
        // Réorganiser l'élément pour le remettre à sa place dans la grille
        container.appendChild(renduElement);

        // Envoyer la requête pour désépingler
        fetch('pin_rendu.php', {
            method: 'POST',
            body: JSON.stringify({ id: renduId, pinned: 0 }),
            headers: { 'Content-Type': 'application/json' }
        });

    } else {
        // Si l'élément n'est pas épinglé, l'épingler
        renduElement.classList.add("pinned");
        
        // Déplacer l'élément épinglé juste après la div ajouter-rendu
        container.insertBefore(renduElement, ajouterRenduDiv.nextSibling);

        // Envoyer la requête pour épingler
        fetch('pin_rendu.php', {
            method: 'POST',
            body: JSON.stringify({ id: renduId, pinned: 1 }),
            headers: { 'Content-Type': 'application/json' }
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {
    // Récupérer tous les rendus avec la classe 'pinned'
    var pinnedRendus = document.querySelectorAll('.rendu-card.pinned');
    
    pinnedRendus.forEach(function(rendu) {
        // Déplacer les rendus épinglés juste après la div 'ajouter-rendu'
        var container = document.querySelector('.rendus-container');
        var ajouterRenduDiv = document.getElementById('openModalBtn'); // Div ajouter-rendu
        container.insertBefore(rendu, ajouterRenduDiv.nextSibling);  // Déplacer après la div
    });
});






    // Afficher une notification
/*     var notification = document.createElement("div");
    notification.className = "notification";
    notification.textContent = "Rendu épinglé !";
    document.body.appendChild(notification);
     */

