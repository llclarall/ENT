<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    echo "Vous devez être connecté pour accéder à cette page.";
    echo '<br><a href="login.php"><button>Se connecter</button></a>';
    exit();
}

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=exo_films;charset=utf8', 'root', '');

// Récupérer les informations de l'utilisateur connecté
$requete = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($requete);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilisateur) {
    echo "Utilisateur non trouvé.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une photo de profil</title>
</head>
<body>
    <h2>Ajouter une photo de profil</h2>

    <p><strong>Nom :</strong> <?php echo ($utilisateur['nom']); ?></p>
    <p><strong>Prénom :</strong> <?php echo ($utilisateur['prenom']); ?></p>
    <p><strong>Email :</strong> <?php echo ($utilisateur['login']); ?></p>

    <!-- Formulaire pour uploader la photo -->
    <form action="ajout_photo.php" method="post" enctype="multipart/form-data">
        <label for="photo">Choisissez une photo (JPEG uniquement, max 1 Mo) :</label>
        <input type="file" id="photo" name="photo" accept="image/jpeg" required><br><br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
