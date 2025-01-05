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
  <title>Messagerie</title>
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

    <div class="messages">
      <a href="message1.php"class="message-item">
        <div class="message-info">
          <strong>G. Charpentier</strong>
          <p>Le prochain QCM sera...</p>
        </div>
        <div class="message-meta">
          <span class="date">10/12/2024</span>
        </div>
        </a>

        <a href="message1.php"class="message-item">
        <div class="message-info">
          <strong>G. Charpentier</strong>
          <p>Le prochain QCM sera...</p>
        </div>
        <div class="message-meta">
          <span class="date">10/12/2024</span>
        </div>
        </a>


        <a href="message1.php"class="message-item">
        <div class="message-info">
          <strong>G. Charpentier</strong>
          <p>Le prochain QCM sera...</p>
        </div>
        <div class="message-meta">
          <span class="date">10/12/2024</span>
        </div>
        </a>

    </div>
  </div>
</body>
</html>
