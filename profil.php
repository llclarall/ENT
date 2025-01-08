<?php
include('header.php');
include('nav.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Récupérer les informations de l'utilisateur
$id = $_SESSION['id'];
$requete = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($requete);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <a href="#">Voir plus</a>
    </div>
    <div class="absences block">
        <h3>Absences</h3>
        <div class="absence-item">
        <span>16/09/2024</span> <span>à justifier</span>
        </div>
        <div class="absence-item">
        <span>15/09/2024</span> <span>à justifier</span>
        </div>
        <div class="absence-item">
        <span>11/09/2024</span> <span>justifié</span>
        </div>
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
            <td>BUT MMI2 CREATION NUMERIQUE-Champs</td>
        </tr>
        <tr>
            <td>2023/2024</td>
            <td>BUT MMI1 DEVELOPPEMENT-Champs</td>
        </tr>
        </table>
    </div>
</div>
</section>

</body>
</html>