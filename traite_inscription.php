<?php
require 'config.php';

// Fonction pour vérifier si le login existe déjà
function checkLoginExists($login, $db) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count > 0; // Retourne vrai si le login existe déjà
}

// Vérification des données POST
if (isset($_POST['role']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
    $role = $_POST['role'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Vérification si le login existe déjà
    $originalLogin = $login;
    $suffix = 1;

    while (checkLoginExists($login, $db)) {
        $login = $originalLogin . $suffix; // Ajoute un suffixe
        $suffix++;
    }

    // Si le rôle est étudiant, on génère le numéro étudiant
    if ($role == "etudiant") {
        $num_etudiant = $_POST['num_etudiant'];
    } else {
        $num_etudiant = 0; // Pas de numéro pour les professeurs
    }

    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = "INSERT INTO utilisateurs (login, mdp, nom, prenom, mail, num_etudiant, role, mdp_clair) 
                VALUES (:login, :mdp, :nom, :prenom, :mail, :num_etudiant, :role, :mdp_clair)";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $hashedPassword);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':mail', $email);
    $stmt->bindParam(':num_etudiant', $num_etudiant);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':mdp_clair', $password);

    if ($stmt->execute()) {
        echo "<script>
        alert('Inscription réussie ! Vous allez être redirigé vers la page des utilisateurs.');
        window.location.href = 'affiche_users.php';
      </script>";
    } else {
        echo "<script>
        alert('Erreur lors de l\'inscription. Veuillez réessayer.');
        window.location.href = 'inscription.php';
      </script>";
    }
} else {
    echo "Tous les champs doivent être remplis.";
}
?>
