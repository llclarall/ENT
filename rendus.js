
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
    var pinnedRendus = document.querySelectorAll('.rendu-card.pinned');

    pinnedRendus.forEach(function (rendu) {
        var container = document.querySelector('.rendus-container');
        var ajouterRenduDiv = document.getElementById('openModalBtn');
        container.insertBefore(rendu, ajouterRenduDiv.nextSibling);
    });
});



/* états rendus */

document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.rendu-card');

    elements.forEach(function(element) {
        const id = element.id.replace('rendu-', ''); // On récupère l'ID à partir de l'élément

        fetch(`get-etat.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                const etat = data.etat;

                if (etat === 'fait') {
                    element.classList.add('grise', 'termine');  // Ajout des classes après récupération de l'état
                } else {
                    element.classList.remove('grise', 'termine');
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération de l\'état:', error);
            });
    });
});

function updateEtat(id, etat) {
    const selectElement = document.getElementById(`etat-${id}`);
    const renduCard = document.getElementById(`rendu-${id}`);

    selectElement.classList.remove('a-faire', 'en-cours', 'fait');
    selectElement.classList.add(etat);

    // En fonction de l'état, on ajoute ou enlève les classes correspondantes
    if (etat === 'fait') {
        renduCard.classList.add('grise', 'termine');  // Ajouter les classes 'grise' et 'termine' lorsque l'état est 'fait'
    } else {
        renduCard.classList.remove('grise', 'termine');  // Enlever ces classes sinon
    }

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
        console.log('État mis à jour :', data);  // Confirmer la mise à jour côté serveur

        // Mettre à jour les classes après la confirmation de la mise à jour
        if (etat === 'fait') {
            renduCard.classList.add('grise', 'termine');  // Re-appliquer les classes 'grise' et 'termine'
        } else {
            renduCard.classList.remove('grise', 'termine');
        }
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
    
    const modalLink = event.target; // L'élément cliqué
    const title = modalLink.getAttribute('data-titre');
    const renduId = modalLink.getAttribute('data-id');
    const description = modalLink.getAttribute('data-description');
    const userId = modalLink.getAttribute('data-user-id');

    // Mettre à jour les éléments de la modale avec ces informations
    document.getElementById('modal-title').textContent = title;
    document.getElementById('renduId').value = renduId;
    document.getElementById('userId').value = userId;
    document.getElementById('modal-description').textContent = description;

    document.getElementById('modal-tasks').style.display = 'flex';

    // Charger les tâches spécifiques à ce rendu et utilisateur
    loadTasks(renduId, userId);
    loadFiles(renduId, userId);

    // Dynamiser l'URL pour la récupération des fichiers
    const fileListUrl = `fichiers.php?renduId=${renduId}&userId=${userId}`;
    document.getElementById('fileList').innerHTML = `<a href="${fileListUrl}" target="_blank">Voir les fichiers rendus</a>`;
}


function loadFiles(renduId, userId) {
    // Faire une requête AJAX pour récupérer les fichiers associés à ce rendu et utilisateur
    fetch(`get_files.php?renduId=${renduId}&userId=${userId}`)
        .then(response => response.json())
        .then(data => {
            const fileList = document.getElementById('file-info');
            fileList.innerHTML = '';

            if (data.files && data.files.length > 0) {
                data.files.forEach(file => {
                    const fileItem = document.createElement('li');
                    fileItem.classList.add('file-item');
                    fileItem.innerHTML = `
                        <a href="${file.chemin}" target="_blank">${file.nom}</a>
                        <a href="delete_file.php?id=${file.id}" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?');">
                            <img src="images/supprimer.png" class="delete-file-img">
                        </a>
                    `;
                    fileList.appendChild(fileItem);
                });
            } else {
                fileList.innerHTML = '<p>Aucun fichier trouvé.</p>';
            }
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des fichiers:', error);
        });
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
    const renduId = document.getElementById('renduId').value;
    const userId = document.getElementById('userId').value;
    
    if (taskValue) {
        const taskList = document.getElementById('taskList');
        const li = document.createElement('li');
        
        // Crée une case à cocher avec la tâche
        li.innerHTML = `
            <input type="checkbox" class="task-checkbox" onclick="toggleTask(this)">
            <span class="task-text">${taskValue}</span>
            <button class="delete-btn" onclick="deleteTask(this)">❌</button>
        `;

        li.querySelector('.task-text').addEventListener('click', toggleTaskByText);
        
        taskList.appendChild(li);
        taskInput.value = ''; 

        saveTasks(renduId, userId); // Sauvegarder les tâches spécifiques au rendu et à l'utilisateur
    }
}

function deleteTask(button) {
    const li = button.parentElement; 
    li.remove();
    const renduId = document.getElementById('renduId').value;
    const userId = document.getElementById('userId').value;
    saveTasks(renduId, userId);
}


// Gérer la tâche quand la case est cochée ou décochée
function toggleTask(checkbox) {
    const li = checkbox.parentElement;
    if (checkbox.checked) {
        li.classList.add('completed');
    } else {
        li.classList.remove('completed');
    }
    saveTasks(document.getElementById('renduId').value, document.getElementById('userId').value); // Sauvegarder les tâches pour ce rendu et utilisateur
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

// Sauvegarder les tâches dans le localStorage pour un rendu spécifique et un utilisateur
function saveTasks(renduId, userId) {
    const tasks = [];
    const taskListItems = document.querySelectorAll('#taskList li');
    
    taskListItems.forEach((li) => {
        const checkbox = li.querySelector('.task-checkbox');
        tasks.push({
            task: li.querySelector('.task-text').textContent.trim(),
            completed: checkbox.checked
        });
    });

    // Stockage spécifique au rendu et utilisateur
    localStorage.setItem(`tasks_rendu_${renduId}_user_${userId}`, JSON.stringify(tasks));
}

// Charger les tâches sauvegardées depuis le localStorage pour un rendu spécifique et un utilisateur
function loadTasks(renduId, userId) {
    const savedTasks = JSON.parse(localStorage.getItem(`tasks_rendu_${renduId}_user_${userId}`)) || [];
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = ''; 

    savedTasks.forEach(task => {
        const li = document.createElement('li');
        li.innerHTML = `
            <input type="checkbox" class="task-checkbox" ${task.completed ? 'checked' : ''} onclick="toggleTask(this)">
            <span class="task-text">${task.task}</span>
            <button class="delete-btn" onclick="deleteTask(this)">❌</button>
        `;
        if (task.completed) {
            li.classList.add('completed');
        }

        li.querySelector('.task-text').addEventListener('click', toggleTaskByText);

        taskList.appendChild(li);
    });

    document.getElementById('taskInput').addEventListener('keydown', checkEnter);
}

// Charger les tâches spécifiques au rendu et utilisateur quand la page est chargée
window.onload = function () {
};





/* Drag-and-drop fichiers rendu */

// Empêcher le comportement par défaut lors du glisser-déposer
function allowDrop(event) {
    event.preventDefault();
}

// Gérer le dépôt du fichier dans la zone de dépôt
function handleDrop(event) {
    event.preventDefault();
    const files = event.dataTransfer.files; 
    if (files.length > 0) {
        handleFile(files[0]); 
        document.getElementById('fileInput').files = files; 
    }
}


// Gérer la sélection d'un fichier via le bouton d'importation
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) {
        handleFile(file);
    }
}

function triggerFileInput() {
    document.getElementById('fileInput').click();
}

// Fonction pour traiter le fichier (affichage du nom de fichier)
function handleFile(file) {
    const fk_user = document.getElementById('userId').value;
    const fk_rendu = document.getElementById('renduId').value;

    if (!fk_user || !fk_rendu) {
        alert("ID utilisateur ou projet manquant. Impossible de déposer le fichier.");
        return;
    }

    const dropZone = document.getElementById('drop-zone');
    const fileInfo = document.getElementById('file-info');

    // Efface les anciens messages pour éviter les duplications
    fileInfo.textContent = `Fichier sélectionné: ${file.name}`;

    document.getElementById('renderFileButton').style.display = 'inline-block';
}


async function renderFile() {
    const fileInput = document.getElementById('fileInput');
    const file = fileInput.files[0];

    if (!file) {
        alert("Aucun fichier sélectionné.");
        return;
    }

    const fk_user = document.getElementById('userId').value;
    const fk_rendu = document.getElementById('renduId').value;

    if (!fk_user || !fk_rendu) {
        alert("ID utilisateur ou projet manquant. Impossible d'envoyer le fichier.");
        return;
    }

    // Préparer les données
    const formData = new FormData();
    formData.append('file', file);
    formData.append('fk_user', fk_user);
    formData.append('fk_rendu', fk_rendu);

    try {
        const response = await fetch('move_uploaded_file.php', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            const data = await response.json();
            if (data.success) {
                alert(`Fichier ${file.name} rendu avec succès!`);
                resetFileInput();
            } else {
                alert(data.message || "Erreur lors de l'envoi du fichier.");
            }
        } else {
            console.error(await response.text());
            alert("Erreur lors de l'envoi du fichier.");
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert("Une erreur est survenue. Veuillez réessayer.");
    }
}


// Réinitialiser le champ de fichier et le bouton après l'envoi
function resetFileInput() {
    document.getElementById('file-info').textContent = '';
    document.getElementById('renderFileButton').style.display = 'none';
    document.getElementById('fileInput').value = ''; // Réinitialise le champ de fichier
}

