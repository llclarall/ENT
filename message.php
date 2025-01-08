<?php 
    include('header.php');
    include('nav.php');

// Récupérer l'ID du message
$message_id = $_GET['id'];

// Récupérer le message depuis la base de données
$query = "SELECT m.objet, m.message, m.date_envoi, u.nom AS expediteur_nom, u.prenom AS expediteur_prenom, u.mail AS expediteur_mail
          FROM messages m
          JOIN utilisateurs u ON m.expediteur_id = u.id
          WHERE m.id = :message_id";

$stmt = $db->prepare($query);
$stmt->execute(['message_id' => $message_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// Marquer le message comme lu
$query = "UPDATE messages SET is_read = 1 WHERE id = :message_id";
$stmt = $db->prepare($query);
$stmt->execute(['message_id' => $message_id]);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>ENT | Message</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-messagerie">

<h1>Messagerie</h1>

<div class="container-messagerie">

  <div class="sidebar">
    <a href="messagerie.php" class="active">Boîte de réception</a>
    <a href="envoi_msg.php">Nouveau message</a>
    <a href="messages_envoyes.php"><i class="fas fa-paper-plane"></i> Envoyés</a>
    <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
  </div>
  
  <div class="message-content">
    <a href="messagerie.php" class="back-link">
        <button id="back-button" class="back-button"><img src="images/back.png" alt="Retour en arrière" class="back-img"></button>
    </a>
    <strong class="sender-name"><?= $message['expediteur_prenom'] . ' ' . $message['expediteur_nom'] ?></strong>
    <p class="email"><?= $message['expediteur_mail'] ?></p>
    <p class="date-time"><?= date('d/m/Y à H:i', strtotime($message['date_envoi'])) ?></p>
    <p class="message-text"><?= nl2br($message['message']) ?></p>
    <div class="actions">
        <button class="action-button">Répondre</button>
        <button class="action-button">Transférer</button>
    </div>
</div>

</div>

</section>


</body>
</html>
