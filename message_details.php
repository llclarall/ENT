<?php 
include('header.php');

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer l'ID du message à partir des paramètres GET
$message_id = $_GET['id'] ?? null;

if (!$message_id) {
    echo "<p>Message introuvable.</p>";
    exit;
}

// Récupérer les détails du message envoyé
$query = "SELECT m.objet, m.message, m.date_envoi, u.nom AS destinataire_nom, u.prenom AS destinataire_prenom, u.mail AS destinataire_mail
          FROM messages m
          JOIN utilisateurs u ON m.destinataire_id = u.id
          WHERE m.id = :message_id AND m.expediteur_id = :expediteur_id";

$stmt = $db->prepare($query);
$stmt->execute([
    'message_id' => $message_id,
    'expediteur_id' => $_SESSION['id'] // Identifiant de l'utilisateur connecté
]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si le message existe et appartient à l'utilisateur
if (!$message) {
    echo "<p>Message introuvable ou accès non autorisé.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>Détails du message envoyé</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-messagerie">
<h1>Message envoyé</h1>

<div class="container-messagerie" id="content">

  <div class="sidebar">
    <a href="messagerie.php">Boîte de réception</a>
    <a href="envoi_msg.php">Nouveau message</a>
    <a href="messages_envoyes.php" class="active"><i class="fas fa-paper-plane"></i> Envoyés</a>
    <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
  </div>
  
  <div class="message-content">
    <a href="javascript:history.back()" class="back-link">
        <button id="back-button" class="back-button"><img src="images/back.png" alt="Retour en arrière" class="back-img"></button>
    </a>
    <strong class="sender-name"><?= htmlspecialchars($message['destinataire_prenom'] . ' ' . $message['destinataire_nom']) ?></strong>
    <p class="email"><?= htmlspecialchars($message['destinataire_mail']) ?></p>
    <p class="date-time"><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($message['date_envoi']))) ?></p>
    <hr>
    <p class="message-text"><?= nl2br(htmlspecialchars($message['message'])) ?></p>
  </div>

</div>
</section>

</body>
</html>
