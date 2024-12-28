<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Emploi du Temps - Semaine</title>
<link rel="stylesheet" href="styles.css">
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

</tr>
</thead>
<tbody>
<?php
$hours = ["07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00"];
foreach ($hours as $hour) {
echo "<tr>";
echo "<td class='edt-cell'>$hour</td>"; // Heure affichée
// Ajout des cellules avec data-time et data-day
for ($i = 0; $i < 5; $i++) {  // 5 jours (Lundi à Vendredi)
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

document.addEventListener('DOMContentLoaded', () => {
    fetch('edt_semaine.json')  // Charger le fichier JSON
    .then(response => response.json())
    .then(events => {
        console.log(events); // Debug : afficher les événements pour vérifier leur structure

        // Trier les événements par jour de la semaine (lundi = 1, dimanche = 0)
        const daysOfWeek = [1, 2, 3, 4, 5]; // Lundi = 1, Vendredi = 5
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
                const endHour = endTime ? endTime.getHours() : null;
                const endMinute = endTime ? endTime.getMinutes() : null;
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
                        console.error(`Erreur: L'attribut 'data-time' est absent ou invalide pour la cellule`, cell);
                        return; // Si l'attribut 'data-time' est absent, ignorer cette cellule
                    }

                    const [cellHour, cellMinute] = cellTime.split(':').map(part => parseInt(part));  // Récupérer l'heure et les minutes de la cellule
                    const cellTimeInMinutes = cellHour * 60 + cellMinute;  // Convertir l'heure de la cellule en minutes

                    const eventStartInMinutes = startHour * 60 + startMinute;  // Heure de début de l'événement en minutes
                    const eventEndInMinutes = endHour * 60 + endMinute;  // Heure de fin de l'événement en minutes

                    // Vérifier si l'événement se trouve dans le bon jour
                    if (cellDay === daysOfWeek[dayIndex]) {
                        // Vérifier si l'événement doit commencer dans cette cellule
                        if (cellTimeInMinutes === eventStartInMinutes) {
                            cell.innerHTML = event.titre + "<br>" + event.lieu;
                            cell.style.backgroundColor = '#dfe';  // Changer la couleur de fond de la cellule
                        }

                        // Vérifier si l'événement dure plus d'une heure et l'afficher en plusieurs cellules
                        if (eventEndInMinutes > cellTimeInMinutes && eventStartInMinutes <= cellTimeInMinutes) {
                            cell.style.backgroundColor = '#dfe';  // Afficher l'événement dans la cellule
                            const minutesLeft = eventEndInMinutes - cellTimeInMinutes;

                            if (minutesLeft >= 60) {
                                // Étendre l'événement sur plusieurs cellules si la durée dépasse une heure
                                const nextCell = cell.nextElementSibling;
                                if (nextCell) {
                                    nextCell.style.backgroundColor = '#dfe';  // Afficher sur la cellule suivante
                                    cell.style.height = 'calc(100% * (minutesLeft / 60))';
                                }
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
