<?php 
    include('header.php');
    include('config.php');
    include('nav.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <title>Détails du message</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container-messagerie">    
<div class="sidebar">
  <button class="active">Boîte de réception</button>
  <button>Nouveau message</button>
  <button><i class="fas fa-paper-plane"></i> Envoyés</button>
  <button><i class="fas fa-archive"></i> Archivés</button>
</div>

 <main class="message-content">
 <a href="messagerie.php" class="back-link">
      <button id="back-button" class="back-button">Retour</button>
    </a>
    <strong class="sender-name">G. Charpentier</strong>
    <p class="email">gaelle.charpentier@univ-eiffel.fr</p>
    <p class="date-time">10/12/2024 à 14h36</p>
    <p class="message-text">Le prochain QCM sera le 29 novembre 2024</p>
    <div class="actions">
      <button class="action-button">Répondre</button>
      <button class="action-button">Transférer</button>
    </div>
  </main>
  </div>
</body>
</html>
