<?php
include('header.php');
include('nav.php');

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];
    
    // Marquer le message comme archivé dans la base de données
    $query = "UPDATE messages SET is_archived = 1 WHERE id = :message_id";
    $stmt = $db->prepare($query);
    $stmt->execute(['message_id' => $message_id]);

    // Rediriger vers la boîte de réception après l'archivage
    header('Location: messagerie.php');
    exit;
}
?>
