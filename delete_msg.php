<?php
include('config.php');

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Vérifier que l'ID du message est bien passé
if (isset($_GET['id'])) {
    $message_id = $_GET['id'];
    $user_id = $_SESSION['id'];  

    $query = "SELECT * FROM messages WHERE id = :message_id AND destinataire_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->execute(['message_id' => $message_id, 'user_id' => $user_id]);
    $message = $stmt->fetch();

    if ($message) {
        // Si le message existe et appartient à l'utilisateur, on le supprime
        $query = "DELETE FROM messages WHERE id = :message_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['message_id' => $message_id]);

        header('Location: messagerie.php');
        exit;
    } else {
        echo "Erreur : Ce message n'existe pas ou vous n'êtes pas autorisé à le supprimer.";
    }
} else {
    echo "Erreur : Aucun message spécifié pour la suppression.";
}
?>
