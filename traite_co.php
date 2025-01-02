<?php
require 'config.php';
$db->query('SET NAMES utf8');

// Vérification des données POST
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = htmlspecialchars(trim($_POST['login'])); // Nettoyer l'entrée
    $password = $_POST['password'];

    // Requête pour vérifier si le login existe
    $requete = "SELECT * FROM utilisateurs WHERE login = :login";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    // Récupérer les données utilisateur
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user['mdp'])) {
        // Créer des variables de session pour l'utilisateur
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['num_etudiant'] = $user['num_etudiant'];
        $_SESSION['mail'] = $user['mail'];
        $_SESSION['formation'] = $user['formation'];

        // Rediriger vers la page d'accueil ou une autre page sécurisée
        header("Location: accueil.php");
        exit();
    } else {
        // Mot de passe incorrect ou utilisateur introuvable
        header("Location: index.php?erreur=login");
        exit();
    }
} else {
    // Si le formulaire n'est pas soumis correctement
    header("Location: index.php?erreur=login");
    exit();
}
?>