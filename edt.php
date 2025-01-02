<?php 
include 'nav.php';
include 'config.php';
include 'header.php';


// Calculer la date du lundi de la semaine actuelle
$currentDate = new DateTime();
$currentDate->modify('this week');

// Calculer la date du vendredi de la même semaine
$endDate = clone $currentDate;
$endDate->modify('friday');


// Liste des mois en français
$moisFrancais = [
    1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin',
    7 => 'juillet', 8 => 'août', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
];

$joursSemaine = [
    'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'
];

$datesSemaine = [];

// Calculer la date de chaque jour de la semaine
for ($i = 0; $i < 5; $i++) {
    $jour = clone $currentDate;
    $jour->modify("+$i day");
    $datesSemaine[] = $jour->format('d');  // On garde uniquement le jour (numéro du jour)
}

// Extraire le mois en français et l'ajouter au format de la date
$startDate = $currentDate->format('d') . ' ' . $moisFrancais[(int)$currentDate->format('m')] . ' ' . $currentDate->format('Y');
$endDateFormatted = $endDate->format('d') . ' ' . $moisFrancais[(int)$endDate->format('m')] . ' ' . $endDate->format('Y');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Emploi du Temps - Semaine</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>


<section class="page-edt">
    
<h1>Emploi du Temps</h1>

<!-- Affichage dynamique des dates de début et de fin de semaine -->
<h2>Semaine du <?php echo $startDate; ?> au <?php echo $endDateFormatted; ?></h2>

    <table id="edt-container" class="edt-container">
    <thead>
        <tr id="edt-header" class="edt-header">
            <th class="edt-day"></th>
            <th class="edt-day">Lundi <?php echo $datesSemaine[0]; ?></th>
            <th class="edt-day">Mardi <?php echo $datesSemaine[1]; ?></th>
            <th class="edt-day">Mercredi <?php echo $datesSemaine[2]; ?></th>
            <th class="edt-day">Jeudi <?php echo $datesSemaine[3]; ?></th>
            <th class="edt-day">Vendredi <?php echo $datesSemaine[4]; ?></th>
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
</section>



<script src="script.js"></script>
</body>
</html>
