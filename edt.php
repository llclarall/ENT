<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Emploi du Temps - Semaine</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Emploi du Temps</h1>

<table id="edt-container">
<thead>
<tr id="edt-header">
<th class="edt-day"></th>
<th class="edt-day">Lundi</th>
<th class="edt-day">Mardi</th>
<th class="edt-day">Mercredi</th>
<th class="edt-day">Jeudi</th>
<th class="edt-day">Vendredi</th>
<th class="edt-day">Samedi</th>
<th class="edt-day">Dimanche</th>
</tr>
</thead>
<tbody>
<?php
$hours = ["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00"];
foreach ($hours as $hour) {
echo "<tr>";
echo "<td class='edt-cell'>$hour</td>"; // Heure affichée
// Ajout des cellules avec data-time et data-day
for ($i = 0; $i < 7; $i++) {
echo "<td class='edt-cell' data-time='$hour' data-day='$i'></td>";
}
echo "</tr>";
}
?>
</tbody>
</table>

<script>
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

// Fonction pour ajouter les événements dans les bonnes cellules
document.addEventListener('DOMContentLoaded', () => {
    fetch('edt_semaine.json')  // Charger le fichier JSON
    .then(response => response.json())
    .then(events => {
        console.log(events); // Debug : afficher les événements pour vérifier leur structure

        // Trier les événements par jour de la semaine (lundi = 1, dimanche = 0)
        const daysOfWeek = [1, 2, 3, 4, 5, 6, 0]; // Lundi = 1, Dimanche = 0
        const sortedEvents = daysOfWeek.map(day => {
            return events.filter(event => {
                const eventDay = parseDate(event.debut).getDay();
                return eventDay === day;
            }).sort((a, b) => {
                const timeA = parseDate(a.debut);
                const timeB = parseDate(b.debut);
                return timeA - timeB; // Trie par heure de début
            });
        });

        console.log(sortedEvents); // Debug : afficher les événements triés pour chaque jour

        // Insérer les événements triés dans le tableau
        sortedEvents.forEach((dayEvents, dayIndex) => {
            dayEvents.forEach(event => {
                const startTime = parseDate(event.debut);
                const endTime = parseDate(event.fin);
                const startHour = startTime ? startTime.getHours() : null;  // Vérifier si startTime est défini
                const startMinute = startTime ? startTime.getMinutes() : null;
                const duration = startTime && endTime ? (endTime - startTime) / (1000 * 60) : 0; // Durée en minutes
                const cells = document.querySelectorAll('.edt-cell');

                if (!startTime || !endTime) {
                    console.error('Erreur: L\'heure de début ou de fin n\'est pas valide pour l\'événement:', event);
                    return;  // Si startTime ou endTime n'est pas valide, on passe à l'événement suivant
                }

                cells.forEach(cell => {
                    const cellTime = cell.getAttribute('data-time');  // Heure de la cellule
                    const cellDay = parseInt(cell.getAttribute('data-day'));   // Jour de la cellule (entier)

                    if (!cellTime) {
                        console.error('Erreur: L\'heure de la cellule est invalide');
                        return; // Si cellTime est invalide, on ignore cette cellule
                    }

                    // Comparer uniquement les heures (ignorer les minutes)
                    const cellHour = parseInt(cellTime.split(':')[0]);  // Récupérer l'heure de la cellule
                    if (cellHour === startHour && cellDay === daysOfWeek[dayIndex]) {
                        // Ajouter l'événement dans la cellule de début
                        cell.innerHTML = `${event.titre} <br> ${event.lieu}`;
                        cell.style.backgroundColor = '#dfe';  // Changer la couleur de fond de la cellule

                        // Fusionner les cellules suivantes si l'événement dure plus longtemps
                        const durationInHours = duration / 60; // Convertir la durée en heures
                        for (let i = 1; i < durationInHours; i++) {
                            const nextHour = startHour + i;  // Heure suivante
                            const nextCell = document.querySelector(`.edt-cell[data-time='${nextHour}:00'][data-day='${cellDay}']`);
                            if (nextCell) {
                                nextCell.innerHTML = '';  // Ne rien afficher dans la cellule suivante
                                nextCell.style.backgroundColor = '#dfe';  // Garder la même couleur de fond
                                nextCell.setAttribute('colspan', 1);  // La cellule ne doit plus être fusionnée avec la suivante

                                // Si c'est la cellule suivante, on met à jour la cellule de départ pour fusionner
                                const rowspanValue = durationInHours;  // La cellule de départ va couvrir toute la durée
                                cell.setAttribute('rowspan', rowspanValue);  // Fusionner avec les cellules suivantes
                            }
                        }
                    }
                });
            });
        });
    })
    .catch(error => {
        console.error('Erreur lors du chargement des événements:', error);
    }); // Gérer les erreurs de chargement des événements
});



</script>

<script src="script.js"></script>
</body>
</html>
