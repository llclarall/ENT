<?php
include('header.php');
include('nav.php');

// Récupérer les messages envoyés par l'utilisateur connecté
$expediteur_id = $_SESSION['id']; // Identifiant de l'utilisateur connecté
$query = "SELECT m.objet, m.message, m.date_envoi, u.prenom, u.nom 
    FROM messages AS m 
    JOIN utilisateurs AS u ON m.destinataire_id = u.id
    WHERE m.expediteur_id = :expediteur_id
    ORDER BY m.date_envoi DESC";
$stmt = $db->prepare($query);
$stmt->execute(['expediteur_id' => $expediteur_id]);
$messages_envoyes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Messages envoyés</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-messagerie">
<h1>Messages envoyés</h1>

<div class="container-messagerie envoyes">

    <div class="sidebar">
        <a href="messagerie.php">Boîte de réception</a>
        <a href="envoi_msg.php">Nouveau message</a>
        <a href="messages_envoyes.php" class="active"><i class="fas fa-paper-plane"></i> Envoyés</a>
        <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
    </div>

    <div class="message-content">
        <?php if (!empty($messages_envoyes)): ?>
            <ul class="message-list">
                <?php foreach ($messages_envoyes as $message): ?>
                    <li class="message-item">
                        <div class="message-header">
                            <span><strong>À :</strong> <?= htmlspecialchars($message['prenom'] . " " . $message['nom']) ?></span> <br>
                            <span><strong>Objet :</strong> <?= htmlspecialchars($message['objet']) ?></span>
                        </div> <br>
                        <span class="date"><?= htmlspecialchars(date('d/m/Y', strtotime($message['date_envoi']))) ?></span>
                        
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="no-messages">
                Vous n'avez pas encore envoyé de messages.
            </div>
        <?php endif; ?>
    </div>
</div>
</section>
</body>
</html>
