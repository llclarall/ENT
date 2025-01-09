<?php
include 'config.php';
 
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
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
</head>
<body>

<header>
    <a href="profil.php"><?=$user['prenom']?><img src="images/filler.png" alt=""></a>
</header>

</body>
</html>

