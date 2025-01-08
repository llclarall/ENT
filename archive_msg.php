<?php
include('header.php');
include('nav.php');

if (isset($_GET['id']) && isset($_GET['new_status'])) {
    $message_id = $_GET['id'];
    $new_status = $_GET['new_status'];  // 1 pour archiver, 0 pour désarchiver

    // Récupérer l'état actuel du message
    $query = "SELECT is_archived FROM messages WHERE id = :message_id";
    $stmt = $db->prepare($query);
    $stmt->execute(['message_id' => $message_id]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($message) {
        // Mettre à jour l'état du message (archiver ou désarchiver)
        $query = "UPDATE messages SET is_archived = :new_status WHERE id = :message_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['new_status' => $new_status, 'message_id' => $message_id]);

        // Rediriger vers la boîte de réception après l'archivage ou désarchivage
        header('Location: messagerie.php');
        exit;
    } else {
        echo "Erreur : Ce message n'existe pas.";
    }
} else {
    echo "Erreur : Aucun message spécifié pour l'archivage.";
}
?>
