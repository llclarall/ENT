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
$requete = "SELECT * FROM rendus WHERE fk_user = :fk_user OR fk_user = '0'";
$stmt = $db->prepare($requete);

// Lier l'id de l'utilisateur à la requête
$stmt->bindParam(':fk_user', $id, PDO::PARAM_INT);

// Exécuter la requête
$stmt->execute();
$rendus = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $date = $_POST['date']; // Date au format datetime-local

    // Si l'utilisateur est connecté, on ajoute fk_user
    $fk_user = $_SESSION['id'];

    // Requête pour insérer un rendu
    $requete = "INSERT INTO rendus (titre, description, date, fk_user) VALUES (:titre, :description, :date, :fk_user)";
    $stmt = $db->prepare($requete);

    // Lier les paramètres
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':fk_user', $fk_user);

    // Exécuter la requête
    if ($stmt->execute()) {
        header("Location: rendus.php"); // Rediriger vers la page des rendus après l'ajout
        exit();
    } else {
        echo "Erreur lors de l'ajout du rendu.";
    }
}
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

    <!-- Bouton d'ajout de rendu -->
    <div class="ajouter-rendu" id="openModalBtn">
        <img src="images/ajouter.png" alt="">
        <p>Ajouter un rendu</p>
    </div>


    <!-- Modale -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h2>Ajouter un Rendu</h2>
            
            <!-- Formulaire pour ajouter un rendu -->
            <form id="addRenduForm" method="POST" action="rendus.php">
                <label for="titre" required>Titre</label>
                <input type="text" id="titre" name="titre" required>

                <label for="description">Description</label>
                <textarea id="description" name="description"></textarea>

                <label for="date">Date</label>
                <input type="datetime-local" id="date" name="date" required>

                <button type="submit">Ajouter</button>
            </form>
        </div>
    </div>


    <!-- Rendu Card --> 
    <?php foreach ($rendus as $rendu): ?>
        <div class="rendu-card">
            <h2><?= $rendu['titre'] ?></h2>
            <p class="description"><?= $rendu['description'] ?></p>
            <p>
                <?php 
                $dateTime = new DateTime($rendu['date']); 
                echo "Pour le " . $dateTime->format('d/m/y') . " à " . $dateTime->format('H\hi');
                ?>
            </p>

            <div class="etats">
                <button class="etat a-faire">Pas commencé</button>
                <button class="etat en-cours">En cours</button>
                <button class="etat fait">Terminé</button>
            </div>

            <a href="rendu.php">Consulter et déposer</a> 
        </div>
    <?php endforeach; ?>

</div>


</section>
    
</body>
</html>