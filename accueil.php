<?php 
include('header.php');


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




// Récupérer le total des heures d'absences non justifiées pour l'utilisateur connecté
$user_id = $_SESSION['id'];

try {
$requete_non_justifiees = $db->prepare("
    SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duree))) AS total_non_justifiees
    FROM absences 
    WHERE user_id = :user_id AND (statut = 'À justifier' OR statut = 'Rejeté | Rejustifier' OR statut = 'En attente de validation')
");
$requete_non_justifiees->execute(['user_id' => $user_id]);
$result_non_justifiees = $requete_non_justifiees->fetch(PDO::FETCH_ASSOC);

// Calcul du total des heures non justifiées
if ($result_non_justifiees && !empty($result_non_justifiees['total_non_justifiees'])) {
    $seconds_non_justifiees = strtotime($result_non_justifiees['total_non_justifiees']) - strtotime('TODAY'); 
    $hours_non_justifiees = floor($seconds_non_justifiees / 3600); 
    $minutes_non_justifiees = floor(($seconds_non_justifiees % 3600) / 60); 

    if ($hours_non_justifiees > 0 && $minutes_non_justifiees > 0) {
        $total_non_justifiees = $hours_non_justifiees . 'h' . $minutes_non_justifiees; 
        
    } elseif ($hours_non_justifiees > 0) {
        $total_non_justifiees = $hours_non_justifiees . 'h';
    } else {
        $total_non_justifiees = $minutes_non_justifiees . 'min';
    }
} else {
    $total_non_justifiees = '0h'; 
}
} catch (PDOException $e) {
echo "Erreur : " . $e->getMessage();
$total_non_justifiees = 'Erreur';
}

$numeric_value = preg_replace('/[^0-9]/', '', $total_non_justifiees); // Supprime les caractères non numériques

// si le nb d'absences à justifier est supérieur à 0, ajouter une classe pour afficher une bordure rouge
$borderClass = ($numeric_value > 0) ? 'red-border' : '';





// Récupérer le nombre de messages non lus pour l'utilisateur connecté
$user_id = $_SESSION['id'];

$query = "SELECT COUNT(*) AS unread_count
          FROM messages
          WHERE destinataire_id = :user_id AND is_read = 0 AND is_archived = 0";

$stmt = $db->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$unread_count = $result['unread_count'];

// Logique pour afficher ou non l'icône d'avertissement
$alertMsg = ($unread_count > 0) ? "display" : "none";




// Requête pour vérifier les notes non consultées
$num_etudiant = $_SESSION['num_etudiant'];

$query = "SELECT COUNT(*) AS new_count 
          FROM notes n 
          JOIN utilisateurs u ON n.etudiant_num = u.num_etudiant 
          WHERE n.consulted = 0 AND u.num_etudiant = :num_etudiant";

$stmt = $db->prepare($query);
$stmt->bindParam(':num_etudiant', $num_etudiant, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$new_note_count = (int)$result['new_count'];

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
    
<section class="accueil" id="content">
    
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
                        <div class="widget sub-block <?= $borderClass ?>">
                            <span class="big"><?= $total_non_justifiees ?></span> <br>
                            <span>non justifiées</span>
                        </div>
                    </a>
                </div>

                <div class="notes">
                    <h3><i class="fa-solid fa-heart"></i> Notes</h3>
                    <a href="notes.php?mark_as_read=1">
                        <div class="widget sub-block <?= $new_note_count > 0 ? 'new-notes' : '' ?> note">
                            <?php if ($new_note_count > 0): ?>
                                <span class="new-indicator "><div class="big"><?= $new_note_count ?></div> nouvelle(s) note(s)!</span>
                            <?php else: ?>
                                <span>Aucune nouvelle note</span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>



                <div class="reservations">
                    <h3><i class="fa-solid fa-bookmark"></i> RSVP</h3>
                    <a href="mes_reservations.php">
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
                <h2><i class="fa-solid fa-circle-exclamation" style="display: <?= $alertMsg ?>;"></i> Derniers messages </h2><hr>
                <?php if ($unread_count > 0): ?>
                    <p>Vous avez <?= $unread_count ?> message(s) non lu(s)</p>
                <?php else: ?>
                    <p>Aucun nouveau message</p>
                <?php endif; ?>
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
                    <strong>" . htmlspecialchars($rendu['titre']) . "</strong> pour le " . date('d/m', strtotime($rendu['date'])) . "
                </p>
                <img src='images/pin.png' alt='Rendu épinglé' class='pin-icon' title='Rendu épinglé'>
              </a>";
    } else {
        echo "<a href='rendus.php'>
                <p class='rendu'>
                    <strong>" . htmlspecialchars($rendu['titre']) . "</strong> pour le " . date('d/m', strtotime($rendu['date'])) . "
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
            <h2>Vie étudiante</h2> <hr>
            <p>Un tournoi d'échecs est organisé du mardi 26 au mercredi 28 novembre...</p>
            <a href="vie_etudiante.php" class="btn">En savoir plus</a>
        </div>
    </div>

</section>

<?php include('footer.php');?>

</body>

</html>