<?php
include('header.php');
include('nav.php');

// Récupérer l'id de l'utilisateur
$user_id = $_SESSION['id'];

try {
    // Récupérer les absences de l'utilisateur, avec un filtre pour la justification
    $absences_requete = $db->prepare("
    SELECT * FROM absences 
    WHERE user_id = :user_id 
    ORDER BY 
        CASE 
            WHEN statut = 'À justifier' THEN 1
            ELSE 2
        END, 
        date_absence DESC
");
$absences_requete->execute(['user_id' => $user_id]);
$absences = $absences_requete->fetchAll(PDO::FETCH_ASSOC);

    // Limiter l'affichage à 2 absences non justifiées
    $limite = 2;
    $limited_absences = array_slice($absences, 0, $limite);
    $has_more_than_two = count($absences) > 2;
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
    $absences = [];
    $limited_absences = [];
    $has_more_than_two = false;
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ENT | Profil</title>
</head>
<body>

<section class="page-profil">

<h1>Profil</h1>

<div class="profil-container">

    <div class="profil-header block">
        <div class="profil-picture ">
            <img src="images/filler.png" alt="Profile Picture">
        </div>
        <div class="profil-info">
            <h2><?= $user['prenom']?> <?= $user['nom']?></h2> <br>
            <p>BUT MMI - Deuxième année</p>
        </div>
    </div>

    <div class="profil-qr">
        <img src="images/carte.png" alt="QR Code">
    </div>
    <div class="shortcuts">
        <a href="notes.php">Notes</a>
        <a href="edt.php">Emploi du temps</a>
    </div>


    <div class="reservations block">
        <h3>Mes réservations</h3>
        <div class="reservation-item">
        <span>OSMO Le vendredi 15 novembre 2024</span>
        </div>
        <div class="reservation-item">
        <span>OSMO Le vendredi 15 novembre 2024</span>
        </div>
        <div class="reservation-item">
        <span>OSMO Le vendredi 15 novembre 2024</span>
        </div>
        <a href="absences.php" class="voir-plus">Voir plus</a>
    </div>


<!-- Section Absences -->
    <div class="absences block">
        <h3>Absences</h3>
        <?php if (empty($limited_absences)): ?>
            <p>Pas encore d'absences</p>
        <?php else: ?>
            <?php foreach ($limited_absences as $absence) {
                echo "<div class='absence-item " . ($absence['statut'] == 'À justifier' ? 'red-border' : '') . "'>";
                echo "<span>" . date('d/m/Y H:i', strtotime($absence['date_absence'])) . "</span> ";
                
                if ($absence['statut'] == 'À justifier') {
                    echo "<form method='POST' action='justifier_absence.php'>";
                    echo "<input type='hidden' name='absence_id' value='" . $absence['id'] . "'>";
                    echo "<a href='absences.php' type='submit' class='justifier-button'>Justifier</a>";
                    echo "</form>";
                } else {
                    echo "<span>" . $absence['statut'] . "</span>";
                }
                echo "</div>";
            } ?>
            
            <!-- Bouton "Voir plus" si l'utilisateur a plus de 2 absences -->
            <?php if ($has_more_than_two): ?>
                <a href="absences.php" class="voir-plus">Voir plus</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>


    <div class="documents block">
        <h3>Mes documents administratifs</h3>
        <table>
        <tr>
            <td>Années</td>
            <td>Filière d’inscription</td>
        </tr>
        <tr>
            <td>2024/2025</td>
            <td>BUT MMI2 DEVELOPPEMENT - Champs</td>
        </tr>
        <tr>
            <td>2023/2024</td>
            <td>BUT MMI1 - Champs</td>
        </tr>
        </table>

        <table>
        <tr>
            <td>Années</td>
            <td>Bulletins</td>
        </tr>
        <tr>
            <td>2024/2025</td>
            <td>Semestres 3 et 4</td>
        </tr>
        <tr>
            <td>2023/2024</td>
            <td>Semestres 1 et 2</td>
        </tr>
        </table>

        <table>
        <tr>
            <td>Certificat de scolarité</td>
            <td>Voir</td>
        </tr>
        </table>

    </div>

</div>
</section>

</body>
</html>