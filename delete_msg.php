<?php
include('config.php');

// Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Vérifier que l'ID du message est bien passé
if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    $user_id = $_SESSION['id'];

    $query = "SELECT * FROM messages WHERE id = :message_id AND user_id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->execute(['message_id' => $message_id, 'user_id' => $user_id]);
    $message = $stmt->fetch();

    if ($message) {
        $query = "DELETE FROM messages WHERE id = :message_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['message_id' => $message_id]);

        // Rediriger vers la boîte de réception après la suppression
        header('Location: messagerie.php');
        exit;
    } else {
        // Message non trouvé ou non autorisé
        echo "Erreur : Ce message n'existe pas ou vous n'êtes pas autorisé à le supprimer.";
    }
} else {
    // ID du message non spécifié
    echo "Erreur : Aucun message spécifié pour la suppression.";
}
?>
