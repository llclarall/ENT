<?php 
include('header.php');
include('nav.php');



// Récupérer les rendus associés à l'utilisateur ou non assignés à personne, triés par priorité (épinglés) et date
$query = "SELECT r.*, 
           CASE WHEN p.fk_user IS NOT NULL THEN 1 ELSE 0 END AS pinned
    FROM rendus r
    LEFT JOIN pins p ON r.id = p.fk_rendu AND p.fk_user = :user_id
    WHERE r.fk_user = :fk_user OR r.fk_user IS NULL
    ORDER BY pinned DESC, r.date ASC";

$stmt = $db->prepare($query);
$stmt->bindParam(':fk_user', $id); // ID de l'utilisateur associé au rendu
$stmt->bindParam(':user_id', $id); // ID de l'utilisateur connecté pour les épinglages
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Accueil</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    
<section class="accueil">
    
    <h1>Bienvenue <?php echo $user['prenom']; ?> !</h1>
    
    
    <div class="container">


        <!-- Applications avec 3 sous-blocs -->
        <div class="applications">
            <h2>Applications</h2>
            <div class="flex-container">
                <a href="elearning.php" class="widget sub-block elearning">
                        <img src="images/elearning2.png" alt="">Elearning
                </a>
                <a href="archives.php" class="widget sub-block archives">
                        <img src="images/archives.png" alt="">Archives
                </a>
                <a href="edt.php" class="widget sub-block">
                        <img src="images/edt.png" alt="">Emploi du temps
                </a>
            </div>
        </div>


        <!-- Réservations avec 3 sous-blocs -->
        <div class="notifs">
            <!-- <h2>Notifications</h2> -->
            <div class="flex-container">
                <div class="absences">
                    <h3><i class="fa-solid fa-ghost"></i> Absences</h3>
                    <a href="absences.php">
                        <div class="widget sub-block">
                            <span class="big">8h</span> <br>
                            <span>à justifier</span>
                        </div>
                    </a>
                </div>
                <div class="notes">
                    <h3><i class="fa-solid fa-heart"></i> Notes</h3>
                    <a href="notes.php">
                        <div class="widget sub-block">
                            <span class="big">3+</span> <br>
                            <span>notes</span>
                        </div>
                    </a>
                </div>
                <div class="reservations">
                    <h3><i class="fa-solid fa-bookmark"></i> RSVP</h3>
                    <a href="reservations.php">
                        <div class="widget sub-block">
                            <span class="big">1</span> <br>
                            <span>réservation</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    

        <!-- Derniers messages -->
        <a href="messagerie.php">
            <div class="widget messages">
                <h2>Derniers messages</h2><hr>
                <p>Le prochain QCM se...</p>
                <p>Gaëlle Charpentier | 12/11</p>
            </div>
        </a>


        <!-- Menu -->
        <div class="widget menu">
            <h2>Menu du jour</h2> <hr>
            <p><strong>Entrées :</strong> Oeufs mayonnaise, Taboulet</p>
            <p><strong>Plats :</strong> Poulet braisé, Poisson pané</p>
            <p><strong>Desserts :</strong> Tiramisu, Tarte aux pommes</p>
        </div>


        <!-- Rendus -->
        <div class="rendus widget">
        <h2>Prochains rendus</h2>
    <hr>

    <?php 
$count = 0; // Compteur pour limiter l'affichage
$maxRendus = 3;

foreach ($rendus as $rendu) {
    if ($count >= $maxRendus) break; // Limiter à 3 rendus maximum

    // Vérifier si le rendu est épinglé pour l'utilisateur connecté
    if ($rendu['pinned'] == 1) {
        echo "<a href='rendus.php' class='rendu-pinned'>
                <p class='pinned rendu'>
                    <strong>" . htmlspecialchars($rendu['titre']) . "</strong> le " . date('d/m', strtotime($rendu['date'])) . "
                </p>
                <img src='images/pin.png' alt='Rendu épinglé' class='pin-icon' title='Rendu épinglé'>
              </a>";
    } else {
        echo "<a href='rendus.php'>
                <p class='rendu'>
                    <strong>" . htmlspecialchars($rendu['titre']) . "</strong> le " . date('d/m', strtotime($rendu['date'])) . "
                </p>
              </a>";
    }

    $count++;
}

// Si aucun rendu n'est épinglé et qu'il en reste, afficher les rendus les plus proches
if ($count == 0 && count($rendus) > 0) {
    $remaining = array_slice($rendus, 0, $maxRendus);
    foreach ($remaining as $rendu) {
        echo "<a href='rendus.php'>
                <p class='rendu'>
                    <strong>" . htmlspecialchars($rendu['titre']) . "</strong> le " . date('d/m', strtotime($rendu['date'])) . "
                </p>
              </a>";
    }
}
?>

        </div>


        <!-- Actualités -->
        <div class="widget actualites">
            <h2>Actualités</h2> <hr>
            <p>Un tournoi d'échecs est organisé du mardi 26 au mercredi 28 novembre...</p>
            <button>En savoir plus</button>
        </div>
    </div>
</section>
</body>

</html>