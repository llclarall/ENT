<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nav</title>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="side-nav">
    <div class="logo">
      <img src="your-logo.png" alt="Logo" />
    </div>
    <ul class="menu">

        <!-- Acceuil -->
      <li>
        <a href="accueil.php" class="menu-item"> 
          <i class="fas fa-home"></i>
          <span>Accueil</span>
        </a>
      </li>

        <!-- EDT -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle"> 
          <i class="fas fa-calendar-alt"></i>
          <span>Emploi du temps</span>
        </a>
        <ul class="dropdown">
          <li><a href="edt.php"><i class="fas fa-calendar-week"></i> <span>Emploi du temps</span></a></li>
          <li><a href="absences.php"><i class="fas fa-times-circle"></i> <span>Absences</span></a></li> 
        </ul>
      </li>

       <!-- Messagerie -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle">
          <i class="fas fa-comment-dots"></i>
          <span>Messagerie</span>
        </a>
        <ul class="dropdown">
          <li><a href="messagerie.php"><i class="fas fa-inbox"></i> <span>Messagerie</span></a></li>
          <li><a href="annuaire.php"><i class="fas fa-address-book"></i> <span>Annuaire</span></a></li>
        </ul>
      </li>

       <!-- Vie étudiante -->          
      <li>
        <a href="vieetudiante.php" class="menu-item">
          <i class="fas fa-users"></i>
          <span>Vie étudiante</span>
        </a>
      </li>
      
      <!-- Réservations menu -->
      <li>
        <a href="#" class="menu-item dropdown-toggle">
          <i class="fas fa-calendar-check"></i>
          <span>Réservations</span>
        </a>
        <ul class="dropdown">
          <li><a href="reserver.php"><i class="fas fa-calendar-plus"></i> <span>Réserver</span></a></li> 
          <li><a href="voir_reservations.php"><i class="fas fa-calendar-day"></i> <span>Voir les réservations</span></a></li> 
        </ul>
      </li>
      
       <!-- Cours -->    
      <li>
        <a href="#" class="menu-item dropdown-toggle">
          <i class="fas fa-book"></i>
          <span>Cours</span>
        </a>
        <ul class="dropdown">
          <li><a href="elearning.php"><i class="fas fa-laptop"></i> <span>Elearning</span></a></li> 
          <li><a href="archives.php"><i class="fas fa-archive"></i> <span>Archives</span></a></li> 
          <li><a href="rendus.php"><i class="fas fa-file-upload"></i> <span>Rendus</span></a></li>
          <li><a href="notes.php"><i class="fas fa-graduation-cap"></i> <span>Notes</span></a></li>
        </ul>
      </li>
    </ul>
    
       <!-- Deconnexion -->     
    <div class="logout">
      <a href="connexion.php" class="logout-button">
        <i class="fas fa-sign-out-alt"></i>
        <span>Se déconnecter</span>
      </a>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
