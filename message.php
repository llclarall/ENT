<?php 
include('header.php');

// Récupérer l'ID du message
$message_id = $_GET['id'];

// Récupérer le message depuis la base de données
$query = "SELECT m.objet, m.message, m.date_envoi, m.expediteur_id, u.nom AS expediteur_nom, u.prenom AS expediteur_prenom, u.mail AS expediteur_mail
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



// Vérifier si le formulaire de réponse est soumis
if (isset($_POST['response_message'])) {
  // Récupérer l'ID de l'utilisateur actuel
  $user_id = $_SESSION['id']; 

  $response_message = $_POST['response_message'];

  // Vérifier si l'ID de l'expéditeur est bien récupéré
  if (isset($message['expediteur_id'])) {
      $destinataire_id = $message['expediteur_id'];
  } else {
      die('Erreur : destinataire non trouvé.');
  }

  // Insérer la réponse dans la base de données
  $insert_query = "INSERT INTO messages (objet, message, expediteur_id, destinataire_id, date_envoi) 
                   VALUES (:objet, :message, :expediteur_id, :destinataire_id, NOW())";
  $stmt = $db->prepare($insert_query);
  $result = $stmt->execute([
      'objet' => 'Re: ' . $message['objet'], // Préfixe 'Re:' pour indiquer une réponse
      'message' => $response_message,
      'expediteur_id' => $user_id,
      'destinataire_id' => $destinataire_id
  ]);

  // Vérifier si l'insertion a réussi
  if ($result) {
      echo "<script>
              alert('Votre réponse a été envoyée avec succès !');
              window.location.href = 'messagerie.php';
            </script>";
      exit;
  } else {
      // Afficher une alerte en cas d'erreur
      echo "<script>
              alert('Une erreur est survenue lors de l\'envoi de votre réponse. Veuillez réessayer.');
                window.location.href = 'messagerie.php';
            </script>";
      exit;
  }
}



// Vérification du transfert
if (isset($_POST['transfer_user_id'])) {
  $transfer_user_id = $_POST['transfer_user_id'];

  // Vérifier si l'ID du destinataire est valide
  if (!empty($transfer_user_id)) {
      $user_id = $_SESSION['id']; // ID de l'utilisateur actuel

      // Préparer la requête pour insérer le message transféré
      $insert_query = "INSERT INTO messages (objet, message, expediteur_id, destinataire_id, date_envoi) 
                       VALUES (:objet, :message, :expediteur_id, :destinataire_id, NOW())";
      $stmt = $db->prepare($insert_query);

      // Exécuter la requête d'insertion
      $result = $stmt->execute([
          'objet' => 'Transfert: ' . $message['objet'], 
          'message' => $message['message'],
          'expediteur_id' => $user_id,
          'destinataire_id' => $transfer_user_id
      ]);

      // Vérifier si l'insertion a réussi
      if ($result) {
          echo "<script>
                  alert('Le message a été transféré avec succès !');
                  window.location.href = 'messagerie.php';
                </script>";
      } else {
          // Afficher une alerte en cas d'erreur
          echo "<script>
                  alert('Une erreur est survenue lors du transfert du message. Veuillez réessayer.');
                  window.location.href = 'messagerie.php';
                </script>";
      }
  } else {
      // ID du destinataire manquant
      echo "<script>
              alert('Le destinataire n\'a pas été sélectionné. Veuillez choisir un destinataire pour le transfert.');
              window.location.href = 'messagerie.php';
            </script>";
      exit;
  }
}



// Récupérer les utilisateurs sauf l'expéditeur
$query_users = "SELECT id, CONCAT(prenom, ' ', nom) AS fullname FROM utilisateurs WHERE id != :expediteur_id";
$stmt = $db->prepare($query_users);
$stmt->execute(['expediteur_id' => $message['expediteur_id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>ENT | Message</title>
  <link rel="stylesheet" href="styles.css">
  <script>
    // Fonction JavaScript pour afficher ou cacher le formulaire de réponse
    function showResponseForm() {
      var form = document.getElementById("response-form");
      if (form.style.display === "block") {
        form.style.display = "none";
      } else {
        form.style.display = "block";
      }
    }

    // Fonction JavaScript pour afficher ou cacher le formulaire de transfert
    function showTransferForm() {
      var form = document.getElementById("transfer-form");
      if (form.style.display === "block") {
        form.style.display = "none";
      } else {
        form.style.display = "block";
      }
    }
  </script>
</head>
<body>

<section class="page-messagerie">

<h1>Messagerie</h1>




<div class="container-messagerie" id="content">

  <div class="sidebar">
    <a href="messagerie.php" class="active">Boîte de réception</a>
    <a href="envoi_msg.php">Nouveau message</a>
    <a href="messages_envoyes.php"><i class="fas fa-paper-plane"></i> Envoyés</a>
    <a href="messages_archives.php"><i class="fas fa-archive"></i> Archivés</a>
  </div>
  
  <div class="message-content">


    <a href="javascript:history.back()" class="back-link">
      <button id="back-button" class="back-button"><img src="images/back.png" alt="Retour en arrière" class="back-img"></button>
    </a>
    <strong class="sender-name"><?= $message['expediteur_prenom'] . ' ' . $message['expediteur_nom'] ?></strong>
    <p class="email"><?= $message['expediteur_mail'] ?></p>
    <p class="date-time"><?= date('d/m/Y à H:i', strtotime($message['date_envoi'])) ?></p>
    <p class="subject">Objet : <?= $message['objet'] ?></p>
    <hr>
    <p class="message-text"><?= nl2br($message['message']) ?></p>

    <!-- Bouton pour afficher le formulaire de réponse -->
    <button class="action-button" onclick="showResponseForm()">Répondre</button>

    <!-- Formulaire pour répondre, caché par défaut -->
    <form action="" method="post" id="response-form" style="display:none;" class="response-form">
        <textarea name="response_message" required placeholder="Écrire votre réponse ici..."></textarea>
        <button type="submit" class="submit-button">Envoyer la réponse</button>
    </form>

    <!-- Bouton pour afficher le formulaire de transfert -->
    <button class="action-button" onclick="showTransferForm()">Transférer</button>

    <!-- Formulaire pour transférer le message, caché par défaut -->
    <form action="" method="post" id="transfer-form" style="display:none;" class="transfer-form">
    <label for="transfer_user_id">Transférer à :</label>
    <select name="transfer_user_id" id="transfer_user_id" required>
        <option value="">Sélectionner un destinataire</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>"><?= $user['fullname'] ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="submit-button">Transférer le message</button>
</form>


  </div>

</div>

</section>

</body>
</html>
