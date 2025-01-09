<?php
include 'config.php';
 
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Récupérer les informations de l'utilisateur
$id = $_SESSION['id'];
$requete = "SELECT * FROM utilisateurs WHERE id = :id";
$stmt = $db->prepare($requete);
$stmt->bindParam(':id', $id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
  />
</head>
<body>

<header>
    <a href="profil.php"><?=$user['prenom']?><img src="images/filler.png" alt=""></a>
</header>

  <button class="toggle-menu" aria-label="Ouvrir le menu">
    <i class="fas fa-bars"></i>
  </button>

  <nav class="side-nav" role="navigation" aria-labelledby="menu-label">
    <h2 id="menu-label" class="sr-only">Menu de navigation</h2>
    <div class="logo">
      <a href="accueil.php"><img src="images/logo.png" alt="Accueil ENT" /></a>
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


      <!-- Réservations menu -->
      <li>
        <a href="#" class="menu-item dropdown-toggle" aria-expanded="false" aria-label="Réservations">
          <i class="fas fa-calendar-check" aria-hidden="true"></i>
          <span>Réservations</span>
        </a>
        <ul class="dropdown" role="menu">
          <li><a href="reserver.php" role="menuitem"><span>Réserver</span></a></li> 
          <li><a href="mes_reservations.php" role="menuitem"><span>Mes réservations</span></a></li> 
        </ul>
      </li>

      
      <!-- Vie étudiante -->          
      <li>
        <a href="vie_etudiante.php" class="menu-item" aria-label="Page vie étudiante">
          <i class="fas fa-users" aria-hidden="true"></i>
          <span>Vie étudiante</span>
        </a>
      </li>

    </ul>
    
    <!-- Deconnexion -->     
    <div class="logout">
      <a href="deconnect.php" class="logout-button" aria-label="Se déconnecter">
        <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        <span>Se déconnecter</span>
      </a>
    </div>
  </nav>

  <script src="script.js"></script>
</body>
</html>
