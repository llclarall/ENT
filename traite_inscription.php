<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
require 'config.php';

// Vérification des données POST
if (isset($_POST['login']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $login = $_POST['login'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifier si les mots de passe correspondent
    if ($password === $confirmPassword) {
        // Hacher le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
    $requete = "INSERT INTO utilisateurs (login, mdp, nom, prenom) VALUES (:login, :mdp, :nom, :prenom)";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);

        if ($stmt->execute()) {
            echo "<script>
            alert('Inscription réussie ! Vous allez être redirigé vers la page de connexion.');
            window.location.href = 'index.php';
          </script>";;
        } else {
            echo "<script>
            alert('Erreur lors de l\'inscription. Veuillez réessayer.');
            window.location.href = 'inscription.php';
          </script>";
        }
    } else {
        echo "<script>
            alert('Les mots de passe ne correspondent pas');
            window.location.href = 'inscription.php';
          </script>";
    }
} else {
    echo "Tous les champs doivent être remplis.";
}
?>

</body>