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
  <button class="toggle-menu" aria-label="Ouvrir le menu">
    <i class="fas fa-bars"></i>
  </button>
  <nav class="side-nav" role="navigation" aria-labelledby="menu-label">
    <h2 id="menu-label" class="sr-only">Menu de navigation</h2>
    <div class="logo">
      <img src="your-logo.png" alt="Logo de l'université" />
    </div>
    <ul class="menu">
      <!-- Accueil -->
      <li>
        <a href="accueil.php" class="menu-item" aria-label="Page d'accueil"> 
          <i class="fas fa-home" aria-hidden="true"></i>
          <span>Accueil</span>
        </a>
      </li>

      <!-- EDT -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Emploi du temps">
          <i class="fas fa-calendar-alt" aria-hidden="true"></i>
          <span>Emploi du temps</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="edt.php" role="menuitem"><span>Emploi du temps</span></a></li>
          <li><a href="absences.php" role="menuitem"><span>Absences</span></a></li> 
        </ul>
      </li>

      <!-- Messagerie -->      
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Messagerie">
          <i class="fas fa-comment-dots" aria-hidden="true"></i>
          <span>Messagerie</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="messagerie.php" role="menuitem"><span>Messagerie</span></a></li>
          <li><a href="annuaire.php" role="menuitem"><span>Annuaire</span></a></li>
        </ul>
      </li>

      <!-- Vie étudiante -->          
      <li>
        <a href="vieetudiante.php" class="menu-item" aria-label="Page vie étudiante">
          <i class="fas fa-users" aria-hidden="true"></i>
          <span>Vie étudiante</span>
        </a>
      </li>

      <!-- Réservations menu -->
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Réservations">
          <i class="fas fa-calendar-check" aria-hidden="true"></i>
          <span>Réservations</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="reserver.php" role="menuitem"><span>Réserver</span></a></li> 
          <li><a href="voir_reservations.php" role="menuitem"><span>Voir les réservations</span></a></li> 
        </ul>
      </li>

      <!-- Cours -->    
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Cours">
          <i class="fas fa-book" aria-hidden="true"></i>
          <span>Cours</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="elearning.php" role="menuitem"><span>Elearning</span></a></li> 
          <li><a href="archives.php" role="menuitem"><span>Archives</span></a></li> 
          <li><a href="rendus.php" role="menuitem"><span>Rendus</span></a></li>
          <li><a href="notes.php" role="menuitem"><span>Notes</span></a></li>
        </ul>
      </li>
    </ul>
    
    <!-- Deconnexion -->     
    <div class="logout">
      <a href="connexion.php" class="logout-button" aria-label="Se déconnecter">
        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        <span>Se déconnecter</span>
      </a>
    </div>
  </nav>

  <script src="script.js"></script>
</body>
</html>
