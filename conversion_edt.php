<?php
// URL de l'EDT à télécharger
$icalUrl = "https://edt.univ-eiffel.fr/jsp/custom/modules/plannings/anonymous_cal.jsp?resources=1313&projectId=26&calType=ical&nbWeeks=1";

// Chemins des fichiers sur le serveur
$icalFile = 'edt_semaine.ics'; // Chemin du fichier .ical
$jsonFile = 'edt_semaine.json'; // Chemin du fichier JSON

// Fonction pour télécharger le fichier .ical
function telechargerIcal($url, $destination) {
    $fichier = file_get_contents($url);
    if ($fichier === false) {
        die("Erreur : impossible de télécharger le fichier iCal.\n");
    }
    file_put_contents($destination, $fichier);
}

// Fonction pour convertir le fichier .ical en JSON, avec filtrage par semaine
function convertirIcalEnJson($icalPath, $jsonPath) {
    if (!file_exists($icalPath)) {
        die("Erreur : fichier iCal introuvable.\n");
    }

    // Lire le contenu du fichier .ical
    $icalData = file_get_contents($icalPath);

    // Calculer le début et la fin de la semaine à venir
    $semaineProchaine = getSemaineProchaine();
    $debutSemaine = $semaineProchaine['debut'];
    $finSemaine = $semaineProchaine['fin'];

    // Extraire les événements
    foreach (explode("BEGIN:VEVENT", $icalData) as $event) {
        if (strpos($event, "SUMMARY") !== false) {
            preg_match('/SUMMARY:(.+)/', $event, $summary);
            preg_match('/DTSTART:(\d+T\d+Z)/', $event, $start);
            preg_match('/DTEND:(\d+T\d+Z)/', $event, $end);
            preg_match('/LOCATION:(.+)/', $event, $location);

            // Convertir les dates au format lisible
            $debut = convertirDateLisible($start[1] ?? null);
            $fin = convertirDateLisible($end[1] ?? null);

            // Vérifier si l'événement est dans la semaine à venir
            $eventStartDate = DateTime::createFromFormat('Ymd\THis\Z', $start[1]);
            if ($eventStartDate >= $debutSemaine && $eventStartDate <= $finSemaine) {
                // Ajouter l'événement au bon jour de la semaine
                $jourSemaine = strtolower($eventStartDate->format('l')); // 'l' donne le nom du jour en anglais
                $joursSemaine[$jourSemaine][] = [
                    "titre" => trim($summary[1] ?? 'Sans titre'),
                    "debut" => $debut,
                    "fin" => $fin,
                    "lieu" => trim($location[1] ?? 'Non spécifié')
                ];
            }
        }
    }

    // Ajouter un objet vide pour chaque jour sans événement
    foreach ($joursSemaine as $jour => $events) {
        if (empty($events)) {
            $joursSemaine[$jour] = [
                "titre" => "",
                "debut" => "",
                "fin" => "",
                "lieu" => ""
            ];
        }
    }

    // Sauvegarder les événements au format JSON
    file_put_contents($jsonPath, json_encode($joursSemaine, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Fichier JSON généré : $jsonPath\n";
}

// Fonction pour convertir une date iCal en format lisible
function convertirDateLisible($icalDate) {
    if ($icalDate === null) return "Date inconnue";

    // Format attendu : YYYYMMDDTHHMMSSZ
    $format = 'Ymd\THis\Z';

    // Conversion de la date iCal en objet DateTime
    $date = DateTime::createFromFormat($format, $icalDate);

    // Vérifier si la conversion a réussi
    if (!$date) {
        return "Date invalide : $icalDate";
    }

    // Ajuster au fuseau horaire local
    $date->setTimezone(new DateTimeZone(date_default_timezone_get()));

    // Retourner la date formatée en "jour mois année à heurehminute"
    return $date->format('j F Y \à H\hi');
}

// Fonction pour obtenir le début et la fin de la semaine à venir
function getSemaineProchaine() {
    $aujourdHui = new DateTime();
    $aujourdHui->modify('next monday'); // Aller au lundi suivant

    // Début de la semaine (lundi)
    $debutSemaine = clone $aujourdHui;
    $debutSemaine->setTime(0, 0, 0); // Réinitialiser l'heure à minuit

    // Fin de la semaine (dimanche)
    $finSemaine = clone $debutSemaine;
    $finSemaine->modify('sunday');
    $finSemaine->setTime(23, 59, 59); // Réinitialiser l'heure à 23h59

    return ['debut' => $debutSemaine, 'fin' => $finSemaine];
}

// Étapes du script
try {
    // Télécharger le fichier iCal
    echo "Téléchargement du fichier iCal...\n";
    telechargerIcal($icalUrl, $icalFile);

    // Convertir le fichier iCal en JSON
    echo "Conversion en JSON...\n";
    convertirIcalEnJson($icalFile, $jsonFile);

    echo "Processus terminé avec succès.\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
?>
