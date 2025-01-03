<?php
include('header.php');
include('config.php');
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

// Récupérer les rendus de l'utilisateur
$requete = "SELECT * FROM rendus";
$stmt = $db->prepare($requete);
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENT | Rendus</title>
</head>
<body>

<section class="page-rendus">

    <h1>Rendus</h1>
    
    <br>
    <div class="rendus-container">

        <div class="ajouter-rendu">
            <span>+</span>
        </div>

        <div class="rendu-card">
            <?php foreach ($rendus as $rendu): ?>
                <h2><?= $rendu['titre'] ?></h2>
                <p class="description"><?= $rendu['description'] ?></p>
                <p>Pour le <?= $rendu['date'] ?></p>

                <div class="etats">
                    <button class="etat a-faire">Pas commencé</button>
                    <button class="etat en-cours">En cours</button>
                    <button class="etat fait">Terminé</button>
                </div>

            <a href="rendu.php">Consulter et déposer</a>
            <?php endforeach; ?>
        </div>
    </div>

</section>
    
</body>
</html>