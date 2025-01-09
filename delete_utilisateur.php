<?php
require 'config.php'; // Fichier contenant la connexion à la base

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Vérifie si l'utilisateur existe
    $requete = "SELECT * FROM utilisateurs WHERE id = :id";
    $stmt = $db->prepare($requete);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        // Supprime l'utilisateur
        $requete = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $db->prepare($requete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Utilisateur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'utilisateur.";
        }
    } else {
        echo "Utilisateur introuvable.";
    }
} else {
    echo "Requête invalide.";
}

// Redirection après suppression (optionnel)
header("Location: affiche_users.php");
exit;
?>
