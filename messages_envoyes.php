    <?php
    include('header.php');

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
    }

    // Récupérer les messages envoyés par l'utilisateur connecté
    $expediteur_id = $_SESSION['id'];

    $query = "SELECT m.id, m.objet, m.message, m.date_envoi, u.prenom, u.nom 
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

    <section class="page-messagerie" id="content">
    <h1>Messages envoyés</h1>

    <div class="container-messagerie envoyes">
    <!-- Barre latérale -->
    <div class="sidebar">
        <a href="messagerie.php" aria-label="Boîte de réception">Boîte de réception</a>
        <a href="envoi_msg.php" aria-label="Nouveau message">Nouveau message</a>
        <a href="messages_envoyes.php" class="active" aria-label="Messages envoyés"><i class="fas fa-paper-plane"></i> Envoyés</a>
        <a href="messages_archives.php" aria-label="Messages archivés"><i class="fas fa-archive"></i> Archivés</a>
    </div>

    <!-- Liste des messages envoyés -->
    <div class="messages">
        <?php if (!empty($messages_envoyes)): ?>
            <?php foreach ($messages_envoyes as $message): ?>
                <a href="message_details.php?id=<?= $message['id'] ?>" class="message-item">
                    <div class="message-info">
                        <span><strong>À :</strong> <?= ($message['prenom'] . " " . $message['nom']) ?></span>
                        <p><strong>Objet :</strong> <?= ($message['objet']) ?></p>
                    </div>
                    <div class="message-meta"><span class="date"><?= htmlspecialchars(date('d/m/Y', strtotime($message['date_envoi']))) ?></span></div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-messages">
                Vous n'avez pas encore envoyé de messages.
            </div>
        <?php endif; ?>
    </div>
    </div>
    </section>


    <?php include('footer.php');?>

    
    </body>
    </html>
