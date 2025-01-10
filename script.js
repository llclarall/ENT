
/* CONNEXION CLARA*/

// Fonction pour afficher ou masquer le mot de passe
function togglePassword(inputId, toggleElement) {
    const passwordInput = document.getElementById(inputId);

    // Vérifie le type actuel de l'input
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleElement.innerHTML = "<i class='fa-regular fa-eye'></i>"; 
    } else {
        passwordInput.type = "password";
        toggleElement.innerHTML = "<i class='fa-regular fa-eye-slash'></i>"; 
    }
}




/* NAV ALY */

document.addEventListener('DOMContentLoaded', () => {
    const sideNav = document.querySelector('.side-nav');
    const toggleMenu = document.querySelector('.toggle-menu');
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    // Basculer la visibilité du menu sur mobile
    toggleMenu.addEventListener('click', () => {
        sideNav.classList.toggle('hidden');
    });

    // Initialisation : Ouvrir les dropdowns contenant un enfant actif
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        const activeChild = dropdown.querySelector('.active');
        if (activeChild) {
            dropdown.classList.add('open');
            dropdown.previousElementSibling.classList.add('rotate');
            dropdown.previousElementSibling.setAttribute('aria-expanded', 'true');
        }
    });

    // Fonctionnalité de bascule des menus déroulants
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();

            const dropdown = toggle.nextElementSibling;

            // Basculer l'affichage du menu déroulant actuel
            dropdown.classList.toggle('open');
            toggle.classList.toggle('rotate');

            const isExpanded = toggle.classList.contains('rotate');
            toggle.setAttribute('aria-expanded', isExpanded);

            // Fermer les autres menus déroulants sauf ceux avec un enfant actif
            document.querySelectorAll('.dropdown').forEach(otherDropdown => {
                if (otherDropdown !== dropdown) {
                    const hasActiveChild = otherDropdown.querySelector('.active');
                    if (!hasActiveChild) {
                        otherDropdown.classList.remove('open');
                        otherDropdown.previousElementSibling.classList.remove('rotate');
                        otherDropdown.previousElementSibling.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        });
    });

    // Fermer la barre latérale si un clic est effectué en dehors
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 1130) {
            if (!sideNav.contains(e.target) && !toggleMenu.contains(e.target)) {
                sideNav.classList.remove('hidden');
            }
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
                                cell.style.backgroundColor = courseColors[event.titre];  
                                cell.style.color = '#000'; 
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





/* NOUVEAU MESSAGE (destinataires) CLARA */

document.addEventListener("DOMContentLoaded", function () {
    const inputDestinataire = document.getElementById("destinataire-input");
    const suggestionsList = document.getElementById("suggestions-list");
    const hiddenDestinataireId = document.getElementById("destinataire-id");

    inputDestinataire.addEventListener("input", function () {
        const query = inputDestinataire.value.trim();

        if (query.length > 1) {
            fetch(`search_destinataire.php?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsList.innerHTML = "";

                    data.forEach(user => {
                        const li = document.createElement("li");
                        li.textContent = `${user.prenom} ${user.nom}`;
                        li.dataset.id = user.id; // Stocker l'ID dans l'élément
                        li.classList.add("suggestion-item");

                        li.addEventListener("click", function () {
                            inputDestinataire.value = `${user.prenom} ${user.nom}`;
                            hiddenDestinataireId.value = user.id;
                            suggestionsList.innerHTML = ""; // Effacer les suggestions après la sélection
                        });

                        suggestionsList.appendChild(li);
                    });
                });
        } else {
            suggestionsList.innerHTML = ""; // Vider si saisie trop courte
        }
    });

    // Cacher les suggestions si on clique ailleurs
    document.addEventListener("click", function (e) {
        if (!suggestionsList.contains(e.target) && e.target !== inputDestinataire) {
            suggestionsList.innerHTML = "";
        }
    });
});




// Fonction pour supprimer un message
function deleteMessage(messageId, event) {
    event.preventDefault();  // Empêche l'action par défaut
    if (confirm("Voulez-vous vraiment supprimer ce message ?")) {
        window.location.href = 'delete_msg.php?id=' + messageId;
    }
}

// Fonction pour archiver ou désarchiver un message
function archiveMessage(messageId, isArchived, event) {
    event.preventDefault();

    // Message à afficher en fonction de l'état actuel du message
    const action = isArchived === 1 ? "désarchiver" : "archiver";
    if (confirm(`Voulez-vous vraiment ${action} ce message ?`)) {
        window.location.href = 'archive_msg.php?id=' + messageId + '&new_status=' + (isArchived === 1 ? 0 : 1);
    }
}




/* NOTES CLARA */

/* dropdown semestre */
document.getElementById('semester').addEventListener('change', function() {
    this.form.submit();
});








