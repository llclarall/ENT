
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



/* états rendus */

function updateEtat(id, etat) {
    const selectElement = document.getElementById(`etat-${id}`);

    // Change la classe CSS du select en fonction de l'état choisi
    selectElement.classList.remove('a-faire', 'en-cours', 'fait');
    selectElement.classList.add(`${etat}`);

    // Envoyer la mise à jour de l'état au serveur
    const formData = new FormData();
    formData.append('id', id);
    formData.append('etat', etat);

    fetch('update-etat.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la mise à jour');
            }
            return response.text();
        })
        .then(data => {
            console.log('État mis à jour :', data); // Debug
        })
        .catch(error => {
            console.error('Erreur :', error);
            alert('Une erreur est survenue.');
        });
}



/* Modale ajout tâches */

// Ouvrir la modale
function openModal(event) {
    event.preventDefault(); 
    document.getElementById('modal-tasks').style.display = 'flex';
}

// Fermer la modale
function closeModal(event) {
    if (event && event.target === document.getElementById('modal-tasks')) {
        document.getElementById('modal-tasks').style.display = 'none';
    }
}

// Ajouter une tâche
function addTask() {
    const taskInput = document.getElementById('taskInput');
    const taskValue = taskInput.value.trim();
    
    if (taskValue) {
        const taskList = document.getElementById('taskList');
        const li = document.createElement('li');
        
        // Crée une case à cocher avec la tâche
        li.innerHTML = `<input type="checkbox" class="task-checkbox" onclick="toggleTask(this)"> <span class="task-text">${taskValue}</span>`;

        // Ajoute un gestionnaire de clic uniquement sur le texte de la tâche (pas sur la case à cocher)
        li.querySelector('.task-text').addEventListener('click', toggleTaskByText);
        
        taskList.appendChild(li);
        taskInput.value = ''; 
        saveTasks(); // Sauvegarde les tâches
    }
}

// Gérer la tâche quand la case est cochée ou décochée
function toggleTask(checkbox) {
    const li = checkbox.parentElement;
    if (checkbox.checked) {
        li.classList.add('completed');
    } else {
        li.classList.remove('completed');
    }
    saveTasks(); // Sauvegarde après modification
}

// Gérer le clic sur le texte de la tâche pour cocher/décocher la case
function toggleTaskByText(event) {
    const li = event.target.parentElement; 
    const checkbox = li.querySelector('.task-checkbox');
    checkbox.checked = !checkbox.checked;
    toggleTask(checkbox); 
}

// Vérifier si l'utilisateur appuie sur 'Enter'
function checkEnter(event) {
    if (event.key === 'Enter') {
        addTask();
    }
}

// Sauvegarder les tâches dans le localStorage
function saveTasks() {
    const tasks = [];
    const taskListItems = document.querySelectorAll('#taskList li');
    
    taskListItems.forEach((li) => {
        const checkbox = li.querySelector('.task-checkbox');
        tasks.push({
            task: li.querySelector('.task-text').textContent.trim(),
            completed: checkbox.checked
        });
    });

    localStorage.setItem('tasks', JSON.stringify(tasks));
}

// Charger les tâches sauvegardées depuis le localStorage
window.onload = function () {
    const savedTasks = JSON.parse(localStorage.getItem('tasks')) || [];
    const taskList = document.getElementById('taskList');
    
    savedTasks.forEach(task => {
        const li = document.createElement('li');
        li.innerHTML = `<input type="checkbox" class="task-checkbox" ${task.completed ? 'checked' : ''} onclick="toggleTask(this)"> <span class="task-text">${task.task}</span>`;
        if (task.completed) {
            li.classList.add('completed');
        }
        taskList.appendChild(li);
    });

    // Ajouter l'écouteur d'événement pour 'Enter' au champ de saisie
    document.getElementById('taskInput').addEventListener('keydown', checkEnter);
};




/* drag-and-drop fichiers rendu */
// Empêcher le comportement par défaut lors du glisser-déposer
function allowDrop(event) {
    event.preventDefault();
}

// Gérer le dépôt du fichier dans la zone de dépôt
function handleDrop(event) {
    event.preventDefault();
    const file = event.dataTransfer.files[0];
    if (file) {
        handleFile(file);
    }
}

// Gérer la sélection d'un fichier via le bouton d'importation
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        handleFile(file);
    }
}

// Gérer le clic sur la zone de dépôt pour déclencher la sélection de fichier
function triggerFileInput() {
    document.getElementById('fileInput').click();
}

// Fonction pour traiter le fichier (affichage du nom de fichier)
function handleFile(file) {
    const dropZone = document.getElementById('drop-zone');
    const fileName = document.createElement('p');
    fileName.textContent = `Fichier sélectionné: ${file.name}`;
    dropZone.appendChild(fileName);

    // Affiche le bouton "Rendre le fichier"
    document.getElementById('renderFileButton').style.display = 'inline-block';
}

// Fonction pour rendre le fichier (envoyer le fichier au serveur)
async function renderFile() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0]; // Récupère le fichier sélectionné
    
    if (!file) {
        alert("Aucun fichier sélectionné.");
        return;
    }

    // Récupérer les ID de l'utilisateur et du rendu
    const fk_user = document.getElementById('userId').value; // ID de l'utilisateur
    const fk_rendu = document.getElementById('renduId').value; // ID du rendu

    if (!fk_user || !fk_rendu) {
        alert("ID utilisateur ou rendu manquant.");
        return;
    }

    // Prépare les données du formulaire (fichier et autres informations, si nécessaire)
    const formData = new FormData();
    formData.append('file', file);
    formData.append('fk_user', fk_user); // Ajouter l'ID utilisateur
    formData.append('fk_rendu', fk_rendu); // Ajouter l'ID du rendu
    formData.append('taskTitle', document.querySelector('#taskInput').value); // Ajouter des informations supplémentaires si nécessaire

try {
// Envoi du fichier au serveur via POST
const response = await fetch('/upload', {
    method: 'POST',
    body: formData
});

// Vérification de la réponse du serveur
if (response.ok) {
    const data = await response.json(); // Réponse du serveur
    console.log(data); // Ajoutez ceci pour afficher la réponse complète
    if (data.success) {
        alert(`Fichier ${file.name} rendu avec succès!`);
        resetFileInput();
    } else {
        alert("Erreur lors de l'envoi du fichier.");
    }
} else {
    alert("Erreur lors de l'envoi du fichier.");
    console.log(await response.text()); // Afficher le message d'erreur du serveur
}

    } catch (error) {
        console.error('Erreur lors de l\'envoi du fichier:', error);
        alert("Erreur lors de l'envoi du fichier.");
    }
}

// Réinitialiser le champ de fichier et le bouton après l'envoi
function resetFileInput() {
    document.getElementById('file-info').textContent = '';
    document.getElementById('renderFileButton').style.display = 'none';
    document.getElementById('fileInput').value = ''; // Réinitialise le champ de fichier
}
