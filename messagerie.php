<?php 
    include('header.php');


// Récupérer les messages reçus par l'utilisateur connecté
$user_id = $_SESSION['id']; 

$query = "SELECT m.id, m.objet, m.date_envoi, u.nom AS expediteur_nom, u.prenom AS expediteur_prenom, m.is_read, m.is_archived
          FROM messages m
          JOIN utilisateurs u ON m.expediteur_id = u.id
          WHERE m.destinataire_id = :user_id AND m.is_archived = 0 
          ORDER BY m.date_envoi DESC";

$stmt = $db->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <title>ENT | Messagerie</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

<section class="page-messagerie" id="content">

<h1>Messagerie</h1>

  <div class="container-messagerie">

    <div class="sidebar">
        <a href="messagerie.php" class="active">Boîte de réception</a>
        <a href="envoi_msg.php">Nouveau message</a>
        <a href="messages_envoyes.php"><i class="fas fa-paper-plane"></i> Envoyés</a>
        <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
    </div>

    <div class="messages">
      <?php if (empty($messages)): ?>
        <p class="no-messages">Aucun message encore reçu.</p>
      <?php else: ?>
        <?php foreach ($messages as $message): ?>
          <a href="message.php?id=<?= $message['id'] ?>" class="message-item <?= $message['is_read'] ? 'read' : 'unread' ?>">
                <div class="message-info">
                    <strong><?= $message['expediteur_prenom'] . ' ' . $message['expediteur_nom'] ?></strong>
                    <p><?= $message['objet'] ?></p>
                </div>
                <div class="message-meta">
                    <span class="date"><?= date('d/m/Y', strtotime($message['date_envoi'])) ?></span>
                </div>

                  <!-- Icônes pour actions -->
                <div class="message-actions">
                    <i title="Supprimer" class="fas fa-trash delete" onclick="deleteMessage(<?= $message['id'] ?>, event)"></i>

                    <!-- Icône pour archiver ou désarchiver -->
                    <?php if ($message['is_archived'] == 0): ?>
                        <!-- Icone d'archivage si non archivé -->
                        <i title="Archiver" class="fas fa-archive archive" onclick="archiveMessage(<?= $message['id'] ?>, <?= $message['is_archived'] ?>, event)"></i>
                    <?php else: ?>
                        <!-- Icone de restauration si déjà archivé -->
                        <i title="Restaurer" class="fas fa-undo-alt archive" onclick="archiveMessage(<?= $message['id'] ?>, <?= $message['is_archived'] ?>, event)"></i>
                    <?php endif; ?>
                </div>

            </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>

</section>

</body>
</html>
